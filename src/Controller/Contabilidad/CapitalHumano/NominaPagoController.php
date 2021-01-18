<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use App\Entity\Contabilidad\CapitalHumano\PorCientoNominas;
use App\Entity\Contabilidad\CapitalHumano\RangoEscalaDGII;
use App\Form\Contabilidad\CapitalHumano\EmpleadoType;
use App\Form\Contabilidad\CapitalHumano\NominaPagoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class NominaPagoController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/nomina-pago")
 */
class NominaPagoController extends AbstractController
{
    /**
     * @Route("/primera-quincena", name="contabilidad_capital_humano_nomina_pago_primera_quincena")
     */
    public function index_primera_quincena(EntityManagerInterface $em, Request $request)
    {
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad' => $obj_unidad
        ]);
        $year = Date('Y');
        $rows = [];
        /** @var Empleado $item */
        $index = 0;
        foreach ($empleados as $item) {
            if (!$item->getBaja()) {
                $index++;
                $rows[] = array(
                    'nro' => $index,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'comision_mensual' => number_format($item->getSalarioXHora(), 2),
                    'vacaiones' => number_format($item->getSalarioXHora(), 2),

                );
            } elseif ($item->getFechaBaja()->format('Y') < $year) {
                $index++;
                $rows[] = array(
                    'nro' => $index,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'comision_mensual' => number_format($item->getSalarioXHora(), 2),
                    'vacaiones' => number_format($item->getSalarioXHora(), 2),
                );
            }
        }
        return $this->render('contabilidad/capital_humano/nomina_pago/index.html.twig', [
            'controller_name' => 'NominaPagoController',
            'empleados' => $rows,
            'title' => 'Pago de Primera Quincena',
            'quincena' => 1
        ]);
    }

    /**
     * @Route("/segunda-quincena", name="contabilidad_capital_humano_nomina_pago_segunda_quincena")
     */
    public function index_segunda_quincena(EntityManagerInterface $em, Request $request)
    {
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad' => $obj_unidad
        ]);
        $year = Date('Y');
        $rows = [];
        /** @var Empleado $item */
        $index = 0;
        foreach ($empleados as $item) {
            if (!$item->getBaja()) {
                $index++;
                $rows[] = array(
                    'nro' => $index,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'comision_mensual' => number_format($item->getSalarioXHora(), 2),
                    'vacaiones' => number_format($item->getSalarioXHora(), 2),

                );
            } elseif ($item->getFechaBaja()->format('Y') < $year) {
                $index++;
                $rows[] = array(
                    'nro' => $index,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'comision_mensual' => number_format($item->getSalarioXHora(), 2),
                    'vacaiones' => number_format($item->getSalarioXHora(), 2),
                );
            }
        }
        return $this->render('contabilidad/capital_humano/nomina_pago/index.html.twig', [
            'controller_name' => 'NominaPagoController',
            'empleados' => $rows,
            'title' => 'Pago de Segunda Quincena',
            'quincena' => 2
        ]);
    }

    /**
     * @Route("/pagar/{data}", name="contabilidad_capital_humano_nomina_pago_pagar")
     */
    public function pagar(EntityManagerInterface $em, Request $request, $data)
    {
        $arr = explode('-', $data);
        $id = $arr[0];
        $quincena = $arr[1];
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->find($id);
        $form = $this->createForm(NominaPagoType::class);
        $callback = 'contabilidad/capital_humano/nomina_pago/nomina.html.twig';

        $procientos_nomina = $em->getRepository(PorCientoNominas::class)->findBy(['activo' => true]);
        /** @var PorCientoNominas $item */
        $ars = 0;
        $afp = 0;
        $AFP_empleador = 0;
        $SFS = 0;
        $SRL = 0;
        $Infotep = 0;
        $cooperativa = 0;

        foreach ($procientos_nomina as $item) {
            if ($item->getDenominacion() == 1) {
                //DEDUCCIONES
                if ($item->getCriterio() == 'ARS')
                    $ars = $item->getPorCiento();
                if ($item->getCriterio() == 'AFP')
                    $afp = $item->getPorCiento();
                if ($item->getCriterio() == 'COOPERATIVA')
                    $cooperativa = $item->getPorCiento();
            } else {
                //PAGOS EMPLEADOR
                if ($item->getCriterio() == 'AFP')
                    $AFP_empleador = $item->getPorCiento();
                if ($item->getCriterio() == 'SFS')
                    $SFS = $item->getPorCiento();
                if ($item->getCriterio() == 'SRL')
                    $SRL = $item->getPorCiento();
                if ($item->getCriterio() == 'Infotep')
                    $Infotep = $item->getPorCiento();
            }
        }

        return $this->render($callback, [
            'controller_name' => 'EmpleadoController',
            'form' => $form->createView(),
            'nombre' => $empleado->getNombre(),
            'sueld_bruto_boolean' => $empleado->getSalarioXHora() != '' || $empleado->getSalarioXHora() > 0 ? false : true,
            'sueldo_bruto' => number_format($empleado->getSueldoBrutoMensual(), 2),
            'sueldo_bruto_value' => $empleado->getSueldoBrutoMensual(),
            'salario_x_hora' => number_format($empleado->getSalarioXHora(), 2),
            'salario_x_hora_value' => $empleado->getSalarioXHora(),
            'id_empleado' => $empleado->getId(),
            'quincena' => $quincena,
            'ars' => $ars,
            'afp' => $afp,
            'AFP_empleador' => $AFP_empleador,
            'SFS' => $SFS,
            'SRL' => $SRL,
            'Infotep' => $Infotep,
            'cooperativa' => $cooperativa,
        ]);
    }

    /**
     * @Route("/get-rango-escala-dgii/{baseCalculo}", name="contabilidad_capital_humano_base_calculo")
     */
    public function getDataAuxiliar(EntityManagerInterface $em, Request $request, $baseCalculo)
    {
        $anno = AuxFunctions::getCurrentYear($em, AuxFunctions::getUnidad($em, $this->getUser()));
        $data_rango_escala_dgii = $em->getRepository(RangoEscalaDGII::class)->findBy([
            'activo' => true,
            'anno' => $anno
        ]);
        $value = floatval($baseCalculo);
        $monto_segun_rango = 0;
        $excedente = 0;
        $minimo = 0;
        $porciento = 0;
        $fijo = 0;
        /** @var RangoEscalaDGII $item */
        foreach ($data_rango_escala_dgii as $item) {
            if ($value >= $item->getMinimo() && $value <= $item->getMaximo()) {
                $minimo = $item->getMinimo();
                $excedente = $value - $minimo;
                $porciento = $excedente * $item->getPorCiento() / 100;
                $fijo = $item->getValorFijo();
                $monto_segun_rango = $fijo + $porciento;
            }
        }
        return new JsonResponse([
            'success' => true,
            'minimo' => $minimo,
            'porciento' => $porciento,
            'fijo' => $fijo,
            'excedente' => $excedente,
            'monto_segun_rango' => $monto_segun_rango,
            'impuesto_sobre_rente_mensual' => $monto_segun_rango / 12
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_capital_humano_add_nomina")
     */
    public function addNomina(EntityManagerInterface $em, Request $request)
    {
        $nomina_pago = $request->request->get('nomina_pago');
        $sueldo_bruto = floatval($nomina_pago['sueldo_bruto']);
        $comision = floatval($nomina_pago['comision']);
//        $quincena = floatval($nomina_pago['quincena']);
        $vacaciones = floatval($nomina_pago['vacaciones']);
        $horas_extra = floatval($nomina_pago['horas_extra']);
        $otros = floatval($nomina_pago['otros']);
        $total_ingresos = floatval($nomina_pago['total_ingresos']);
        $ingresos_cotizables_tss = floatval($nomina_pago['ingresos_cotizables_tss']);
        $impuesto_sobre_renta = $nomina_pago['impuesto_sobre_renta'];
//          "seguridad_social_mensual" => "4137.00"
//          "salario_bruto_anual" => "840000.00"
//          "seguridad_social_anual" => "49644.00"
//          "salario_despues_seguridad_social" => "790356.00"
//          "monto_segun_rango_escala" => "624329.01"
//          "excedente_segun_rango_escala" => "166026.99"
//          "por_ciento_impuesto_excedente" => "33205.40"
//          "monto_adicional_rango_escala" => "31216.00"
//          "impuesto_renta_pagar_anual" => "64421.40"
//          "impuesto_renta_pagar_mensual" => "5368.45"

        $isr = floatval($nomina_pago['isr']);
        $ars = floatval($nomina_pago['ars']);
        $afp = floatval($nomina_pago['afp']);
        $cooperativa = floatval($nomina_pago['cooperativa']);
        $plan_medico_complementario = floatval($nomina_pago['plan_medico_complementario']);
        $restaurant = floatval($nomina_pago['restaurant']);
        $total_deducido = floatval($nomina_pago['total_deducido']);
        $sueldo_neto_pagar = floatval($nomina_pago['sueldo_neto_pagar']);
        $afp_empleador = floatval($nomina_pago['afp_empleador']);
        $sfs_empleador = floatval($nomina_pago['sfs_empleador']);
        $srl_empleador = floatval($nomina_pago['srl_empleador']);
        $infotep_empleador = floatval($nomina_pago['infotep_empleador']);
        $id_empleado = floatval($nomina_pago['id_empleado']);

        /** @var Empleado $obj_empleado */
        $obj_empleado = $em->getRepository(Empleado::class)->find($id_empleado);
        $anno = AuxFunctions::getCurrentYear($em, AuxFunctions::getUnidad($em, $this->getUser()));


        $nomina_pago = new NominaPago();
        $nomina_pago
            ->setFecha(AuxFunctions::getCurrentDate($em,$obj_empleado->getIdUnidad()))
            ->setAnno($anno)
            ->setMes(AuxFunctions::getCurrentDate($em,$obj_empleado->getIdUnidad())->format('m'))
            ->setIdUnidad($obj_empleado->getIdUnidad())
            ->setAfp($afp)
            ->setAfpEmpleador($afp_empleador)
            ->setAprobada(false)
            ->setArs($ars)
            ->setComision($comision)
            ->setCooperativa($cooperativa)
            ->setElaborada(true)
            ->setHorasExtra($horas_extra)
            ->setIdEmpleado($obj_empleado)
            ->setInfotepEmpleador($infotep_empleador)
            ->setIngresosCotizablesTss($ingresos_cotizables_tss)
            ->setIsr($isr)
            ->setOtros($otros)
            ->setPlanMedicoComplementario($plan_medico_complementario)
            ->setQuincena(1)
            ->setRestaurant($restaurant)
            ->setSfsEmpleador($sfs_empleador)
            ->setSrlEmpleador($srl_empleador)
            ->setSueldoNetoPagar($sueldo_neto_pagar)
            ->setTotalDeducido($total_deducido)
            ->setTotalIngresos($total_ingresos)
            ->setVacaciones($vacaciones)
            ;
        $em->persist($nomina_pago);
        $em->flush();

        dd($request, $impuesto_sobre_renta, $sueldo_bruto);

        return new JsonResponse([
            'success' => true,
            'minimo' => $minimo,
            'porciento' => $porciento,
            'fijo' => $fijo,
            'excedente' => $excedente,
            'monto_segun_rango' => $monto_segun_rango,
            'impuesto_sobre_rente_mensual' => $monto_segun_rango / 12
        ]);
    }
}
