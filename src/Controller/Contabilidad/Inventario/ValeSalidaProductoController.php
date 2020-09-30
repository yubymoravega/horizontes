<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Config\UnidadMedida;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use App\Form\Contabilidad\Inventario\ValeSalidaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ValeSalidaProductoController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/vale-salida-producto")
 */
class ValeSalidaProductoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_vale_salida_producto", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);

        $year_ = Date('Y');
        $vale_salida_arr = $vale_salida_er->findBy(array(
            'activo' => true,
            'anno' => $year_
        ));
        $rows = [];
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        foreach ($vale_salida_arr as $obj_vale_salida) {
            /**@var $obj_vale_salida ValeSalida* */

            if ($obj_vale_salida->getIdDocumento()->getIdAlmacen()->getId() == $idalmacen) {
                $obj_documento = $obj_vale_salida->getIdDocumento();
                $rows[] = array(
                    'id' => $obj_vale_salida->getId(),
                    'concecutivo' => $obj_vale_salida->getNroConsecutivo(),
                    'importe' => number_format($obj_documento->getImporteTotal(), 2, '.', ''),
                    'fecha' => $obj_documento->getFecha()->format('d-m-Y'),
                    'deudora' => $obj_vale_salida->getNroCuentaDeudora()
                );
            }
        }
        return $this->render('contabilidad/inventario/vale_salida_producto/index.html.twig', [
            'controller_name' => 'ValeSalidaController',
            'vales' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-vales-salida", name="contabilidad_inventario_vale_salida_producto_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $vale_salida_er, $year_, $id_usuario, $idalmacen, ['producto' => true], 'ValeSalida');
        $arr_obj_eliminado = $vale_salida_er->findBy(array(
            'anno' => $year_,
            'activo' => false,
            'producto' => true
        ));
        $arr_eliminados = [];
        foreach ($arr_obj_eliminado as $key => $eliminado) {
            /**@var $eliminado ValeSalida** */
            $arr_eliminados[$key] = $eliminado->getNroConsecutivo();
        }
        return new JsonResponse(['nros' => $row, 'eliminados' => $arr_eliminados, 'success' => true]);
    }

    /**
     * @Route("/getProductos/{codigo}", name="contabilidad_inventario_vale_salida_producto_gestionar_getProductos", methods={"POST"})
     */
    public function getProductos(Request $request, $codigo)
    {

        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1 || $codigo == '-1')
            $productos_arr = $em->getRepository(Producto::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
            ));
        else
            $productos_arr = $em->getRepository(Producto::class)->findBy(array(
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'activo' => true,
                'codigo' => $codigo,
            ));

        $row = array();
        foreach ($productos_arr as $obj) {
            /**@var $obj Producto* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 15),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia(),
                'importe' => $obj->getImporte(),
                'unidad_medida' => $obj->getIdUnidadMedida()->getNombre()
            );
        }
        return new JsonResponse(['productos' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_vale_salida_producto_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $unidad = AuxFunctions::getUnidad($em, $user);
        $row_inventario = AuxFunctions::getCuentasInventario($em);
//        $row_acreedoras = AuxFunctions::getCuentasAcreedoras($em);
        $row_moneda = $em->getRepository(Moneda::class)->findAll();
        $row_elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $row_proveedores = $em->getRepository(Proveedor::class)->findBy(array('activo' => true));
        $row_centro_costo = $em->getRepository(CentroCosto::class)->findBy(array('activo' => true, 'id_unidad' => $unidad));
        $monedas = [];
        $proveedores = [];
        foreach ($row_moneda as $moneda) {
            /**@var $moneda Moneda* */
            $monedas[] = array(
                'nombre' => $moneda->getNombre(),
                'id' => $moneda->getId(),
            );
        }

        foreach ($row_proveedores as $proveedor) {
            /**@var $proveedor Proveedor* */
            $proveedores[] = array(
                'nombre' => $proveedor->getNombre(),
                'id' => $proveedor->getId(),
            );
        }
        foreach ($row_centro_costo as $centro) {
            /**@var $centro CentroCosto* */
            $centro_costo[] = array(
                'nombre' => $centro->getNombre(),
                'id' => $centro->getId(),
            );
        }
        foreach ($row_elemento_gasto as $item) {
            /**@var $item ElementoGasto* */
            $elemento[] = array(
                'nombre' => $item->getDescripcion(),
                'id' => $item->getId(),
            );
        }
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'monedas' => $monedas, 'proveedores' => $proveedores, 'cento_costo' => $centro_costo, 'elemento_gasto' => $elemento, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_vale_salida_producto_gestionar", methods={"GET","POST"})
     */
    public function gestionarVale(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ValeSalidaType::class);
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('vale_salida')['list_mercancia'], true);
            if ($this->isCsrfTokenValid('authenticate', $request->get('_token'))) {
                $vale_salida = $request->get('vale_salida');

                /**  datos de InformeRecepcionType **/
                $fecha_solicitud = $vale_salida['fecha_solicitud'];
                $nro_solicitud = $vale_salida['nro_solicitud'];
                $nro_cuenta_deudora = $vale_salida['nro_cuenta_deudora'];
                $nro_subcuenta_deudora = $vale_salida['nro_subcuenta_deudora'];
                $id_moneda = $vale_salida['documento']['id_moneda'];


                ////0-obtengo el numero consecutivo de documento
                $arr_fecha = explode('-', $fecha_solicitud);
                $year_ = $arr_fecha[0];
                $id_user = $this->getUser()->getId();
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $id_user
                ));
                $consecutivo = 0;
                if ($obj_empleado) {
                    $id_unidad = $obj_empleado->getIdUnidad()->getId();
                    $vale_salida_arr = $em->getRepository(ValeSalida::class)->findBy(array(
                        'anno' => $year_,
                        'producto' => true
                    ));
                    $contador = 0;
                    foreach ($vale_salida_arr as $obj) {
                        /**@var $obj ValeSalida* */
                        if ($obj->getIdDocumento()->getIdAlmacen()->getId() == $id_almacen && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                            $contador++;
                    }
                    $consecutivo = $contador + 1;


                    //2-adicionar en documento
                    $today = Date('Y-m-d');
                    $documento = new Documento();
                    $documento
                        ->setActivo(true)
                        ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                        ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                        ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
                        ->setIdMoneda($em->getRepository(Moneda::class)->find($id_moneda));
                    $em->persist($documento);

                    $vale_salida = new ValeSalida();
                    $vale_salida
                        ->setIdDocumento($documento)
                        ->setActivo(true)
                        ->setNroConsecutivo($consecutivo)
                        ->setAnno($year_)
                        ->setFechaSolicitud(\DateTime::createFromFormat('Y-m-d', $fecha_solicitud))
                        ->setNroSolicitud($nro_solicitud)
                        ->setNroCuentaDeudora(AuxFunctions::getNro($nro_cuenta_deudora))
                        ->setNroSubcuentaDeudora(AuxFunctions::getNro($nro_subcuenta_deudora))
                        ->setProducto(true);
                    $em->persist($vale_salida);

                    /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                    $producto_er = $em->getRepository(Producto::class);
                    $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                    $obj_tipo_documento = $tipo_documento_er->find(8);
                    $importe_total = 0;
                    if ($obj_tipo_documento) {
                        foreach ($list_mercancia as $mercancia) {
                            $codigo_mercancia = $mercancia['codigo'];
                            $cantidad_mercancia = $mercancia['cant'];
                            $importe_mercancia = $mercancia['importe'];
                            $centro_costo = $mercancia['centro_costo'];
                            $elemento_gasto = $mercancia['elemento_gasto'];

                            $importe_total += floatval($importe_mercancia);

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_producto = new MovimientoProducto();
                            $movimiento_producto
                                ->setActivo(true)
                                ->setImporte(floatval($importe_mercancia))
                                ->setEntrada(false)
                                ->setCantidad($cantidad_mercancia)
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                                ->setIdDocumento($documento)
                                ->setIdCentroCosto($em->getRepository(CentroCosto::class)->find($centro_costo))
                                ->setIdElementoGasto($em->getRepository(ElementoGasto::class)->find($elemento_gasto))
                                ->setIdTipoDocumento($obj_tipo_documento)
                                ->setIdUsuario($this->getUser());

                            //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                            $obj_mercancia = $producto_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen,
                                'activo' => true
                            ));
                            if (!$obj_mercancia) {
                                return new JsonResponse(['success' => false, 'message' => 'Una de las mecancias relacionadas no está disponible en el almacén.']);
                            } else {
                                /**@var $obj_mercancia Mercancia* */
                                $existencia_actualizada = $obj_mercancia->getExistencia() - $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() - floatval($importe_mercancia));
                                $obj_mercancia
                                    ->setExistencia($existencia_actualizada)
                                    ->setImporte($importe_actualizado);
                                if ($obj_mercancia->getExistencia() == 0)
                                    $obj_mercancia->setActivo(false);
                                $em->persist($obj_mercancia);

                                $movimiento_producto
                                    ->setIdProducto($obj_mercancia)
                                    ->setExistencia($obj_mercancia->getExistencia());
                            }
                            $em->persist($movimiento_producto);
                        }
                    }

                    //--actualizo el importe total del documento, que no es mas que la sumatoria del importe de todas las mercancias...
                    $documento
                        ->setImporteTotal($importe_total);
                    $em->persist($documento);

                    try {
                        $em->flush();
                    } catch (FileException $e) {
                        return $e->getMessage();
                    }
                    return new JsonResponse(['success' => true, 'message' => 'Vale de salida contabilizado satisfactoriamente.']);
                } else {
                    return new JsonResponse(['success' => true, 'message' => 'Usted no es empleado de la empresa.']);
                }
            }
        }
        return $this->render('contabilidad/inventario/vale_salida_producto/form.html.twig', [
            'controller_name' => 'CRUDValeSalida',
            'formulario' => $form->createView()
        ]);

    }

    /**
     * @Route("/getVale/{nro}", name="contabilidad_inventario_vale_salida_producto_get_vale",methods={"POST"})
     */
    public function getVale(EntityManagerInterface $em, $nro)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $year_ = Date('Y');
        $vale_obj = $vale_salida_er->findOneBy(array(
            'nro_consecutivo' => $nro,
            'producto' => true,
            'anno' => $year_
        ));

        if (!$vale_obj) {
            return new JsonResponse(['informe' => [], 'success' => true, 'msg' => 'El nro de vale no existe.']);
        }
        /**@var $vale_obj ValeSalida* */
        if ($vale_obj->getActivo() == false)
            return new JsonResponse(['informe' => [], 'success' => false, 'msg' => 'El vale ha sido eliminado.']);

        $importe_total = 0;
        $rows_movimientos = [];

        $movimiento_productos_arr = $movimiento_producto_er->findBy(array(
            'id_tipo_documento' => $tipo_documento_er->find(8),
            'id_documento' => $vale_obj->getIdDocumento()
        ));

        foreach ($movimiento_productos_arr as $obj) {
            /**@var $obj MovimientoProducto* */
            $rows_movimientos[] = array(
                'id' => $obj->getIdProducto()->getId(),
                'codigo' => $obj->getIdProducto()->getCodigo(),
                'descripcion' => $obj->getIdProducto()->getDescripcion(),
                'existencia' => $obj->getExistencia(),
                'cantidad' => $obj->getCantidad(),
                'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                'importe' => number_format($obj->getImporte(), 3, '.', ''),
            );
            $importe_total += $obj->getImporte();
        }

        $rows = array(
            'id' => $vale_obj->getId(),
            'nro_cuenta_deudora' => $vale_obj->getNroCuentaDeudora(),
            'nro_subcuenta_deudora' => $vale_obj->getNroSubcuentaDeudora(),
            'nro_solicitud' => $vale_obj->getNroSolicitud(),
            'fecha_solicitud' => $vale_obj->getFechaSolicitud()->format('d/m/Y'),
            'id_moneda' => $vale_obj->getIdDocumento()->getIdMoneda()->getId(),
            'moneda' => $vale_obj->getIdDocumento()->getIdMoneda()->getNombre(),
            'importe_total' => $importe_total,
            'productos' => $rows_movimientos
        );
        return new JsonResponse([['vale' => $rows, 'success' => true, 'msg' => 'Vale de salida recuperado con éxito.']]);
    }

    /**
     * @Route("/delete/{nro}", name="contabilidad_inventario_vale_salida_producto_delete", methods={"DELETE"})
     */
    public function deleteInforme(Request $request, $nro)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();
        $year_ = Date('Y');
        $obj_vale = $em->getRepository(ValeSalida::class)->findOneBy(array(
            'nro_consecutivo' => $nro,
            'producto' => true,
            'anno' => $year_
        ));
        $msg = 'No se pudo eliminar el vale de salida seleccionado';
        $success = 'error';
        if ($obj_vale) {
            /**@var $obj_vale ValeSalida** */
            $obj_vale->setActivo(false);
            $obj_documento = $obj_vale->getIdDocumento();
            /**@var $obj_documento Documento* */
            $obj_documento->setActivo(false);

            $arr_movimientos_productos = $em->getRepository(MovimientoProducto::class)->findBy(array(
                'id_documento' => $obj_documento->getId(),
                'activo' => true
            ));

            //---RECORRO EL LISTADO DE MERCANCIAS DEL DOCUMENTO
            if (!empty($arr_movimientos_productos)) {
                foreach ($arr_movimientos_productos as $obj_movimiento_producto) {
                    /**@var $obj_movimiento_producto Producto* */
                    $obj_movimiento_producto
                        ->setActivo(false);
                    $em->persist($obj_movimiento_producto);

                    /**@var $obj_producto Producto* */
                    $obj_producto = $obj_movimiento_producto->getIdProducto();
                    $nueva_existencia = $obj_producto->getExistencia() + $obj_movimiento_producto->getCantidad();
                    $nuevo_importe = $obj_producto->getImporte() + $obj_movimiento_producto->getImporte();
                    $obj_producto
                        ->setExistencia($nueva_existencia)
                        ->setImporte($nuevo_importe)
                        ->setActivo(true);

                    $em->persist($obj_producto);
                }
            }
            try {
                $em->persist($obj_vale);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Vale de salida eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_inventario_vale_salida_producto_gestionar');
    }

    /**
     * @Route("/print-report/{nro}", name="contabilidad_inventario_vale_salida_producto_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, $nro)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $year_ = Date('Y');
        $vale_salida_obj = $vale_salida_er->findOneBy(array(
            'nro_consecutivo' => $nro,
            'producto' => true,
            'anno' => $year_
        ));

        $obj_tipo_documento = $tipo_documento_er->find(8);
        $rows = [];
        $almacen = '';
        $fecha_solicitud = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $nro_consecutivo = '';
        $fecha_vale = '';
        if ($vale_salida_obj && $obj_tipo_documento) {
            $almacen = $vale_salida_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $fecha_solicitud = $vale_salida_obj->getFechaSolicitud()->format('d/m/Y');
            $nro_solicitud = $vale_salida_obj->getNroSolicitud();
            $fecha_vale = $vale_salida_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_consecutivo = $vale_salida_obj->getNroConsecutivo();
            $arr_movimiento_producto = $movimiento_producto_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $vale_salida_obj->getIdDocumento()->getId(),
                'activo' => true
            ));

            if (!empty($arr_movimiento_producto)) {
                /** @var  $mov_producto MovimientoProducto */
                $mov_producto = $arr_movimiento_producto[0];
                $id_usuario_movimiento = $mov_producto->getIdUsuario()->getId();
                /** @var Empleado $obj_empleado */
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario_movimiento
                ));
                $unidad = $obj_empleado->getIdUnidad()->getNombre();
                foreach ($arr_movimiento_producto as $obj) {
                    /**@var $obj MovimientoProducto* */
                    $rows[] = array(
                        'id' => $obj->getIdProducto()->getId(),
                        'codigo' => $obj->getIdProducto()->getCodigo(),
                        'descripcion' => $obj->getIdProducto()->getDescripcion(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                        'importe' => number_format($obj->getImporte(), 2, '.', ''),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
        return $this->render('contabilidad/inventario/vale_salida_producto/print.html.twig', [
            'controller_name' => 'ValeSalidaControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2, '.', ''),
                'almacen' => $almacen,
                'fecha' => $fecha_solicitud,
                'nro_solicitud' => $nro_solicitud,
                'unidad' => $unidad,
                'fecha_vale' => $fecha_vale,
                'nro_consecutivo' => $nro_consecutivo
            ),
            'productos' => $rows,
            'id' => $nro
        ]);
    }
}
