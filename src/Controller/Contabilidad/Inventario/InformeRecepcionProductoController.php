<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
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
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\InformeRecepcionProductoType;
use App\Form\Contabilidad\Inventario\InformeRecepcionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class InformeRecepcionProductoController
 * CRUD DE INFORME DE RECEPCION DE Productos
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/informe-recepcion-productos")
 */
class InformeRecepcionProductoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_informe_recepcion_producto_producto")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/informe_recepcion_producto/index.html.twig', [
            'controller_name' => 'InformeRecepcionProductoController',
        ]);
    }

    /**
     * @Route("/get-nros-informes", name="contabilidad_inventario_informe_recepcion_producto_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $nro = AuxFunctions::getConsecutivos($em, $informe_recepcion_er, $year_, $id_usuario, $idalmacen);
        return new JsonResponse(['nros' => $nro, 'success' => true]);
    }

    /**
     * @Route("/form-add", name="contabilidad_inventario_informe_recepcion_producto_gestionar", methods={"GET","POST"})
     */
    public function gestionarInforme(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(InformeRecepcionProductoType::class);
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $list_mercancia = json_decode($request->get('informe_recepcion_producto')['list_mercancia'], true);
            if ($this->isCsrfTokenValid('authenticate', $request->get('_token'))) {
                $informe_recepcion = $request->get('informe_recepcion_producto');

                /**  datos de InformeRecepcionType **/
                $cuenta_acreedora = $informe_recepcion['nro_cuenta_acreedora'];
                $cuenta_inventario = $informe_recepcion['nro_cuenta_inventario'];
                $subcuenta_inventario = $informe_recepcion['nro_subcuenta_inventario'];
                $subcuenta_acreedora = $informe_recepcion['nro_subcuenta_acreedora'];
                $year_ = Date('Y');

                ////0-obtengo el numero consecutivo de documento
                $id_user = $this->getUser()->getId();
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $id_user
                ));
                $consecutivo = 0;
                if ($obj_empleado) {
                    $id_unidad = $obj_empleado->getIdUnidad()->getId();
                    $informes_recepcion_arr = $em->getRepository(InformeRecepcion::class)->findBy(array(
                        'anno' => $year_,
                        'activo' => true,
                        'producto'=>true
                    ));
                    $contador = 0;
                    foreach ($informes_recepcion_arr as $obj) {
                        /**@var $obj InformeRecepcion* */
                        if ($obj->getIdDocumento()->getIdAlmacen()->getId() == 1 && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
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
                        ->setIdMoneda($em->getRepository(Moneda::class)->find($informe_recepcion['documento']['id_moneda']));
                    $em->persist($documento);

                    //3.1-adicionar en informe de recepcion
                    $informe_recepcion = new InformeRecepcion();
                    $informe_recepcion
                        ->setAnno($year_)
                        ->setIdDocumento($documento)
                        ->setNroConcecutivo($consecutivo)
                        ->setNroCuentaAcreedora($cuenta_acreedora)
                        ->setNroCuentaInventario($cuenta_inventario)
                        ->setNroSubcuentaInventario($subcuenta_inventario)
                        ->setActivo(true)
                        ->setProduco(true)
                        ->setNroSubcuentaAcreedora($subcuenta_acreedora);
                    $em->persist($informe_recepcion);

                    /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                     * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                     * entre la suma del importe de la mercancia + el importe adicionado,
                     * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                     * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                     */

                    /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                    $producto_er = $em->getRepository(Producto::class);
                    $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                    $obj_tipo_documento = $tipo_documento_er->find(1);
                    $importe_total = 0;
                    if ($obj_tipo_documento) {
                        foreach ($list_mercancia as $producto) {
                            $codigo_mercancia = $producto['codigo'];
                            $cantidad_mercancia = $producto['cant'];
                            $descripcion = $producto['descripcion'];
                            $importe_mercancia = $producto['importe'];
                            $unidad_medida = $producto['um'];

                            $importe_total += floatval($importe_mercancia);

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_mercancia = new MovimientoMercancia();
                            $movimiento_mercancia
                                ->setActivo(true)
                                ->setImporte(floatval($importe_mercancia))
                                ->setEntrada(true)
                                ->setCantidad($cantidad_mercancia)
                                ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                                ->setIdDocumento($documento)
                                ->setIdTipoDocumento($obj_tipo_documento)
                                ->setIdUsuario($this->getUser());

                            //---ADICIONANDO/ACTUALIZANDO EN LA TABLA DE MERCANCIA
                            $obj_mercancia = $producto_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen,
//                            'activo' => true //-----Para que traiga tanto las mercancias con existencia como las que se eliminaron
                            ));
                            if (!$obj_mercancia) {
                                $new_mercancia = new Mercancia();
                                $new_mercancia
                                    ->setIdUnidadMedida($em->getRepository(UnidadMedida::class)->find($unidad_medida))
                                    ->setActivo(true)
                                    ->setDescripcion($descripcion)
                                    ->setExistencia($cantidad_mercancia)
                                    ->setIdAmlacen($em->getRepository(Almacen::class)->find($id_almacen))
                                    ->setCodigo($codigo_mercancia)
                                    ->setCuenta($cuenta_inventario)
                                    ->setImporte(floatval($importe_mercancia));
                                $em->persist($new_mercancia);
                                $movimiento_mercancia
                                    ->setIdMercancia($new_mercancia)
                                    ->setExistencia($cantidad_mercancia);
                            } else {
                                if ($obj_mercancia->getActivo() == false) {
                                    $obj_mercancia
                                        ->setExistencia(0)
                                        ->setImporte(0);
                                    $em->persist($obj_mercancia);
                                }
                                /**@var $obj_mercancia Mercancia* */
                                if ($obj_mercancia->getExistencia() == 0) {
                                    $obj_mercancia
                                        ->setExistencia($cantidad_mercancia)
                                        ->setImporte($importe_mercancia);
                                } else {
                                    $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                    $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                    $obj_mercancia
                                        ->setExistencia($existencia_actualizada)
                                        ->setImporte($importe_actualizado);
                                }
                                $em->persist($obj_mercancia);
                                if ($obj_mercancia->getCuenta() == $cuenta_inventario) {
                                    if ($obj_mercancia->getActivo() == false) {
                                        $obj_mercancia
                                            ->setExistencia(0)
                                            ->setActivo(true)
                                            ->setImporte(0);
                                        $em->persist($obj_mercancia);
                                    }
                                    /**@var $obj_mercancia Mercancia* */
                                    if ($obj_mercancia->getExistencia() == 0) {
                                        $obj_mercancia
                                            ->setExistencia($cantidad_mercancia)
                                            ->setActivo(true)
                                            ->setImporte($importe_mercancia);
                                    } else {
                                        $existencia_actualizada = $obj_mercancia->getExistencia() + $cantidad_mercancia;
                                        $importe_actualizado = floatval($obj_mercancia->getImporte() + floatval($importe_mercancia));
                                        $obj_mercancia
                                            ->setExistencia($existencia_actualizada)
                                            ->setActivo(true)
                                            ->setImporte($importe_actualizado);
                                    }
                                    $em->persist($obj_mercancia);
                                } else {
                                    return new JsonResponse(['success' => false, 'msg' => 'Existen productos relacionada a cuentas de inventario diferente a la seleccionada.']);
                                }
                                $movimiento_mercancia
                                    ->setIdMercancia($obj_mercancia)
                                    ->setExistencia($obj_mercancia->getExistencia());
                            }
                            $em->persist($movimiento_mercancia);
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
                    return new JsonResponse(['success' => true, 'message' => 'Informe de recepción adicionado satisfactoriamente.']);
                } else {
                    return new JsonResponse(['success' => true, 'message' => 'Usted no es empleado de la empresa.']);
                }
            }
        }
        return $this->render('contabilidad/inventario/informe_recepcion_producto/form.html.twig', [
            'controller_name' => 'CRUDInformeRecepcionProducto',
            'formulario' => $form->createView()
        ]);
    }


    /**
     * @Route("/getProductos/{params}", name="contabilidad_inventario_informe_recepcion_producto_gestionar_getMercancia", methods={"POST"})
     */
    public function getProductos(Request $request, $params)
    {
        $arr = explode(',', $params);
        $codigo = $arr[0];
        $cuenta = $arr[1];
//        dd($cuenta);
        if($cuenta != "null"){
            $em = $this->getDoctrine()->getManager();
            if ($codigo == -1 || $codigo == '-1')
                $productos_arr = $em->getRepository(Producto::class)->findBy(array(
                    'activo' => true,
                    'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                    'cuenta' => $cuenta
                ));
            else
                $productos_arr = $em->getRepository(Producto::class)->findBy(array(
                    'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                    'activo' => true,
                    'codigo' => $codigo,
                    'cuenta' => $cuenta
                ));

            $row = array();
            foreach ($productos_arr as $obj) {
                /**@var $obj Producto* */
                $row [] = array(
                    'id' => $obj->getId(),
                    'codigo' => $obj->getCodigo(),
                    'descripcion' => $obj->getDescripcion(),
                    'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 3),
                    'id_almacen' => $obj->getIdAmlacen(),
                    'existencia' => $obj->getExistencia()
                );
            }
            return new JsonResponse(['productos' => $row, 'success' => true]);
        }
        return new JsonResponse(['productos' => [], 'success' => false]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_informe_recepcion_producto_gestionar_getCuentas", methods={"POST"})
     */
    public function getCuentas()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasInventario($em);
        $row_acreedoras = AuxFunctions::getCuentasProduccion($em);

        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'cuentas_acrredoras' => $row_acreedoras, 'success' => true]);
    }


    /**
     * @Route("/delete/{id}", name="contabilidad_inventario_informe_recepcion_producto_delete", methods={"DELETE"})
     */
    public function deleteInforme(Request $request, $id)
    {
        // if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
        $em = $this->getDoctrine()->getManager();

        $obj_informe_recepcion = $em->getRepository(InformeRecepcion::class)->find($id);
        $msg = 'No se pudo eliminar el informe de recepción seleccionado';
        $success = 'error';
        if ($obj_informe_recepcion) {
            /**@var $obj_informe_recepcion InformeRecepcion** */
            $obligacion_er = $em->getRepository(ObligacionPago::class);

            //SI EN OBLIGACION DE PAGO NO SE HA PAGADO NADA DE LA OBLIGACION DE PAGO QUE EL INFORME GENERO, ENTONCES ELIMINO
            $importe_informe = $obj_informe_recepcion->getIdDocumento()->getImporteTotal();
//            $obj_obligacion = $obligacion_er->findOneBy(array(
//                    'id_documento' => $obj_informe_recepcion->getIdDocumento()
//                )
//            );
//            /**@var $obj_obligacion ObligacionPago* */
//            $importe_obligacion = $obj_obligacion->getResto();
//            if (floatval($importe_informe) - floatval($importe_obligacion) == 0) {
            //voy a informe de recepcion y lo elimino
            $obj_informe_recepcion->setActivo(false);
            //voy a obligacion de pago y la elimino
//                $obj_obligacion->setActivo(false);
            $obj_documento = $obj_informe_recepcion->getIdDocumento();
            /**@var $obj_documento Documento* */
            //voy a documento y lo elimino
            $obj_documento->setActivo(false);


            //eliminar la entrada de la tabla de movimiento_mercancia
            $arr_movimientos_mercancia = $em->getRepository(MovimientoMercancia::class)->findBy(array(
                'id_documento' => $obj_documento->getId(),
                'activo' => true
            ));

            //---RECORRO EL LISTADO DE MERCANCIAS DEL DOCUMENTO
            if (!empty($arr_movimientos_mercancia)) {
                foreach ($arr_movimientos_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia* */
                    $obj_movimiento_mercancia
                        ->setActivo(false);
                    $em->persist($obj_movimiento_mercancia);

                    /**@var $obj_mercancia Mercancia* */
                    $obj_mercancia = $obj_movimiento_mercancia->getIdMercancia();
                    $nueva_existencia = $obj_mercancia->getExistencia() - $obj_movimiento_mercancia->getCantidad();
                    $nuevo_importe = $obj_mercancia->getImporte() - $obj_movimiento_mercancia->getImporte();
                    $obj_mercancia->setExistencia($nueva_existencia);
                    $obj_mercancia->setImporte($nuevo_importe);
                    if ($nueva_existencia == 0) {
                        $obj_mercancia->setActivo(false);
                    }
                    $em->persist($obj_mercancia);
                }
            }
            try {
                $em->persist($obj_informe_recepcion);
//                    $em->persist($obj_obligacion);
                $em->persist($obj_documento);
                $em->flush();
                $success = 'success';
                $msg = 'Informe de recepción eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
//            } else {
//                $msg = 'El informe de recepcion no se puede eliminar, porque existen pagos asociados.';
//                $success = 'error';
//            }
        }
        $this->addFlash($success, $msg);
        // }
        return $this->redirectToRoute('contabilidad_inventario_informe_recepcion');
    }

    /**
     * @Route("/print_report/{id}", name="contabilidad_inventario_informe_recepcion_producto_print",methods={"GET"})
     */
    public function print(EntityManagerInterface $em, $id)
    {
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);

        $informe_obj = $informe_recepcion_er->findOneBy(array(
            'activo' => true,
            'id' => $id
        ));

        $obj_tipo_documento = $tipo_documento_er->find(1);
        $rows = [];
        $almacen = '';
        $cod_proveedor = '';
        $proveedor = '';
        $fecha_factura = '';
        $numero_factura = '';
        $importe_total = 0;
        $unidad = '';
        $nro_solicitud = '';
        $fecha_informe = '';
        if ($informe_obj && $obj_tipo_documento) {
            $almacen = $informe_obj->getIdDocumento()->getIdAlmacen()->getDescripcion();
            $cod_proveedor = $informe_obj->getIdProveedor()->getCodigo();
            $proveedor = $informe_obj->getIdProveedor()->getNombre();
            $fecha_factura = $informe_obj->getFechaFactura()->format('d/m/Y');
            $numero_factura = $informe_obj->getCodigoFactura();
            $fecha_informe = $informe_obj->getIdDocumento()->getFecha()->format('d/m/Y');
            $nro_solicitud = $informe_obj->getNroConcecutivo();
            $arr_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'id_documento' => $informe_obj->getIdDocumento()->getId(),
                'activo' => true
            ));

            if (!empty($arr_movimiento_mercancia)) {
                /** @var  $mov_mercancia MovimientoMercancia */
                $mov_mercancia = $arr_movimiento_mercancia[0];
                $id_usuario_movimiento = $mov_mercancia->getIdUsuario()->getId();
                /** @var Empleado $obj_empleado */
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario_movimiento
                ));
                $unidad = $obj_empleado->getIdUnidad()->getNombre();
                foreach ($arr_movimiento_mercancia as $obj) {
                    /**@var $obj MovimientoMercancia* */
                    $rows[] = array(
                        'id' => $obj->getIdMercancia()->getId(),
                        'codigo' => $obj->getIdMercancia()->getCodigo(),
                        'descripcion' => $obj->getIdMercancia()->getDescripcion(),
                        'existencia' => $obj->getExistencia(),
                        'cantidad' => $obj->getCantidad(),
                        'precio' => number_format(($obj->getImporte() / $obj->getCantidad()), 3, '.', ''),
                        'importe' => number_format($obj->getImporte(), 2, '.', ''),
                    );
                    $importe_total += $obj->getImporte();
                }
            }

        }
        return $this->render('contabilidad/inventario/informe_recepcion/print.html.twig', [
            'controller_name' => 'InformeRecepcionControllerPrint',
            'datos' => array(
                'importe_total' => number_format($importe_total, 2, '.', ''),
                'almacen' => $almacen,
                'cod_proveedor' => $cod_proveedor,
                'proveedor' => $proveedor,
                'fecha' => $fecha_factura,
                'cod_factura' => $numero_factura,
                'unidad' => $unidad,
                'fecha_informe' => $fecha_informe,
                'nro_solicitud' => $nro_solicitud
            ),
            'mercancias' => $rows,
            'id' => $id
        ]);
    }

}
