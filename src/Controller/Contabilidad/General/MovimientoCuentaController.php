<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\SaldoCuentas;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\User;
use App\Form\Contabilidad\General\MovimientoCuentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class MovimientoCuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/movimiento-cuenta")
 */
class MovimientoCuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_movimiento_cuenta", methods={"POST","GET"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovimientoCuentaType::class);
        return $this->render('contabilidad/general/movimiento_cuenta/index.html.twig', [
            'controller_name' => 'MovimientoCuentaController',
            'form' => $form->createView(),
            'saldo_inicial' => 0
        ]);
    }

    /**
     * @Route("/getSubmayor", name="contabilidad_general_movimiento_cuenta_get", methods={"POST","GET"})
     */
    public function getSumbayor(EntityManagerInterface $em, Request $request)
    {
        //params to view
        $centro_costo = $request->request->get('centro_costo');
        $orden_trabajo = $request->request->get('orden_trabajo');
        $elemento_gasto = $request->request->get('elemento_gasto');
        $expediente = $request->request->get('expediente');
        $periodo = $request->request->get('periodo');
        $nro_cuenta = $request->request->get('nro_cuenta');
        $anno = $request->request->get('anno');
        $nro_subcuenta = $request->request->get('nro_subcuenta');
        $almacen = $request->request->get('almacen');
        $cliente = $request->request->get('cliente');
        $proveedor = $request->request->get('proveedor');

        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);

        $arr_cuenta = explode(' - ', $nro_cuenta);
        $arr_subcuenta = (isset($nro_subcuenta) && $nro_subcuenta != '') ? explode(' - ', $nro_subcuenta) : '';

        /** @var Cuenta $obj_cuenta */
        $obj_cuenta = $cuenta_er->findOneBy(['nro_cuenta' => $arr_cuenta[0], 'activo' => true]);

        $arr_criterio = AuxFunctions::getCriterioByCuenta($obj_cuenta->getNroCuenta(), $em);
        $rows_data_criterios = [];
        foreach ($arr_criterio as $key => $abreviatura_crietrio) {
            if ($abreviatura_crietrio == 'CCT') {
                if (isset($centro_costo) && $centro_costo != 0)
                    $rows_data_criterios[count($rows_data_criterios)] = $em->getRepository(CentroCosto::class)->find($centro_costo)->getCodigo();
            }
            if ($abreviatura_crietrio == 'OT') {
                if (isset($orden_trabajo) && $orden_trabajo != 0)
                    $rows_data_criterios[count($rows_data_criterios)] = $em->getRepository(OrdenTrabajo::class)->find($orden_trabajo)->getCodigo();
            }
            if ($abreviatura_crietrio == 'EG') {
                if (isset($elemento_gasto) && $elemento_gasto != 0)
                    $rows_data_criterios[count($rows_data_criterios)] = $em->getRepository(ElementoGasto::class)->find($elemento_gasto)->getCodigo();
            }
            if ($abreviatura_crietrio == 'ALM') {
                if (isset($almacen) && $almacen != 0)
                    $rows_data_criterios[count($rows_data_criterios)] = $em->getRepository(Almacen::class)->find($almacen)->getCodigo();
            }
            if ($abreviatura_crietrio == 'EXP') {
                if (isset($expediente) && $expediente != 0)
                    $rows_data_criterios[count($rows_data_criterios)] = $em->getRepository(Expediente::class)->find($expediente)->getCodigo();
            }
            if ($abreviatura_crietrio == 'CLIPRO') {
                if (isset($cliente) && $cliente != 0) {
                    $rows_data_criterios[$key] = $em->getRepository(ClienteContabilidad::class)->find($cliente);
                } else if (isset($proveedor) && $proveedor != 0) {
                    $rows_data_criterios[$key] = $em->getRepository(Proveedor::class)->find($proveedor)->getCodigo();
                }
            }
        }
        /** @var User $user */
        $user = $this->getUser();
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $user
        ));
        $row = [];
        if ($empleado) {
            /** @var Unidad $obj_unidad */
            $obj_unidad = $empleado->getIdUnidad();

            /*** Aqui traemos el movimiento de la cuenta solamente***/
            if ($arr_subcuenta == '') {
                $data = $this->getDataOnlyAccount($em, $obj_unidad, $anno, $periodo, $obj_cuenta, null, $rows_data_criterios);
                return new JsonResponse($data);
            } else {

                /*** Aqui traemos el movimiento de la cuenta y la subcuenta***/
                /** @var Subcuenta $obj_subcuenta */
                $obj_subcuenta = $subcuenta_er->findOneBy(['nro_subcuenta' => $arr_subcuenta[0], 'activo' => true, 'id_cuenta' => $obj_cuenta]);
                $data = $this->getDataOnlyAccount($em, $obj_unidad, $anno, $periodo, $obj_cuenta, $obj_subcuenta, $rows_data_criterios);
                return new JsonResponse($data);
            }
        }
//        return new JsonResponse(['success' => true, 'datos' => $row, 'saldo_inicial' => number_format($saldo_partida, 2)]);
    }

    /**
     * @param $em EntityManagerInterface
     * @param $obj_unidad Unidad unidad de en la que vamos a buscar los comprobantes
     * @param $year int anno en el que vamos a buscar
     * @param $month int mes que analizaremos, si el valor es 0 significa que es acumulado, en otro caso hace referencia al numero del mes
     * @param $account_obj Cuenta cuenta de la que estamos buscado la información
     * @param $obj_subcuenta Subcuenta subcuenta de la que estamos buscado la información
     * @param $rows_data_criterios array arreglo con los codigos de los criterios a buscar
     * @return array con los datos del los documentos para los parametros especificados
     */
    public function getDataOnlyAccount($em, $obj_unidad, $year, $month, $account_obj, $obj_subcuenta, $rows_data_criterios)
    {
        /*** (1)-para buscar el saldo inicial de la cuenta solamente, busco los saldos iniciales
         * para el espacio de tiempo especificado de
         * todas sus subcuentas, entonces los suma y pan ya
         ***/
        $saldo_cuenta_er = $em->getRepository(SaldoCuentas::class);
        $arr_saldo_cuenta = $saldo_cuenta_er->findBy([
            'id_cuenta' => $account_obj,
            'mes' => $month,
            'anno' => $year
        ]);
        $saldo_inicial_cuenta = 0;
        $saldo_inicial_calculo = 0;
        /** @var SaldoCuentas $obj_saldo_cuenta */
        foreach ($arr_saldo_cuenta as $obj_saldo_cuenta) {
            $saldo_inicial_cuenta += $obj_saldo_cuenta->getSaldo();
            $saldo_inicial_calculo += $obj_saldo_cuenta->getSaldo();
        }

        /*** (2)-Procedo a buscar los comprobantes, para entoces de cada uno de ellos buscar los documentos que lo conforman,
         * si el mes es 0, significa que es acumulado por lo que debo traer todos los comprobantes para el anno especificado
         ***/
        $comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'anno' => $year,
            'id_unidad' => $obj_unidad,
        ));
        $row = [];
        /** @var RegistroComprobantes $comp */

        foreach ($comprobantes as $comp) {
            if ($month != 0) {
                if ($comp->getFecha()->format('m') == $month) {
                    $data_function = $this->getDatosCuentaPorComprobante($em, $comp, $account_obj, $saldo_inicial_calculo, $obj_subcuenta ? $obj_subcuenta : null, $rows_data_criterios);
                    $row = array_merge($row, $data_function['datos']);
                    $saldo_inicial_calculo = $data_function['saldo'];

                }
            } else {
                $data_function = $this->getDatosCuentaPorComprobante($em, $comp, $account_obj, $saldo_inicial_calculo, $obj_subcuenta ? $obj_subcuenta : null, $rows_data_criterios);
                $row = array_merge($row, $data_function['datos']);
                $saldo_inicial_calculo = $data_function['saldo'];
            }
        }
        return ['success' => true, 'datos' => $row, 'saldo_inicial' => number_format($saldo_inicial_cuenta, 2)];
    }

    /**
     * @param $em EntityManagerInterface
     * @param $comp RegistroComprobantes Comprobante del cual buscaremos los docuemntos para verificar que la cuenta haya tenido movimiento para cada uno de los documentos
     * @param $account_obj Cuenta cuenta que estamos analizando
     * @param $saldo_inicial_calculo float saldo inicio de la cuneta obtenido de la entidad "SaldoCuentas"
     * @param $obj_subcuenta Subcuenta subcuenta que queremos analizar
     * @param $rows_data_criterios array con los codigos de los criterios de analisis a buscar
     * @return array con los datos del los documentos para los parametros especificados
     */
    public
    function getDatosCuentaPorComprobante($em, $comp, $account_obj, $saldo_inicial_calculo, $obj_subcuenta, $rows_data_criterios)
    {
        $row = [];
        $comprobante_cierre = $em->getRepository(ComprobanteCierre::class)->findBy([
            'id_comprobante' => $comp->getId()
        ]);

        foreach ($comprobante_cierre as $cc) {
            $cierre = $cc->getIdCierre();
            $row_movimientos = $this->getDataDetalles($em, $cierre->getFecha(), $comp->getIdAlmacen());
            foreach ($row_movimientos as $movimiento) {
                foreach ($movimiento['datos'] as $d) {
                    if ($d['nro_cuenta'] == $account_obj->getNroCuenta()) {
                        if ($obj_subcuenta) {
                            if ($obj_subcuenta->getNroSubcuenta() == $d['nro_subcuenta']) {
                                if (!empty($rows_data_criterios)) {
                                    if ($this->containCriteria($rows_data_criterios, $d)) {
                                        if ($obj_subcuenta->getDeudora() ) {
                                            if ($d['debito'] != '')
                                                $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['debito']);
                                            else
                                                $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['credito']);
                                        } elseif (!$obj_subcuenta->getDeudora()) {
                                            if ($d['debito'] != '')
                                                $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['debito']);
                                            else if ($d['credito'] != '')
                                                $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['credito']);
                                        }
                                        $row[] = array(
                                            'tipo_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                                            'nro_comprobante' => $comp->getNroConsecutivo(),
                                            'nro_consecutivo' => $movimiento['nro_doc'],
                                            'debito' => $d['debito'] != '' ? $d['debito'] : '',
                                            'credito' => $d['credito'] != '' ? $d['credito'] : '',
                                            'total' => number_format($saldo_inicial_calculo, 2)
                                        );
                                    }
                                } else {
                                    if ($obj_subcuenta->getDeudora()) {
                                        if ($d['debito'] != '')
                                            $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['debito']);
                                        else
                                            $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['credito']);
                                    } elseif (!$obj_subcuenta->getDeudora()) {
                                        if ($d['debito'] != '')
                                            $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['debito']);
                                        else if ($d['credito'] != '')
                                            $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['credito']);
                                    }
                                    $row[] = array(
                                        'tipo_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                                        'nro_comprobante' => $comp->getNroConsecutivo(),
                                        'nro_consecutivo' => $movimiento['nro_doc'],
                                        'debito' => $d['debito'] != '' ? $d['debito'] : '',
                                        'credito' => $d['credito'] != '' ? $d['credito'] : '',
                                        'total' => number_format($saldo_inicial_calculo, 2)
                                    );
                                }
                            }
                        } else {
                            if (!empty($rows_data_criterios)) {

                                if ($this->containCriteria($rows_data_criterios, $d)) {
                                    if ($account_obj->getDeudora() || $account_obj->getMixta()) {
                                        if ($d['debito'] != '')
                                            $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['debito']);
                                        else
                                            $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['credito']);
                                    } elseif (!$account_obj->getDeudora() && !$account_obj->getMixta()) {

                                        if ($d['debito'] != '')
                                            $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['debito']);
                                        else if ($d['credito'] != '')
                                            $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['credito']);
                                    }
                                    $row[] = array(
                                        'tipo_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                                        'nro_comprobante' => $comp->getNroConsecutivo(),
                                        'nro_consecutivo' => $movimiento['nro_doc'],
                                        'debito' => $d['debito'] != '' ? $d['debito'] : '',
                                        'credito' => $d['credito'] != '' ? $d['credito'] : '',
                                        'total' => number_format($saldo_inicial_calculo, 2)
                                    );
                                }
                            } else {
                                if ($account_obj->getDeudora() || $account_obj->getMixta()) {
                                    if ($d['debito'] != '')
                                        $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['debito']);
                                    else
                                        $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['credito']);
                                } elseif (!$account_obj->getDeudora() && !$account_obj->getMixta()) {

                                    if ($d['debito'] != '')
                                        $saldo_inicial_calculo -= AuxFunctions::getNumberByString($d['debito']);
                                    else if ($d['credito'] != '')
                                        $saldo_inicial_calculo += AuxFunctions::getNumberByString($d['credito']);
                                }
                                $row[] = array(
                                    'tipo_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                                    'nro_comprobante' => $comp->getNroConsecutivo(),
                                    'nro_consecutivo' => $movimiento['nro_doc'],
                                    'debito' => $d['debito'] != '' ? $d['debito'] : '',
                                    'credito' => $d['credito'] != '' ? $d['credito'] : '',
                                    'total' => number_format($saldo_inicial_calculo, 2)
                                );
                            }
                        }
                    }
                }
            }
        }
        return ['datos' => $row, 'saldo' => $saldo_inicial_calculo];
    }

    public
    function containCriteria($arr_criteria, $arr_element)
    {
        if (count($arr_criteria) == 3) {
            if ($arr_element['analisis_1'] == $arr_criteria[0] && $arr_element['analisis_2'] == $arr_criteria[1] && $arr_element['analisis_3'] == $arr_criteria[2])
                return true;
        }
        if (count($arr_criteria) == 2) {
            if ($arr_element['analisis_1'] == $arr_criteria[0] && $arr_element['analisis_2'] == $arr_criteria[1])
                return true;
        }
        if (count($arr_criteria) == 1) {
            if ($arr_element['analisis_1'] == $arr_criteria[0])
                return true;
        }
        return false;
    }

    public
    function getNro(EntityManagerInterface $em, $obj_documento)
    {
        /** @var Documento $obj_documento */
        $id_tipo = $obj_documento->getIdTipoDocumento()->getId();
        $nro = '';
        switch ($id_tipo) {
            case 1:
                /** @var InformeRecepcion $informe_recepcion */
                $informe_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'IRM-' . $informe_recepcion->getNroConcecutivo();
                break;
            case 2:
                /** @var InformeRecepcion $informe_recepcion */
                $informe_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'IRP-' . $informe_recepcion->getNroConcecutivo();
                break;
            case 3:
                /** @var Ajuste $ajuste_entrada */
                $ajuste_entrada = $em->getRepository(Ajuste::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'AE-' . $ajuste_entrada->getNroConcecutivo();
                break;
            case 4:
                /** @var Ajuste $ajuste_salida */
                $ajuste_salida = $em->getRepository(Ajuste::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'AS-' . $ajuste_salida->getNroConcecutivo();
                break;
            case 5:
                /** @var Transferencia $transferencia_entrada */
                $transferencia_entrada = $em->getRepository(Transferencia::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'TE-' . $transferencia_entrada->getNroConcecutivo();
                break;
            case 6:
                /** @var Transferencia $transferencia_salida */
                $transferencia_salida = $em->getRepository(Transferencia::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'TE-' . $transferencia_salida->getNroConcecutivo();
                break;
            case 7:
                /** @var ValeSalida $vale_salida */
                $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'VSM-' . $vale_salida->getNroConsecutivo();
                break;
            case 8:
                /** @var ValeSalida $vale_salida_producto */
                $vale_salida_producto = $em->getRepository(ValeSalida::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'VSP-' . $vale_salida_producto->getNroConsecutivo();
                break;
            case 9:
                /** @var Devolucion $devolucion */
                $devolucion = $em->getRepository(Devolucion::class)->findOneBy(['id_documento' => $obj_documento]);
                $nro = 'D-' . $devolucion->getNroConcecutivo();
                break;
        }
        return $nro;
    }

    /**
     * @Route("/getDatos", name="contabilidad_general_movimiento_cuenta_get_dato", methods={"POST"})
     */
    public
    function getDatos()
    {
        $em = $this->getDoctrine()->getManager();
//        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM','EXP','CCT','EG']);
        $cuentas = $em->getRepository(Cuenta::class)->findAll();

        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        $rows_cuentas = [];
        if (!empty($cuentas)) {
            foreach ($cuentas as $item) {
                //subcuentas
                $arr_obj_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
                    'activo' => true,
                    'id_cuenta' => $item
                ));

                $rows_subcuentas = [];
                if (!empty($arr_obj_subcuentas)) {
                    foreach ($arr_obj_subcuentas as $subcuenta) {
                        /**@var $subcuenta Subcuenta* */
                        $rows_subcuentas [] = array(
                            'nro_cuenta' => $subcuenta->getIdCuenta()->getNroCuenta(),
                            'nro_subcuenta' => trim($subcuenta->getNroSubcuenta()) . ' - ' . trim($subcuenta->getDescripcion()),
                            'id' => $subcuenta->getId()
                        );
                    }
                }

                /**@var $item Cuenta */
                $rows_cuentas [] = array(
                    'nro_cuenta' => $item->getNroCuenta() . ' - ' . $item->getNombre(),
                    'sub_cuenta' => $rows_subcuentas
                );
            }
        }

        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
                );
            }
        }
        //centro de costo
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $this->getUser()
        ));

        $centro_costo_arr = $em->getRepository(CentroCosto::class)->findBy(array(
            'activo' => true,
            'id_unidad' => $empleado->getIdUnidad()
        ));

        $centros_costo = [];
        if (!empty($centro_costo_arr)) {
            /** @var CentroCosto $centroCosto */
            foreach ($centro_costo_arr as $centroCosto) {
                $centros_costo[] = array(
                    'id' => $centroCosto->getId(),
                    'nombre' => $centroCosto->getCodigo() . ' - ' . $centroCosto->getNombre()
                );
            }
        }

        $almacen_arr = $em->getRepository(Almacen::class)->findBy(array(
            'id_unidad' => $empleado->getIdUnidad(),
            'activo' => true
        ));
        $almacenes = [];
        if (!empty($almacen_arr)) {
            /** @var Almacen $almacen */
            foreach ($almacen_arr as $almacen) {
                $almacenes[] = array(
                    'id' => $almacen->getId(),
                    'nombre' => $almacen->getCodigo() . ' - ' . $almacen->getDescripcion()
                );
            }
        }

        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo() . ' - ' . $item->getDescripcion()
                );
            }
        }

        $orden_trabajo_arr = $em->getRepository(OrdenTrabajo::class)->findBy([
            'id_unidad' => $empleado->getIdUnidad(),
            'anno' => Date('Y')
        ]);
        $expediente_arr = $em->getRepository(Expediente::class)->findBy([
            'id_unidad' => $empleado->getIdUnidad(),
            'anno' => Date('Y')
        ]);
        $row_ot = [];
        $row_exp = [];

        /** @var OrdenTrabajo $element */
        foreach ($orden_trabajo_arr as $element) {
            $row_ot[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getDescripcion(),
                'id' => $element->getId()
            );
        }
        /** @var Expediente $element */
        foreach ($expediente_arr as $element) {
            $row_exp[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getDescripcion(),
                'id' => $element->getId()
            );
        }

        $proveedores = $em->getRepository(Proveedor::class)->findAll();

        /** @var Proveedor $element */
        foreach ($proveedores as $element) {
            $row_prov[] = array(
                'nombre' => $element->getCodigo() . ' - ' . $element->getNombre(),
                'id' => $element->getId()
            );
        }

        return new JsonResponse([
            'cuentas_inventario' => $rows_cuentas,
            'elemento_gasto' => $rows,
            'centro_costo' => $centros_costo,
            'almacenes' => $almacenes,
            'ordenes' => $row_ot,
            'expedientes' => $row_exp,
            'cliente' => [],
            'proveedor' => $row_prov,
            'success' => true
        ]);

    }

    public
    function getDataDetalles($em, $fecha, $id_almacen)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen,
            'activo' => true,
            'fecha' => $fecha
        ));
        foreach ($arr_obj_documentos as $obj_documento) {
            /**@var $obj_documento Documento* */
            $nro_doc = '';
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
            /**@var $obj_documento Documento* */
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            //informe recepcion mercancia
            if ($id_tipo_documento == 1) {
                $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_informe);
            } //informe recepcion producto
            elseif ($id_tipo_documento == 2) {
                $datos_informe = AuxFunctions::getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_informe);
            } //Ajuste de entrada
            elseif ($id_tipo_documento == 3) {
                $datos_ajuste_entreada = AuxFunctions::getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_ajuste_entreada);
            } //Ajuste de salida
            elseif ($id_tipo_documento == 4) {
                $datos_ajuste_salida = AuxFunctions::getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_ajuste_salida);
            } //transferencia de entrada
            elseif ($id_tipo_documento == 5) {
                $datos_transferencia_entrada = AuxFunctions::getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_transferencia_entrada);
            } //transferencia de salida
            elseif ($id_tipo_documento == 6) {
                $datos_transferencia = AuxFunctions::getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_transferencia);
            } //vale salida de mercancia
            elseif ($id_tipo_documento == 7) {
                $datos_vale = AuxFunctions::getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_vale);
            } //vale salida de producto
            elseif ($id_tipo_documento == 8) {

            }//devolucion
            elseif ($id_tipo_documento == 9) {
                $datos_devolucion = AuxFunctions::getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_devolucion);
            }
            $retur_rows [] = array(
                'nro_doc' => $rows[0]['nro_doc'],
                'datos' => $rows
            );
            $rows = [];
        }
        return !empty($retur_rows) ? $retur_rows : [];
    }
}