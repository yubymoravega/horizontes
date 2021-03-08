<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CapitalHumanoNominasController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/capital-humano/nominas")
 */
class CapitalHumanoNominasController extends ControllerContabilidadReport
{
    /**
     * @Route("/", name="contabilidad_reportes_capital_humano_nominas")
     */
    public function index()
    {
        return $this->render('contabilidad/reportes/capital_humano_nominas/index.html.twig', [
            'controller_name' => 'ReporteNominaController',
        ]);
    }

    /**
     * @Route("/print", name="contabilidad_reporte_capital_humano_nomina_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $anno = $request->request->get('anno');
        $mes = $request->request->get('mes');
        $quincena = $request->request->get('quincena');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $nominas = $em->getRepository(NominaPago::class)->findBy([
            'quincena' => $quincena,
            'mes' => $mes,
            'anno' => $anno,
            'id_unidad' => $unidad
        ]);
        /** @var NominaPago $item */
        $row = [];
        $aprobada = false;

        $sueldo_bruto = 0;
        $comision = 0;
        $vacaciones = 0;
        $horas_extra = 0;
        $otros = 0;
        $total_ingresos = 0;
        $ingresos_cotizables = 0;
        $isr = 0;
        $ars = 0;
        $afp = 0;
        $cooperativa = 0;
        $plan_medico_complementario = 0;
        $restaurant = 0;
        $total_deducido = 0;
        $sueldo_neto_pagar = 0;
        $afp_empleador = 0;
        $sfs_empleador = 0;
        $srl_empleador = 0;
        $infotep_empleador = 0;

        foreach ($nominas as $key => $item) {
            if ($item->getAprobada())
                $aprobada = true;
            $row[] = [
                'index' => $key % 2,
                'empleado' => $item->getIdEmpleado()->getNombre(),
                'identificacion' => $item->getIdEmpleado()->getIdentificacion(),
                'sueldo_bruto' => number_format($item->getSalarioBruto(), 2),
                'comision' => number_format($item->getComision(), 2),
                'vacaciones' => number_format($item->getVacaciones(), 2),
                'horas_extra' => number_format($item->getHorasExtra(), 2),
                'otros' => number_format($item->getOtros(), 2),
                'total_ingresos' => number_format($item->getTotalIngresos(), 2),
                'ingresos_cotizables' => number_format($item->getIngresosCotizablesTss(), 2),
                'isr' => number_format($item->getIsr(), 2),
                'ars' => number_format($item->getArs(), 2),
                'afp' => number_format($item->getAfp(), 2),
                'cooperativa' => number_format($item->getCooperativa(), 2),
                'plan_medico_complementario' => number_format($item->getPlanMedicoComplementario(), 2),
                'restaurant' => number_format($item->getRestaurant(), 2),
                'total_deducido' => number_format($item->getTotalDeducido(), 2),
                'sueldo_neto_pagar' => number_format($item->getSueldoNetoPagar(), 2),
                'afp_empleador' => number_format($item->getAfpEmpleador(), 2),
                'sfs_empleador' => number_format($item->getSfsEmpleador(), 2),
                'srl_empleador' => number_format($item->getSrlEmpleador(), 2),
                'infotep_empleador' => number_format($item->getInfotepEmpleador(), 2),
            ];

            $sueldo_bruto += $item->getSalarioBruto();
            $comision += $item->getComision();
            $vacaciones += $item->getVacaciones();
            $horas_extra += $item->getHorasExtra();
            $otros += $item->getOtros();
            $total_ingresos += $item->getTotalIngresos();
            $ingresos_cotizables += $item->getIngresosCotizablesTss();
            $isr += $item->getIsr();
            $ars += $item->getArs();
            $afp += $item->getAfp();
            $cooperativa += $item->getCooperativa();
            $plan_medico_complementario += $item->getPlanMedicoComplementario();
            $restaurant += $item->getRestaurant();
            $total_deducido += $item->getTotalDeducido();
            $sueldo_neto_pagar += $item->getSueldoNetoPagar();
            $afp_empleador += $item->getAfpEmpleador();
            $sfs_empleador += $item->getSfsEmpleador();
            $srl_empleador += $item->getSrlEmpleador();
            $infotep_empleador += $item->getInfotepEmpleador();

        }
        $row[] = [
            'empleado' => 'TOTAL',
            'identificacion' => '',
            'sueldo_bruto' => number_format($sueldo_bruto, 2),
            'comision' => number_format($comision, 2),
            'vacaciones' => number_format($vacaciones, 2),
            'horas_extra' => number_format($horas_extra, 2),
            'otros' => number_format($otros, 2),
            'total_ingresos' => number_format($total_ingresos, 2),
            'ingresos_cotizables' => number_format($ingresos_cotizables, 2),
            'isr' => number_format($isr, 2),
            'ars' => number_format($ars, 2),
            'afp' => number_format($afp, 2),
            'cooperativa' => number_format($cooperativa, 2),
            'plan_medico_complementario' => number_format($plan_medico_complementario, 2),
            'restaurant' => number_format($restaurant, 2),
            'total_deducido' => number_format($total_deducido, 2),
            'sueldo_neto_pagar' => number_format($sueldo_neto_pagar, 2),
            'afp_empleador' => number_format($afp_empleador, 2),
            'sfs_empleador' => number_format($sfs_empleador, 2),
            'srl_empleador' => number_format($srl_empleador, 2),
            'infotep_empleador' => number_format($infotep_empleador, 2),
        ];
//        dd($row);
        return $this->render('contabilidad/capital_humano/reporte_nomina/print.html.twig', [
            'controller_name' => 'ReporteNominaController',
            'mes' => AuxFunctions::getNombreMes($mes),
            'anno' => $anno,
            'unidad' => $unidad->getCodigo() . ' - ' . $unidad->getNombre(),
            'fecha_impresion' => Date('d-m-Y'),
            'datos' => $row,
            'title' => $aprobada ? 'Nómina de Pago' : 'Prenomina de Pago',
            'aprobada' => $aprobada,
            'quincena' => $quincena
        ]);
    }
}
