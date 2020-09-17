<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
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
                    'concecutivo' => $obj_vale_salida->getNroConcecutivo(),
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
    public function getNros(EntityManagerInterface $em, Request $request){
        $vale_salida_er = $em->getRepository(ValeSalida::class);
        $id_usuario = $this->getUser()->getId();
        $year_ = Date('Y');
        $idalmacen = $request->getSession()->get('selected_almacen/id');
        $row = AuxFunctions::getConsecutivos($em,$vale_salida_er,$year_,$id_usuario,$idalmacen);
        return new JsonResponse(['nros' => $row, 'success' => true]);
    }

    /**
     * @Route("/getMercancia/{params}", name="contabilidad_inventario_vale_salida_gestionar_getMercancia", methods={"POST"})
     */
    public function getMercancia(Request $request,$params)
    {
        $arr = explode(',',$params);
        $codigo = $arr[0];
        $cuenta = $arr[1];
        $em = $this->getDoctrine()->getManager();
        if ($codigo == -1 || $codigo == '-1')
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'activo' => true,
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'cuenta'=>$cuenta
            ));
        else
            $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
                'id_amlacen' => $request->getSession()->get('selected_almacen/id'),
                'activo' => true,
                'codigo' => $codigo,
                'cuenta'=>$cuenta
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
        $em = $this->getDoctrine()->getManager();

        //MODULO INVENTARIO
        //TIPO DE DOCUMENTO "VALE SALIDA"
        $conf_inicial_er = $em->getRepository(ConfiguracionInicial::class);
        $modulo_er = $em->getRepository(Modulo::class);
        $tipo_documento_er = $em->getRepository(TipoDocumento::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);

        $obj_tipo_documento = $tipo_documento_er->find(6);
        $obj_modulo = $modulo_er->find(2);
        $row_inventario = array();
        $row_acreedoras = array();

        if ($obj_modulo && $obj_tipo_documento) {
            $obj_conf_inicial = $conf_inicial_er->findOneBy(array(
                'id_modulo' => $obj_modulo->getId(),
                'id_tipo_documento' => $obj_tipo_documento->getId(),
                'activo' => true
            ));

            if ($obj_conf_inicial) {
                /**@var $obj_conf_inicial ConfiguracionInicial* */
                $str_cuentas = $obj_conf_inicial->getStrCuentas();
                $str_cuentas_acreedoras = $obj_conf_inicial->getStrCuentasContrapartida();

                $cuentas_inventario = explode('-', $str_cuentas);
                $cuentas_acreedoras = explode('-', $str_cuentas_acreedoras);

                foreach ($cuentas_inventario as $cuentas) {
                    $row_inventario [] = array(
                        'nro_cuenta' => trim($cuentas),
                        'sub_cuenta' => $this->getSubcuentas($obj_conf_inicial->getStrSubcuentas(), trim($cuentas), $subcuenta_er, $cuenta_er)
                    );
                }
                foreach ($cuentas_acreedoras as $cuentas) {
                    $row_acreedoras [] = array(
                        'nro_cuenta' => trim($cuentas)
                    );
                }
            }
        }
        return new JsonResponse(['cuentas_inventario' => $row_inventario, 'cuentas_acrredoras' => $row_acreedoras, 'success' => true]);
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
            $list_mercancia = json_decode($request->get('informe_recepcion')['list_mercancia'], true);
            if ($this->isCsrfTokenValid('authenticate', $request->get('_token'))) {
                $informe_recepcion = $request->get('informe_recepcion');

                /**  datos de InformeRecepcionType **/
                $cuenta_acreedora = $informe_recepcion['nro_cuenta_acreedora'];
                $cuenta_inventario = $informe_recepcion['nro_cuenta_inventario'];
                $proveedor = $informe_recepcion['id_proveedor'];
                $subcuenta_inventario = $informe_recepcion['nro_subcuenta_inventario'];
                $fecha_factura = $informe_recepcion['fecha_factura'];
                $codigo_factura = $informe_recepcion['codigo_factura'];

                ////0-obtengo el numero consecutivo de documento
                $arr_fecha = explode('-', $fecha_factura);
                $year_ = $arr_fecha[0];
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
                        'activo' => true
                    ));
                    $contador = 0;
                    foreach ($informes_recepcion_arr as $obj) {
                        /**@var $obj InformeRecepcion* */
                        if ($obj->getIdDocumento()->getIdAlmacen()->getId() == 1 && $obj->getIdDocumento()->getIdUnidad()->getId() == $id_unidad)
                            $contador++;
                    }
                    $consecutivo = $contador + 1;
                    //1-adicionar en subcuenta los datos del proveedor como subcuenta de la cuenta acreedora
                    $sub_cuenta_er = $em->getRepository(Subcuenta::class);
                    $cuenta_er = $em->getRepository(Cuenta::class);
                    $proveedor_obj = $em->getRepository(Proveedor::class)->find($proveedor);
                    $cuenta_acreedora_obj = $cuenta_er->findOneBy(array(
                        'nro_cuenta' => $cuenta_acreedora,
                        'activo' => true
                    ));
                    if ($cuenta_acreedora_obj && $proveedor_obj) {
                        $obj_subcuenta_acreedora = $sub_cuenta_er->findOneBy(array(
                            'nro_subcuenta' => $proveedor_obj->getCodigo(),
                            'activo' => true,
                            'id_cuenta' => $cuenta_acreedora_obj->getId()
                        ));
                        if (!$obj_subcuenta_acreedora) {
                            $new_Subcuenta = new Subcuenta();
                            $new_Subcuenta
                                ->setNroSubcuenta($proveedor_obj->getCodigo())
                                ->setDescripcion($proveedor_obj->getNombre())
                                ->setIdCuenta($cuenta_acreedora_obj)
                                ->setDeudora(false)
                                ->setActivo(true);
                            $em->persist($new_Subcuenta);
                        }
                    }

                    //2-adicionar en documento
                    $today = Date('Y-m-d');
                    $documento = new Documento();
                    $documento
                        ->setActivo(true)
                        ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                        ->setIdAlmacen($em->getRepository(Almacen::class)->find($id_almacen))
                        ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad));
                    $em->persist($documento);

                    //3.1-adicionar en informe de recepcion
                    $informe_recepcion = new InformeRecepcion();
                    $informe_recepcion
                        ->setAnno($year_)
                        ->setCodigoFactura($codigo_factura)
                        ->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $fecha_factura))
                        ->setIdDocumento($documento)
                        ->setIdProveedor($proveedor_obj)
                        ->setNroConcecutivo($consecutivo)
                        ->setNroCuentaAcreedora($cuenta_acreedora)
                        ->setNroCuentaInventario($cuenta_inventario)
                        ->setNroSubcuentaInventario($subcuenta_inventario)
                        ->setActivo(true)
                        ->setNroSubcuentaAcreedora($proveedor_obj->getCodigo());
                    $em->persist($informe_recepcion);

                    //4-crear la obligacion de pago con el proveedor(crear la tabla)
//                    $obligacion_pago = new ObligacionPago();
//                    $obligacion_pago
//                        ->setIdProveedor($proveedor_obj)
//                        ->setIdUnidad($em->getRepository(Unidad::class)->find($id_unidad))
//                        ->setIdDocumento($documento)
//                        ->setActivo(true)
//                        ->setNroSubcuenta($proveedor_obj->getCodigo())
//                        ->setNroCuenta($cuenta_acreedora)
//                        ->setLiquidado(false)
//                        ->setResto(floatval($importe_total))
//                        ->setValorPagado(0)
//                        ->setCodigoFactura($codigo_factura)
//                        ->setFechaFactura(\DateTime::createFromFormat('Y-m-d', $fecha_factura));
//                    $em->persist($obligacion_pago);

                    /**5-adicionar o actualizar la mercancia variando la existencia y el precio que sera por precio promedio
                     * (este se calculara sumanto la existencia de la mercancia + la cantidad la cantidad adicionada y /
                     * entre la suma del importe de la mercancia + el importe adicionado,
                     * OJO todos esto se hara si la mercancia a adicionar ya se encuentra registrada y su existencia es >0
                     * de lo contrario se pondra en existencia la cantidad a adicionar y el precio sera el precio a adicionar)*
                     */

                    /**OBTENGO TODAS LAS MERCANCIAS CONTENIDAS EN EL LISTADO, ITERO POR CADA UNA DE ELLAS Y VOY ADICIONANDOLAS**/
                    $mercancia_er = $em->getRepository(Mercancia::class);
                    $tipo_documento_er = $em->getRepository(TipoDocumento::class);
                    $obj_tipo_documento = $tipo_documento_er->find(1);
                    $importe_total = 0;
                    if ($obj_tipo_documento) {
                        foreach ($list_mercancia as $mercancia) {
                            $codigo_mercancia = $mercancia['codigo'];
                            $cantidad_mercancia = $mercancia['cant'];
                            $descripcion = $mercancia['descripcion'];
                            $importe_mercancia = $mercancia['importe'];
                            $unidad_medida = $mercancia['um'];

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
                            $obj_mercancia = $mercancia_er->findOneBy(array(
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
                                if($obj_mercancia->getCuenta() == $cuenta_inventario){
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
                                }
                                else{
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
        return $this->render('contabilidad/inventario/vale_salida/form.html.twig', [
            'controller_name' => 'CRUDValeSalida',
            'formulario' => $form->createView()
        ]);
    }

}
