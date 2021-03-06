<?php

namespace App\Controller\Contabilidad\General;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
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
    private $TIPO_CUENTA = 1;
    private $TIPO_SUBCUENTA = 2;
    private $TIPO_CRITERIO = 3;

    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo")
     */
    public function index_real(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $list_balance_comprobacion = $this->getData($em);
        $paginator = $pagination->paginate(
            $list_balance_comprobacion,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/general/balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'BalanceComprobacionSaldoController',
            'cuentas' => $paginator
        ]);

    }

    /**
     * @Route("/print", name="contabilidad_general_balance_comprobacion_saldo_print")
     */
    public function print(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $list_balance_comprobacion = $this->getData($em);
        $mes_credito = 0;
        $mes_debito = 0;
        $acumulado_credito = 0;
        $acumulado_debito = 0;
        foreach ($list_balance_comprobacion as $item){
            if($item['index']==1||$item['index']=='1'){
                $mes_debito += $item['debito_mes_value'];
                $mes_credito += $item['credito_mes_value'];
                $acumulado_debito += $item['saldo_deudor_value'];
                $acumulado_credito += $item['saldo_acreedor_value'];
            }
        }
        return $this->render('contabilidad/general/balance_comprobacion_saldo/print.html.twig', [
            'datos' => $list_balance_comprobacion,
            'unidad_codigo' => $unidad->getCodigo(),
            'unidad_nombre' => $unidad->getNombre(),
            'mes_debito'=>number_format($mes_debito,2),
            'mes_credito'=>number_format($mes_credito,2),
            'acumulado_debito'=>number_format($acumulado_debito,2),
            'acumulado_credito'=>number_format($acumulado_credito,2),
            'fecha_impresion'=>Date('d-m-Y')
        ]);
    }

    private function getData(EntityManagerInterface $em)
    {

        $asiento_er = $em->getRepository(Asiento::class);
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $year = AuxFunctions::getCurrentYear($em, $unidad);

        $data_asiento = $asiento_er->GroupForBalanceComprobacion($year, $unidad);
        $list_balance_comprobacion = [];
//        dd($data_asiento);
        foreach ($data_asiento as $asiento_arr) {
            $no_cuenta = true;
            $no_subcuenta = true;

            /** @var Asiento $asiento */
            $asiento = $asiento_arr['asiento'];
            $credito = $asiento_arr['credito'];
            $debito = $asiento_arr['debito'];

            $temp_cuenta = $asiento->getIdCuenta();
            $temp_subcuenta = $asiento->getIdSubcuenta();


            foreach ($list_balance_comprobacion as $balance_operacion) {
                if ($balance_operacion['id_cuenta'] == $temp_cuenta->getId()) $no_cuenta = false;
                if ($balance_operacion['id_subcuenta'] == $temp_subcuenta->getId()) $no_subcuenta = false;
                if ($no_cuenta == false && $no_subcuenta == false) break;
            }

            if ($no_cuenta) {
                // generar la Cuenta
                $saldo_cuenta = $this->getSumbayorAll($temp_cuenta->getId(), null, $data_asiento);
                $list_balance_comprobacion[] = array(
                    'id_cuenta' => $asiento->getIdCuenta()->getId(),
                    'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                    'criterio' => '',
                    'codigo' => $asiento->getIdCuenta()->getNroCuenta(),

                    'descripcion' => $asiento->getIdCuenta()->getNombre(),
                    'saldo_deudor' => $asiento->getIdCuenta()->getDeudora()?number_format($saldo_cuenta['saldo'], 2):'',
                    'saldo_acreedor' => $asiento->getIdCuenta()->getDeudora()?'':number_format($saldo_cuenta['saldo'], 2),
                    'credito_mes' => $saldo_cuenta['credito']>0?number_format($saldo_cuenta['credito'], 2):'',
                    'debito_mes' => $saldo_cuenta['debito']>0?number_format($saldo_cuenta['debito'], 2):'',
                    'saldo_deudor_value' => $asiento->getIdCuenta()->getDeudora()? $saldo_cuenta['saldo']:0,
                    'saldo_acreedor_value' => $asiento->getIdCuenta()->getDeudora()?0:$saldo_cuenta['saldo'],
                    'credito_mes_value' => $saldo_cuenta['credito'],
                    'debito_mes_value' => $saldo_cuenta['debito'],
                    'index' => $this->TIPO_CUENTA
                );
            }
            if ($no_subcuenta) {
                // generar la Sub-Cuenta
                $saldo_subcuenta = $this->getSumbayorAll($temp_cuenta->getId(), $temp_subcuenta->getId(), $data_asiento);
                $list_balance_comprobacion[] = array(
                    'id_cuenta' => $asiento->getIdCuenta()->getId(),
                    'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                    'criterio' => '',
                    'codigo' => $asiento->getIdSubcuenta()->getNroSubcuenta(),

                    'descripcion' => $asiento->getIdSubcuenta()->getDescripcion(),
                    'saldo_deudor' => $asiento->getIdSubcuenta()->getDeudora()?number_format($saldo_subcuenta['saldo'], 2):'',
                    'saldo_acreedor' => $asiento->getIdSubcuenta()->getDeudora()?'':number_format($saldo_subcuenta['saldo'], 2),
                    'credito_mes' => $credito>0?number_format($saldo_subcuenta['credito'], 2):'',
                    'debito_mes' => $debito>0?number_format($saldo_subcuenta['debito'], 2):'',

                    'index' => $this->TIPO_SUBCUENTA
                );
            }
            // generar la Criterio
            $criterio = $this->generateCriterioOneAsiento($asiento, $em);
            if(!empty($criterio)){
                $saldo_criterio = $temp_cuenta->getDeudora()
                    ? $debito - $credito
                    : $credito - $debito;
                $list_balance_comprobacion[] = array(
                    'id_cuenta' => $asiento->getIdCuenta()->getId(),
                    'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                    'criterio' => $criterio,
                    'codigo' => $criterio,

                    'descripcion' => $this->generateCriterioOneAsientoDesc($asiento, $em),
                    'saldo_deudor' => $asiento->getIdSubcuenta()->getDeudora()?number_format($saldo_criterio, 2):'',
                    'saldo_acreedor' => $asiento->getIdSubcuenta()->getDeudora()?'':number_format($saldo_criterio, 2),
                    'credito_mes' => $credito>0?number_format($credito, 2):'',
                    'debito_mes' => $debito>0?number_format($debito, 2):'',
                    'index' => $this->TIPO_CRITERIO
                );
            }
        }
        return $list_balance_comprobacion;
    }


    private function generateCriterioOneAsiento(Asiento $asiento, EntityManagerInterface $em)
    {
        $arr_criterios_analisis = AuxFunctions::getCriterioByCuenta($asiento->getIdCuenta()->getNroCuenta(),$em);
        $lista = [];
        if(empty($arr_criterios_analisis))
            return [];
        foreach ($arr_criterios_analisis as $item){
            if($item == 'ALM'){
                if ($asiento->getIdAlmacen()) array_push($lista, $asiento->getIdAlmacen()->getCodigo());
            }
            elseif ($item == 'CCT'){
                if ($asiento->getIdCentroCosto()) array_push($lista, $asiento->getIdCentroCosto()->getCodigo());
            }
            elseif ($item == 'EG'){
                if ($asiento->getIdElementoGasto()) array_push($lista, $asiento->getIdElementoGasto()->getCodigo());
            }
            elseif ($item == 'OT'){
                if ($asiento->getIdOrdenTrabajo()) array_push($lista, $asiento->getIdOrdenTrabajo()->getCodigo());
            }
            elseif ($item == 'AR'){
                if ($asiento->getIdAreaResponsabilidad()) array_push($lista, $asiento->getIdAreaResponsabilidad()->getCodigo());
            }
            elseif ($item == 'GA'){
                if ($asiento->getIdActivoFijo()->getIdGrupoActivo()) array_push($lista, $asiento->getIdActivoFijo()->getIdGrupoActivo()->getCodigo());
            }
            elseif ($item == 'EXP'){
                if ($asiento->getIdExpediente()) array_push($lista, $asiento->getIdExpediente()->getCodigo());
            }
            elseif ($item == 'CLIPRO'){
                if ($asiento->getIdCliente()) {
                    $cliente = ClientesAdapter::getClienteFactory($em, $asiento->getTipoCliente());
                    $data = $cliente->find($asiento->getIdCliente());
                    array_push($lista, $data['codigo']);
                }
                elseif ($asiento->getIdProveedor()){
                    array_push($lista, $asiento->getIdProveedor()->getCodigo());
                }
            }
        }
//        if ($asiento->getTipoCliente()) array_push($lista, $asiento->getTipoCliente());

        return implode('; ', $lista);
    }

    private function generateCriterioOneAsientoDesc(Asiento $asiento, EntityManagerInterface $em)
    {
        $arr_criterios_analisis = AuxFunctions::getCriterioByCuenta($asiento->getIdCuenta()->getNroCuenta(),$em);
        $lista = [];
        if(empty($arr_criterios_analisis))
            return [];
        foreach ($arr_criterios_analisis as $item){
            if($item == 'ALM'){
                if ($asiento->getIdAlmacen()) array_push($lista, $asiento->getIdAlmacen()->getDescripcion());
            }
            elseif ($item == 'CCT'){
                if ($asiento->getIdCentroCosto()) array_push($lista, $asiento->getIdCentroCosto()->getNombre());
            }
            elseif ($item == 'EG'){
                if ($asiento->getIdElementoGasto()) array_push($lista, $asiento->getIdElementoGasto()->getDescripcion());
            }
            elseif ($item == 'OT'){
                if ($asiento->getIdOrdenTrabajo()) array_push($lista, $asiento->getIdOrdenTrabajo()->getDescripcion());
            }
            elseif ($item == 'AR'){
                if ($asiento->getIdAreaResponsabilidad()) array_push($lista, $asiento->getIdAreaResponsabilidad()->getNombre());
            }
            elseif ($item == 'GA'){
                if ($asiento->getIdActivoFijo()->getIdGrupoActivo()) array_push($lista, $asiento->getIdActivoFijo()->getIdGrupoActivo()->getDescripcion());
            }
            elseif ($item == 'EXP'){
                if ($asiento->getIdExpediente()) array_push($lista, $asiento->getIdExpediente()->getDescripcion());
            }
            elseif ($item == 'CLIPRO'){
                if ($asiento->getIdCliente()) {
                    $cliente = ClientesAdapter::getClienteFactory($em, $asiento->getTipoCliente());
                    $data = $cliente->find($asiento->getIdCliente());
                    array_push($lista, $data['nombre']);
                }
                elseif ($asiento->getIdProveedor()){
                    array_push($lista, $asiento->getIdProveedor()->getNombre());
                }
            }
        }//        if ($asiento->getTipoCliente()) array_push($lista, 'TCLT');

        return implode('; ', $lista);
    }

    public function getSumbayorAll($cuenta, $subcuenta = null, $arr_asiento)
    {
        $sado_ = 0;
        $credito = 0;
        $debito = 0;

        foreach ($arr_asiento as $asiento_ar) {
            /** @var Asiento $asiento */
            $asiento = $asiento_ar['asiento'];
            $asiento_credito = $asiento_ar['credito'];
            $asiento_debito = $asiento_ar['debito'];
            // para las Cuentas solamente
            if (is_null($subcuenta)) {
                if ($cuenta == $asiento->getIdCuenta()->getId()) {
                    if ($asiento->getIdCuenta()->getDeudora())
                        $sado_ += ($asiento_debito - $asiento_credito);
                    else
                        $sado_ += ($asiento_credito - $asiento_debito);

                    $credito += $asiento_credito;
                    $debito += $asiento_debito;
                }
            } // para las subcuentas
            else {
                if ($subcuenta == $asiento->getIdSubcuenta()->getId()) {
                    if ($asiento->getIdSubcuenta()->getDeudora())
                        $sado_ += ($asiento_debito - $asiento_credito);
                    else
                        $sado_ += ($asiento_credito - $asiento_debito);

                    $credito += $asiento_credito;
                    $debito += $asiento_debito;
                }
            }
        }
        return ['saldo' => $sado_, 'credito' => $credito, 'debito' => $debito];
    }
}