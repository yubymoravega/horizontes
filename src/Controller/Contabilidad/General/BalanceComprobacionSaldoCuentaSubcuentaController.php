<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Inventario\SaldoCuentas;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BalanceComprobacionSaldoCuentaSubcuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/balance-comprobacion-saldo-cuenta-subcuenta")
 */
class BalanceComprobacionSaldoCuentaSubcuentaController extends AbstractController
{
    private $TIPO_CUENTA = 1;
    private $TIPO_SUBCUENTA = 2;

    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo_cuenta_subcuenta")
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
        return $this->render('contabilidad/general/balance_comprobacion_saldo_cuenta_subcuenta/index.html.twig', [
            'controller_name' => 'BalanceComprobacionSaldoController',
            'cuentas' => $paginator
        ]);
    }

    /**
     * @Route("/print", name="contabilidad_general_balance_comprobacion_cuenta_sub_print")
     */
    public function print(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $list_balance_comprobacion = $this->getData($em);
        return $this->render('contabilidad/general/balance_comprobacion_saldo_cuenta_subcuenta/print.html.twig', [
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

        $data_asiento = $asiento_er->GroupForBalanceComprobacionCuenta($year, $unidad);
        $list_balance_comprobacion = [];

        foreach ($data_asiento as $asiento_arr) {
            $no_cuenta = true;

            /** @var Asiento $asiento */
            $asiento = $asiento_arr['asiento'];
            $credito = $asiento_arr['credito'];
            $debito = $asiento_arr['debito'];

            $temp_cuenta = $asiento->getIdCuenta();

            foreach ($list_balance_comprobacion as $balance_operacion) {
                if ($balance_operacion['id_cuenta'] == $temp_cuenta->getId()) $no_cuenta = false;
                if ($no_cuenta == false) break;
            }

            if ($no_cuenta) {
                // generar la Cuenta
                $saldo_cuenta = $this->getSumbayor($temp_cuenta->getId(), $data_asiento);
                $list_balance_comprobacion[] = array(
                    'id_cuenta' => $asiento->getIdCuenta()->getId(),
                    'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                    'codigo' => $asiento->getIdCuenta()->getNroCuenta(),

                    'descripcion' => $asiento->getIdCuenta()->getNombre(),
                    'saldo' => number_format($saldo_cuenta['saldo'], 2),
                    'credito_mes' => number_format($saldo_cuenta['credito'], 2),
                    'debito_mes' => number_format($saldo_cuenta['debito'], 2),
                    'index' => $this->TIPO_CUENTA
                );
            }
            // generar la Subcuenta
            $saldo_ = $temp_cuenta->getDeudora()
                ? $debito - $credito
                : $credito - $debito;
            $list_balance_comprobacion[] = array(
                'id_cuenta' => $asiento->getIdCuenta()->getId(),
                'id_subcuenta' => $asiento->getIdSubcuenta()->getId(),
                'codigo' => $asiento->getIdSubcuenta()->getNroSubcuenta(),

                'descripcion' => $asiento->getIdSubcuenta()->getDescripcion(),
                'saldo' => number_format($saldo_, 2),
                'credito_mes' => number_format($credito, 2),
                'debito_mes' => number_format($debito, 2),
                'index' => $this->TIPO_SUBCUENTA
            );
        }
        return $list_balance_comprobacion;
    }

    public function getSumbayor($cuenta, $arr_asiento)
    {
        $sado_ = 0;
        $credito = 0;
        $debito = 0;

        foreach ($arr_asiento as $asiento_ar) {
            /** @var Asiento $asiento */
            $asiento = $asiento_ar['asiento'];
            $asiento_credito = $asiento_ar['credito'];
            $asiento_debito = $asiento_ar['debito'];

            if ($cuenta == $asiento->getIdCuenta()->getId()) {
                if ($asiento->getIdCuenta()->getDeudora())
                    $sado_ += ($asiento_debito - $asiento_credito);
                else
                    $sado_ += ($asiento_credito - $asiento_debito);

                $credito += $asiento_credito;
                $debito += $asiento_debito;
            }
        }
        return ['saldo' => $sado_, 'credito' => $credito, 'debito' => $debito];
    }
}
