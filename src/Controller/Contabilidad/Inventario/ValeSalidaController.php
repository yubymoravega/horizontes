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
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
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
 * Class ValeSalidaController
 * CRUD DE INFORME DE RECEPCION DE MERCANCIAS
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/vale-salida")
 */
class ValeSalidaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_vale_salida", methods={"GET"})
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
        return $this->render('contabilidad/inventario/vale_salida/index.html.twig', [
            'controller_name' => 'ValeSalidaController',
            'vales' => $rows
        ]);
    }

    /**
     * @Route("/get-nros-vales-salida", name="contabilidad_inventario_vale_salida_get_nros", methods={"POST"})
     */
    public function getNros(EntityManagerInterface $em, Request $request)
    {
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em, $vale_salida_er, $year_, $id_usuario, $idalmacen);
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/getMercancia/{codigo}", name="contabilidad_inventario_vale_salida_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(Request $request, $codigo)
    {
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1)
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
            ));
        else
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'activo' => true,
                'codigo' => $codigo
            ));

        $row = array();
        foreach ($mercancia_arr as $obj) {
            /**@var $obj Mercancia* */
            $row [] = array(
                'id' => $obj->getId(),
                'codigo' => $obj->getCodigo(),
                'descripcion' => $obj->getDescripcion(),
                'precio_compra' => round($obj->getImporte() / $obj->getExistencia(), 3),
                'id_almacen' => $obj->getIdAmlacen(),
                'existencia' => $obj->getExistencia()
            );
        }
        return new JsonResponse(['mercancias' => $row, 'success' => true]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_inventario_vale_salida_gestionar_getCuentas", methods={"POST"})
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

    public function getSubcuentas($str_subcuentas, $nro_cuenta, $subcuenta_er, $cuenta_er)
    {
        $obj_cuenta = $cuenta_er->findOneBy(array(
            'activo' => true,
            'nro_cuenta' => $nro_cuenta
        ));
        if ($obj_cuenta) {
            /**@var $obj_cuenta Cuenta* */
            $arr_obj_subcuentas = $subcuenta_er->findBy(array(
                'activo' => true,
                'id_cuenta' => $obj_cuenta->getId()
            ));
            if (!empty($arr_obj_subcuentas)) {
                $rows = [];
                $subcuentas_array = explode('-', $str_subcuentas);
                foreach ($arr_obj_subcuentas as $subcuenta) {
                    /**@var $subcuenta Subcuenta* */
                    foreach ($subcuentas_array as $nro_subcuenta) {
                        if ($subcuenta->getNroSubcuenta() == trim($nro_subcuenta))
                            $rows [] = array(
                                'nro_cuenta' => $nro_cuenta,
                                'nro_subcuenta' => $subcuenta->getNroSubcuenta(),
                                'id' => $subcuenta->getId()
                            );
                    }
                }
                return $rows;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }


    /**
     * @Route("/form-add", name="contabilidad_inventario_vale_salida_gestionar", methods={"GET","POST"})
     */
    public function gestionarInforme(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
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
                        'activo' => true
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
                        ->setIdMoneda($em->getRepository(Moneda::class)->find($id_moneda))
                    ;
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
                        ->setProducto(false);
                    $em->persist($vale_salida);

                    /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                    $mercancia_er = $em->getRepository(Mercancia::class);
                    $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                    $obj_tipo_documento = $tipo_documento_er->find(7);
                    $importe_total = 0;
                    if ($obj_tipo_documento) {
                        foreach ($list_mercancia as $mercancia) {
                            $codigo_mercancia = $mercancia['codigo'];
                            $cantidad_mercancia = $mercancia['cant'];
                            $descripcion = $mercancia['descripcion'];
                            $importe_mercancia = $mercancia['importe'];
                            $unidad_medida = $mercancia['um'];
                            $centro_costo = $mercancia['centro_costo'];
                            $elemento_gasto = $mercancia['elemento_gasto'];

                            $importe_total += floatval($importe_mercancia);

                            //------ADICIONANDO EN LA TABLA DE MOVIMIENTOMERCANCIA
                            $movimiento_mercancia = new MovimientoMercancia();
                            $movimiento_mercancia
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
                            $obj_mercancia = $mercancia_er->findOneBy(array(
                                'codigo' => $codigo_mercancia,
                                'id_amlacen' => $id_almacen,
                                'activo' => true
                            ));
                            if (!$obj_mercancia) {
                                return new JsonResponse(['success' => false, 'message' => 'Una de las mecancias relacionadas no está disponible en el almacén.']);
                            } else {
                                /**@var $obj_mercancia Mercancia**/
                                $existencia_actualizada = $obj_mercancia->getExistencia() - $cantidad_mercancia;
                                $importe_actualizado = floatval($obj_mercancia->getImporte() - floatval($importe_mercancia));
                                $obj_mercancia
                                    ->setExistencia($existencia_actualizada)
                                    ->setImporte($importe_actualizado);
                                if ($obj_mercancia->getExistencia() == 0)
                                    $obj_mercancia->setActivo(false);
                                $em->persist($obj_mercancia);

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
                    return new JsonResponse(['success' => true, 'message' => 'Vale de salida contabilizado satisfactoriamente.']);
                } else {
                    return new JsonResponse(['success' => true, 'message' => 'Usted no es empleado de la empresa.']);
                }
            }
        }
        return $this->render('contabilidad/inventario/vale_salida/form.html.twig', [
            'controller_name' => 'CRUDValeSalida',
            'formulario' => $form->createView()
        ]);

    }

}
