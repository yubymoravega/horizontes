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
            if (!in_array($id_cuenta, $arr_repeat_cuenta) && $asiento->getIdComprobante()!=null)
                $arr_repeat_cuenta[count($arr_repeat_cuenta)] = $id_cuenta;
        }
        array_multisort($arr_repeat_cuenta, SORT_ASC, SORT_NUMERIC);

        $row = [];
        foreach ($arr_repeat_cuenta as $id_cuenta) {
            $credito_mes = 0;
            $debito_mes = 0;
            $saldo = 0;
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
                foreach ($data_asiento as $asiento) {
                    $id_cuenta_ = $asiento->getIdCuenta()->getId();
                    $id_subcuenta_ = $asiento->getIdSubcuenta()->getId();
                    if ($id_cuenta == $id_cuenta_ && $id_subcuenta_ == $id_subcuenta && $asiento->getIdComprobante()!=null) {
                        $descripcion_subcuenta = $asiento->getIdSubcuenta()->getDescripcion();
                        $nro_subcuenta = $asiento->getIdSubcuenta()->getNroSubcuenta();
                        $credito_mes += $asiento->getCredito();
                        $debito_mes += $asiento->getDebito();
                        $credito_subcuenta += $asiento->getCredito();
                        $debito_subcuenta += $asiento->getDebito();
                    }
                }
                $rows_data_subcuenta[] = array(
                    'cuenta' => '',
                    'descripcion' => $descripcion_subcuenta,
                    'id_cuenta' => $id_cuenta,
                    'subcuenta' => $nro_subcuenta,
                    'id_subcuenta' => $id_subcuenta,
                    'credito_acumulado' => '',
                    'debito_acumulado' => '',
                    'credito_mes' => $credito_subcuenta,
                    'debito_mes' => $debito_subcuenta,
                    'index' => 1
                );
            }
            $row[] = array(
                'cuenta' => $nro_cuenta,
                'descripcion' => $descripcion_cuenta,
                'id_cuenta' => $id_cuenta,
                'subcuenta' => '',
                'id_subcuenta' => '',
                'credito_acumulado' => '',
                'debito_acumulado' => '',
                'credito_mes' => $credito_mes,
                'debito_mes' => $debito_mes,
                'index' => 1
            );
            $row = array_merge($row,$rows_data_subcuenta);
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

}
