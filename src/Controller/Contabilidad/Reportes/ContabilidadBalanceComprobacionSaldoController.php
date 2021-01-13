<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\Asiento;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContabilidadBalanceComprobacionSaldoController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/contabilidad-balance-comprobacion-saldo")
 */
class ContabilidadBalanceComprobacionSaldoController extends ControllerContabilidadReport
{
    private $TIPO_CUENTA = 1;
    private $TIPO_SUBCUENTA = 2;
    private $TIPO_CRITERIO = 3;

    /**
     * @Route("/", name="contabilidad_reportes_contabilidad_balance_comprobacion_saldo")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {

        $list_balance_comprobacion = $this->getData($em);
        $paginator = $pagination->paginate(
            $list_balance_comprobacion,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('contabilidad/reportes/contabilidad_balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'ContabilidadBalanceComprobacionSaldoController',
            'cuentas' => $paginator
        ]);
    }

    /**
     * @Route("/print", name="contabilidad_reportes_balance_comprobacion_saldo_print")
     */
    public function print(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $list_balance_comprobacion = $this->getData($em);
        return $this->render('contabilidad/reportes/contabilidad_balance_comprobacion_saldo/print.html.twig', [
            'datos' => $list_balance_comprobacion,
            'unidad_codigo' => $unidad->getCodigo(),
            'unidad_nombre' => $unidad->getNombre()
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
                    'saldo' => number_format($saldo_cuenta['saldo'], 2),
                    'credito_mes' => number_format($saldo_cuenta['credito'], 2),
                    'debito_mes' => number_format($saldo_cuenta['debito'], 2),
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
                    'saldo' => number_format($saldo_subcuenta['saldo'], 2),
                    'credito_mes' => number_format($saldo_subcuenta['credito'], 2),
                    'debito_mes' => number_format($saldo_subcuenta['debito'], 2),
                    'index' => $this->TIPO_SUBCUENTA
                );
            }
            // generar la Criterio
            $saldo_criterio = $temp_cuenta->getDeudora()
                ? $debito - $credito
                : $credito - $debito;
            $list_balance_comprobacion[] = array(
                'id_cuenta' => $asiento->getIdCuenta()->getId(),
                'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                'criterio' => $this->generateCriterioOneAsiento($asiento),
                'codigo' => $this->generateCriterioOneAsiento($asiento),

                'descripcion' => $this->generateCriterioOneAsientoDesc($asiento),
                'saldo' => number_format($saldo_criterio, 2),
                'credito_mes' => number_format($credito, 2),
                'debito_mes' => number_format($debito, 2),
                'index' => $this->TIPO_CRITERIO
            );

        }
        return $list_balance_comprobacion;
    }


    private function generateCriterioOneAsiento(Asiento $asiento)
    {
        $lista = [];
        if ($asiento->getIdAlmacen()) array_push($lista, $asiento->getIdAlmacen()->getCodigo());
        if ($asiento->getIdCentroCosto()) array_push($lista, $asiento->getIdCentroCosto()->getCodigo());
        if ($asiento->getIdElementoGasto()) array_push($lista, $asiento->getIdElementoGasto()->getCodigo());
        if ($asiento->getIdOrdenTrabajo()) array_push($lista, $asiento->getIdOrdenTrabajo()->getCodigo());
        if ($asiento->getIdExpediente()) array_push($lista, $asiento->getIdExpediente()->getCodigo());
        if ($asiento->getIdCliente()) array_push($lista, $asiento->getIdCliente());
        if ($asiento->getTipoCliente()) array_push($lista, $asiento->getTipoCliente());

        return implode('-', $lista);
    }

    private function generateCriterioOneAsientoDesc(Asiento $asiento)
    {
        $lista = [];
        if ($asiento->getIdAlmacen()) array_push($lista, 'ALM');
        if ($asiento->getIdCentroCosto()) array_push($lista, 'CCT');
        if ($asiento->getIdElementoGasto()) array_push($lista, 'EG');
        if ($asiento->getIdOrdenTrabajo()) array_push($lista, 'OT');
        if ($asiento->getIdExpediente()) array_push($lista, 'EXP');
        if ($asiento->getIdCliente()) array_push($lista, 'CLT');
        if ($asiento->getTipoCliente()) array_push($lista, 'TCLT');

        return implode('-', $lista);
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
