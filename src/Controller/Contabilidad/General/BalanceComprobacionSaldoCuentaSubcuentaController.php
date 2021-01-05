<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
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
    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo_cuenta_subcuenta")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);
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
                $rows_data_subcuenta[] = array(
                    'cuenta' => '',
                    'descripcion' => $descripcion_subcuenta,
                    'id_cuenta' => $id_cuenta,
                    'subcuenta' => $nro_subcuenta,
                    'id_subcuenta' => $id_subcuenta,
                    'credito_acumulado' => '',
                    'debito_acumulado' => number_format($saldo,2),
                    'credito_mes' => number_format($credito_subcuenta,2),
                    'debito_mes' => number_format($debito_subcuenta,2),
                    'index' => 1
                );
            }
            $saldo_cuenta = $this->getSumbayor($em, $obj_cuenta, null, $asiento_er, $year, $unidad, 0);
            $row[] = array(
                'cuenta' => $nro_cuenta,
                'descripcion' => $descripcion_cuenta,
                'id_cuenta' => $id_cuenta,
                'subcuenta' => '',
                'id_subcuenta' => '',
                'credito_acumulado' => '',
                'debito_acumulado' => number_format($saldo_cuenta,2),
                'credito_mes' => number_format($credito_mes,2),
                'debito_mes' => number_format($debito_mes,2),
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
        return $this->render('contabilidad/general/balance_comprobacion_saldo_cuenta_subcuenta/index.html.twig', [
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
                if($obj_subcuenta->getDeudora())
                    $sado_ += ($asiento->getDebito() - $asiento->getCredito());
                else
                    $sado_ += ($asiento->getCredito() - $asiento->getDebito());
            }
//                }
        }
        return $sado_;
    }
}
