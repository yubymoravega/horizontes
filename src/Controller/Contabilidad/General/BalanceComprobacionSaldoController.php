<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BalanceComprobacionSaldoController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/balance-comprobacion-saldo")
 */
class BalanceComprobacionSaldoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $asiento_er = $em->getRepository(Asiento::class);
        $year = Date('Y');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());

        $data_asiento = $asiento_er->findBy([
            'anno' => $year,
            'id_unidad' => $unidad
        ]);

        $arr_repeat_cuenta = [];
        /** @var Asiento $asiento */
        foreach ($data_asiento as $asiento) {
            $id_cuenta = $asiento->getIdCuenta()->getId();
            if (!in_array($id_cuenta, $arr_repeat_cuenta) && $asiento->getIdComprobante() != null)
                $arr_repeat_cuenta[count($arr_repeat_cuenta)] = $id_cuenta;
        }
        array_multisort($arr_repeat_cuenta, SORT_ASC, SORT_NUMERIC);

        $row = [];
        foreach ($arr_repeat_cuenta as $id_cuenta) {
            $credito_mes = 0;
            $debito_mes = 0;
            $arr_subcuenta = [];
            $descripcion_cuenta = $cuenta_er->find($id_cuenta)->getNombre();
            $nro_cuenta = $cuenta_er->find($id_cuenta)->getNroCuenta();
            /** @var Asiento $asiento */
            foreach ($data_asiento as $asiento) {
                if ($asiento->getIdCuenta()->getId() == $id_cuenta) {
                    $id_subcuenta = $asiento->getIdSubcuenta()->getId();
                    if (!in_array($id_subcuenta, $arr_subcuenta)) {
                        $arr_subcuenta[count($arr_subcuenta)] = $id_subcuenta;
                    }
                }
            }
            $rows_data_subcuenta = [];
            foreach ($arr_subcuenta as $id_subcuenta) {
                $credito_subcuenta = 0;
                $debito_subcuenta = 0;
                $nro_subcuenta = '';
                $descripcion_subcuenta = '';
                $obj_cuenta = null;
                $obj_subcuenta = null;
                foreach ($data_asiento as $asiento) {
                    $id_cuenta_ = $asiento->getIdCuenta()->getId();
                    $id_subcuenta_ = $asiento->getIdSubcuenta()->getId();
                    if ($id_cuenta == $id_cuenta_ && $id_subcuenta_ == $id_subcuenta && $asiento->getIdComprobante() != null) {
                        $descripcion_subcuenta = $asiento->getIdSubcuenta()->getDescripcion();
                        $nro_subcuenta = $asiento->getIdSubcuenta()->getNroSubcuenta();
                        $credito_mes += $asiento->getCredito();
                        $debito_mes += $asiento->getDebito();
                        $credito_subcuenta += $asiento->getCredito();
                        $debito_subcuenta += $asiento->getDebito();
                        $obj_cuenta = $asiento->getIdCuenta();
                        $obj_subcuenta = $asiento->getIdSubcuenta();
                    }
                }
                $saldo = $this->getSumbayor($em, $obj_cuenta, $obj_subcuenta, $asiento_er, $year, $unidad, 0);
                //data subcuenta
                $rows_data_subcuenta[] = array(
                    'cuenta' => '',
                    'criterio' => '',
                    'descripcion' => $descripcion_subcuenta,
                    'id_cuenta' => $id_cuenta,
                    'subcuenta' => $nro_subcuenta,
                    'id_subcuenta' => $id_subcuenta,
                    'credito_acumulado' => '',
                    'debito_acumulado' => number_format($saldo, 2),
                    'credito_mes' => number_format($credito_subcuenta, 2),
                    'debito_mes' => number_format($debito_subcuenta, 2),
                    'index' => 2
                );

                //data criterios
                $data_asiento_subcuenta = $asiento_er->findBy([
                    'anno' => $year,
                    'id_unidad' => $unidad,
                    'id_subcuenta' => $subcuenta_er->find($id_subcuenta)
                ]);

                $criterios = AuxFunctions::getCriterioByCuenta($nro_cuenta, $em);
//                $data_criterio = [];
//                foreach ($data_asiento_subcuenta as $item) {
//                        $cod_cct = $item->getIdCentroCosto()?$item->getIdCentroCosto()->getCodigo():'';
//                        $cod_ot = $item->getIdOrdenTrabajo()?$item->getIdOrdenTrabajo()->getCodigo():'';
//                        $cod_eg = $item->getIdElementoGasto()?$item->getIdElementoGasto()->getCodigo():'';
//                        $cod_expediente = $item->getIdExpediente()?$item->getIdExpediente()->getCodigo():'';
//                        $cod_almacen = $item->getIdAlmacen()?$item->getIdAlmacen()->getCodigo():'';
//                        $str_repeat = $cod_cct.'-'.$cod_ot.'-'.$cod_eg.'-'.$cod_expediente.'-'.$cod_almacen.'-'.$cod_expediente;
//                        if (!in_array($str_repeat, $data_criterio)) {
//                            $data_criterio[count($data_criterio)] = $str_repeat;
//                        }
//                    }
//                }
//
//
//                foreach ($data_criterio as $criterio) {
//                    $debito_criterio =0;
//                    $credito_criterio =0;
//                    foreach ($data_asiento_subcuenta as $data){
//                        $cod_cct = $item->getIdCentroCosto()?$item->getIdCentroCosto()->getCodigo():'';
//                        $cod_ot = $item->getIdOrdenTrabajo()?$item->getIdOrdenTrabajo()->getCodigo():'';
//                        $cod_eg = $item->getIdElementoGasto()?$item->getIdElementoGasto()->getCodigo():'';
//                        $cod_expediente = $item->getIdExpediente()?$item->getIdExpediente()->getCodigo():'';
//                        $cod_almacen = $item->getIdAlmacen()?$item->getIdAlmacen()->getCodigo():'';
//                        $str_repeat = $cod_cct.'-'.$cod_ot.'-'.$cod_eg.'-'.$cod_expediente.'-'.$cod_almacen.'-'.$cod_expediente;
//                        if($str_repeat == $criterio){
//                            $codigo_criterio = $str_repeat;
//                            //$descripcion_criterio = $data->getIdCentroCosto()->getNombre();
//                            $debito_criterio += $data->getDebito();
//                            $credito_criterio += $data->getCredito();
//                        }
//                    }
//                    $rows_data_subcuenta[] = array(
//                        'cuenta' => '',
//                        'criterio' => $codigo_criterio,
//                        'descripcion' => $descripcion_criterio,
//                        'id_cuenta' => $id_cuenta,
//                        'subcuenta' => '',
//                        'id_subcuenta' => $id_subcuenta,
//                        'credito_acumulado' => '',
//                        'debito_acumulado' => number_format($saldo, 2),
//                        'credito_mes' => number_format($credito_criterio, 2),
//                        'debito_mes' => number_format($debito_criterio, 2),
//                        'index' => 3
//                    );
//                }

            foreach ($criterios as $criterio) {
                    $codigo_criterio = '';
                    $descripcion_criterio = '';
                    $debito_criterio = 0;
                    $credito_criterio = 0;
                    $data_criterio = [];
                    if ($criterio == 'CCT') {
                        /** @var Asiento $item */
                        foreach ($data_asiento_subcuenta as $item) {
                            if ($item->getIdCentroCosto()){
                                if (!in_array($item->getIdCentroCosto()->getCodigo(), $data_criterio)) {
                                    $data_criterio[count($data_criterio)] = $item->getIdCentroCosto()->getCodigo();
                                }
                            }
                        }
                        foreach ($data_criterio as $criteria){
                            $debito_criterio =0;
                            $credito_criterio =0;
                            foreach ($data_asiento_subcuenta as $data){
                                if($data->getIdCentroCosto() && $data->getIdCentroCosto()->getCodigo() == $criteria){
                                    $codigo_criterio = $criteria;
                                    $descripcion_criterio = $data->getIdCentroCosto()->getNombre();
                                    $debito_criterio += $data->getDebito();
                                    $credito_criterio += $data->getCredito();
                                }
                            }
                            $rows_data_subcuenta[] = array(
                                'cuenta' => '',
                                'criterio' => $codigo_criterio,
                                'descripcion' => $descripcion_criterio,
                                'id_cuenta' => $id_cuenta,
                                'subcuenta' => '',
                                'id_subcuenta' => $id_subcuenta,
                                'credito_acumulado' => '',
                                'debito_acumulado' => number_format($saldo, 2),
                                'credito_mes' => number_format($credito_criterio, 2),
                                'debito_mes' => number_format($debito_criterio, 2),
                                'index' => 3
                            );
                        }
                    }
////                    if ($criterio == 'OT') {
////                        $codigo_criterio = $item->getIdOrdenTrabajo() ? $item->getIdOrdenTrabajo()->getCodigo() : '';
////                        $descripcion_criterio = $item->getIdOrdenTrabajo() ? $item->getIdOrdenTrabajo()->getDescripcion() : '';
////                        $debito_criterio = $item->getDebito();
////                        $credito_criterio = $item->getCredito();
////                    }
////                    if ($criterio == 'EG') {
////                        $codigo_criterio = $item->getIdElementoGasto() ? $item->getIdElementoGasto()->getCodigo() : '';
////                        $descripcion_criterio = $item->getIdElementoGasto() ? $item->getIdElementoGasto()->getDescripcion() : '';
////                        $debito_criterio = $item->getDebito();
////                        $credito_criterio = $item->getCredito();
////                    }
////                    if ($criterio == 'ALM') {
////                        $codigo_criterio = $item->getIdAlmacen() ? $item->getIdAlmacen()->getCodigo() : '';
////                        $descripcion_criterio = $item->getIdAlmacen() ? $item->getIdAlmacen()->getDescripcion() : '';
////                        $debito_criterio = $item->getDebito();
////                        $credito_criterio = $item->getCredito();
////                    }
                }
            }
            //data cuenta
            $saldo_cuenta = $this->getSumbayor($em, $obj_cuenta, null, $asiento_er, $year, $unidad, 0);
            $row[] = array(
                'cuenta' => $nro_cuenta,
                'criterio' => '',
                'descripcion' => $descripcion_cuenta,
                'id_cuenta' => $id_cuenta,
                'subcuenta' => '',
                'id_subcuenta' => '',
                'credito_acumulado' => '',
                'debito_acumulado' => number_format($saldo_cuenta, 2),
                'credito_mes' => number_format($credito_mes, 2),
                'debito_mes' => number_format($debito_mes, 2),
                'index' => 1
            );
            $row = array_merge($row, $rows_data_subcuenta);
        }
        foreach ($row as $k => $d) {
            if ($d['debito_acumulado'] == '' && $d['credito_acumulado'] == '' && $d['debito_mes'] == '' && $d['credito_mes'] == '')
                unset($row[$k]);
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/general/balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'BalanceComprobacionSaldoController',
            'cuentas' => $paginator
        ]);
    }

    public function getSumbayor(EntityManagerInterface $em, $obj_cuenta, $obj_subcuenta, $asiento_er, $anno, $unidad, $periodo)
    {
        $params = [];
        if ($obj_subcuenta) {
            $params[0]['id_subcuenta'] = $obj_subcuenta->getId();
        }
        if ($obj_cuenta) {
            $params[0]['id_cuenta'] = $obj_cuenta->getId();
        }
        if ($anno) {
            $params[0]['anno'] = intval($anno);
        }
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        if ($unidad) {
            $params[0]['id_unidad'] = $unidad->getId();
        }
        if ($periodo > 0) {
            $params[0]['mes'] = $periodo;
        }

        /*** (1)-para buscar el saldo inicial de la cuenta solamente, busco los saldos iniciales
         * para el espacio de tiempo especificado de
         * todas sus subcuentas, entonces los suma y pan ya
         ***/
        $arr_asientos = $asiento_er->findBy($params[0]);
        /** @var Asiento $asiento */
        $sado_ = 0;
        foreach ($arr_asientos as $asiento) {
//            if ($asiento->getIdComprobante() != null) {
            if (!$obj_subcuenta) {
                if ($obj_cuenta->getDeudora())
                    $sado_ += ($asiento->getDebito() - $asiento->getCredito());
                else
                    $sado_ += ($asiento->getCredito() - $asiento->getDebito());
            } else {
                if ($obj_subcuenta->getDeudora())
                    $sado_ += ($asiento->getDebito() - $asiento->getCredito());
                else
                    $sado_ += ($asiento->getCredito() - $asiento->getDebito());
            }
//                }
        }
        return $sado_;
    }
}