<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\Unidad;
use App\Form\Contabilidad\Reportes\UnidadChoicesType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ActivoFijoComprobanteAnotacionesController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes/activo-fijo-comprobante-anotaciones", name="contabilidad_reportes_activo_fijo_comprobante_anotaciones")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $data_movimientos = $em->getRepository(MovimientoActivoFijo::class)->findBy(['anno' => Date('Y'), 'id_unidad' => $unidad]);
        $cuenta_activo_er = $em->getRepository(ActivoFijoCuentas::class);
        $row = [];
        /** @var MovimientoActivoFijo $movimiento */
        $total = 0;
        foreach ($data_movimientos as $movimiento) {
            /** @var ActivoFijoCuentas $cuentas_activo_fijo */
            $cuentas_activo_fijo = $cuenta_activo_er->findOneBy(['id_activo' => $movimiento->getIdActivoFijo()]);
            $total += $movimiento->getIdActivoFijo()->getValorInicial();
            if ($movimiento->getEntrada()) {
                $row[] = array(
                    'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                    'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                    'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                    'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                    'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'credito' => '',
                    'criterio_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                    'criterio_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                );
                if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                        'debito' => '',
                        'credito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                }
                $row[] = array(
                    'nro' => '',
                    'fecha' => '',
                    'cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                    'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                    'debito' => '',
                    'credito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                    'criterio_1' => '',
                    'criterio_2' => ''
                );
                $row[] = array(
                    'nro' => '',
                    'fecha' => '',
                    'cuenta' => '',
                    'subcuenta' => '',
                    'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'criterio_1' => '',
                    'criterio_2' => ''
                );
            } else {
                if ($movimiento->getIdTipoMovimiento()->getId() == 6)
                    $row[] = array(
                        'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                        'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaGasto() ? $cuentas_activo_fijo->getIdCuentaGasto()->getNroCuenta() : '',
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaGasto() ? $cuentas_activo_fijo->getIdSubcuentaGasto()->getNroSubcuenta() : '',
                        'credito' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                else if ($movimiento->getIdTipoMovimiento()->getId() == 3)
                    $row[] = array(
                        'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                        'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo() ? $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta() : '',
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo() ? $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta() : '',
                        'credito' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                else
                    $row[] = array(
                        'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                        'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                        'credito' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                        'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                        'credito' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                        'criterio_1' => '',
                        'criterio_2' => ''
                    );
                }
                $row[] = array(
                    'nro' => '',
                    'fecha' => '',
                    'cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                    'subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                    'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'debito' => '',
                    'criterio_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                    'criterio_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                );

                $row[] = array(
                    'nro' => '',
                    'fecha' => '',
                    'cuenta' => '',
                    'subcuenta' => '',
                    'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                    'criterio_1' => '',
                    'criterio_2' => ''
                );
            }
        }
        $row[] = array(
            'nro' => '',
            'fecha' => '',
            'cuenta' => 'TOTAL',
            'subcuenta' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'criterio_1' => '',
            'criterio_2' => ''
        );
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/reportes/activo_fijo_comprobante_anotaciones/index.html.twig', [
            'controller_name' => 'ActivoFijoComprobanteAnotacionesController',
            'datos' => $paginator,
            'unidad' => $unidad->getCodigo() . ' - ' . $unidad->getNombre()
        ]);
    }
}
