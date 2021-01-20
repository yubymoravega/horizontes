<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\CapitalHumano\ImpuestoSobreRenta;
use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use App\Entity\Contabilidad\CapitalHumano\PorCientoNominas;
use App\Entity\Contabilidad\CapitalHumano\RangoEscalaDGII;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Form\Contabilidad\CapitalHumano\EmpleadoType;
use App\Form\Contabilidad\CapitalHumano\NominaPagoType;
use ContainerK07jWwZ\getUnidadChoicesTypeService;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use function Sodium\add;

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
        $obj_user = $this->getUser();
        $obj_unidad = AuxFunctions::getUnidad($em, $obj_user);
        $current_date = AuxFunctions::getCurrentDate($em, $obj_unidad);
        $mes = $current_date->format('m');
        $anno = $current_date->format('Y');

        $pago_nomina = $em->getRepository(NominaPago::class)->findBy([
            'id_unidad' => $obj_unidad,
            'elaborada' => true,
            'mes' => $mes,
            'anno' => $anno
        ]);
        $rows = [];
        $return_pago = false;
        if (!empty($pago_nomina)) {
            /** @var NominaPago $pago */
            $pago = $pago_nomina[count($pago_nomina) - 1];
            if ($pago->getQuincena() == 1)
                if ($pago->getAprobada() == true) {
                    $return_pago = true;
                    $rows = [];
                } else {
                    $return_pago = false;
                    $rows = $this->getData($em, 1);
                }
            else {
                $return_pago = false;
                $rows = [];
            }
        } else {
            $return_pago = false;
            $rows = $this->getData($em, 2);
        }

        return $this->render('contabilidad/capital_humano/nomina_pago/index.html.twig', [
            'controller_name' => 'NominaPagoController',
            'empleados' => $rows,
            'title' => 'Pago de Primera Quincena',
            'quincena' => 1,
            'aprobado' => false,
            'return_pago' => $return_pago,
            'aceptar_pago' => empty($rows) ? false : true
        ]);
    }

    /**
     * @Route("/segunda-quincena", name="contabilidad_capital_humano_nomina_pago_segunda_quincena")
     */
    public function index_segunda_quincena(EntityManagerInterface $em, Request $request)
    {
        $obj_user = $this->getUser();
        $obj_unidad = AuxFunctions::getUnidad($em, $obj_user);
        $current_date = AuxFunctions::getCurrentDate($em, $obj_unidad);
        $mes = $current_date->format('m');
        $anno = $current_date->format('Y');

        $pago_nomina = $em->getRepository(NominaPago::class)->findBy([
            'id_unidad' => $obj_unidad,
            'elaborada' => true,
            'mes' => $mes,
            'anno' => $anno
        ]);

        $return_pago = false;
        if (!empty($pago_nomina)) {
            /** @var NominaPago $pago */
            $pago = $pago_nomina[count($pago_nomina) - 1];
            if ($pago->getQuincena() == 2)
                if ($pago->getAprobada() == true) {
                    $return_pago = true;
                    $rows = [];
                } else {
                    $return_pago = false;
                    $rows = $this->getData($em, 2);
                }
            else
                if ($pago->getAprobada() == true) {
                    $return_pago = false;
                    $rows = $this->getData($em, 2);
                } else {
                    $return_pago = false;
                    $rows = [];
                }
        } else {
            $return_pago = false;
            $rows = $this->getData($em, 2);
        }
        return $this->render('contabilidad/capital_humano/nomina_pago/index.html.twig', [
            'controller_name' => 'NominaPagoController',
            'empleados' => $rows,
            'title' => 'Pago de Segunda Quincena',
            'quincena' => 2,
            'aprobado' => false,
            'return_pago' => $return_pago,
            'aceptar_pago' => empty($rows) ? false : true
        ]);
    }

    //preguntar por las nominas, fijarse en el caso de la segunda quincena por que no aparecen
    public function getData(EntityManagerInterface $em, $quincena)
    {
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad' => $obj_unidad
        ]);
        $current_date = AuxFunctions::getCurrentDate($em, AuxFunctions::getUnidad($em, $this->getUser()));
        $year = $current_date->format('Y');
        $mes = $current_date->format('m');

        $rows = [];
        /** @var Empleado $item */
        $index = 0;
        $nomina_pago_er = $em->getRepository(NominaPago::class);
        foreach ($empleados as $item) {
            /** @var NominaPago $nomina_pago */
            $nomina_pago = $nomina_pago_er->findOneBy([
                'mes' => $mes,
                'anno' => $year,
                'quincena' => $quincena,
                'id_empleado' => $item,
//                'aprobada'=>false
            ]);
//            if($nomina_pago) {
            if (!$item->getBaja() || $item->getFechaBaja()->format('Y') < $year) {
                if (!$nomina_pago || $nomina_pago->getAprobada() == false) {
                    $index++;
                    $rows[] = array(
                        'nro' => $index,
                        'id' => $item->getId(),
                        'id_nomina' => $nomina_pago ? $nomina_pago->getId() : '',
                        'elaborada' => $nomina_pago ? $nomina_pago->getElaborada() : false,
                        'aprobada' => $nomina_pago ? $nomina_pago->getAprobada() : false,
                        'nombre' => $item->getNombre(),
                        'pagado' => $nomina_pago ? true : false,
                        'total_ingreso' => $nomina_pago ? number_format($nomina_pago->getTotalIngresos(), 2) : '',
                        'total_ingreso_cotizable' => $nomina_pago ? number_format($nomina_pago->getIngresosCotizablesTss(), 2) : '',
                        'total_deducido' => $nomina_pago ? number_format($nomina_pago->getTotalDeducido(), 2) : '',
                        'impuesto_sobre_renta' => $nomina_pago ? number_format($nomina_pago->getIsr(), 2) : '',
                        'sueldo_neto_pagar' => $nomina_pago ? number_format($nomina_pago->getSueldoNetoPagar(), 2) : '',
                        'pago_empleador' => $nomina_pago ? number_format(($nomina_pago->getAfpEmpleador() + $nomina_pago->getInfotepEmpleador() + $nomina_pago->getSfsEmpleador() + $nomina_pago->getSrlEmpleador()), 2) : '',

                    );
                }
//                }
            }
        }
        return $rows;
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
            'elaborado' => false
        ]);
    }

    /**
     * @Route("/revisar/{id_nomina}", name="contabilidad_capital_humano_nomina_pago_editar_pago")
     */
    public function revisar(EntityManagerInterface $em, Request $request, $id_nomina)
    {
        /** @var NominaPago $nomina_obj */
        $nomina_obj = $em->getRepository(NominaPago::class)->find(intval($id_nomina));
        $impuesto_sobre_renta = $em->getRepository(ImpuestoSobreRenta::class)->findOneBy(['id_nomina_pago' => $nomina_obj]);
        /** @var Empleado $empleado */
        $empleado = $nomina_obj->getIdEmpleado();
        $form = $this->createForm(NominaPagoType::class, [
            'comision' => $nomina_obj->getComision(),
            'vacaciones' => $nomina_obj->getVacaciones(),
            'horas_extra' => $nomina_obj->getHorasExtra(),
            'otros' => $nomina_obj->getOtros(),
            'total_ingresos' => $nomina_obj->getTotalIngresos(),
            'ingresos_cotizables_tss' => $nomina_obj->getIngresosCotizablesTss(),
            'isr' => $nomina_obj->getIsr(),
            'ars' => $nomina_obj->getArs(),
            'afp' => $nomina_obj->getAfp(),
            'cooperativa' => $nomina_obj->getCooperativa(),
            'plan_medico_complementario' => $nomina_obj->getPlanMedicoComplementario(),
            'restaurant' => $nomina_obj->getRestaurant(),
            'total_deducido' => $nomina_obj->getTotalDeducido(),
            'sueldo_neto_pagar' => $nomina_obj->getSueldoNetoPagar(),
            'afp_empleador' => $nomina_obj->getAfpEmpleador(),
            'sfs_empleador' => $nomina_obj->getSfsEmpleador(),
            'srl_empleador' => $nomina_obj->getSrlEmpleador(),
            'infotep_empleador' => $nomina_obj->getInfotepEmpleador(),
            'impuesto_sobre_renta' => $impuesto_sobre_renta
        ]);

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
        $callback = 'contabilidad/capital_humano/nomina_pago/nomina.html.twig';
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
            'quincena' => $nomina_obj->getQuincena(),
            'ars' => $ars,
            'afp' => $afp,
            'AFP_empleador' => $AFP_empleador,
            'SFS' => $SFS,
            'SRL' => $SRL,
            'Infotep' => $Infotep,
            'cooperativa' => $cooperativa,
            'elaborado' => true
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
        $id = 0;
        /** @var RangoEscalaDGII $item */
        foreach ($data_rango_escala_dgii as $item) {
            if ($value >= $item->getMinimo() && $value <= $item->getMaximo()) {
                $id = $item->getId();
                $minimo = $item->getMinimo();
                $excedente = $value - $minimo;
                $porciento = $excedente * $item->getPorCiento() / 100;
                $fijo = $item->getValorFijo();
                $monto_segun_rango = $fijo + $porciento;
            }
        }
        return new JsonResponse([
            'success' => true,
            'id_rango_escala' => $id,
            'minimo' => $minimo,
            'porciento' => $porciento,
            'fijo' => $fijo,
            'excedente' => $excedente,
            'monto_segun_rango' => $monto_segun_rango,
            'impuesto_sobre_rente_mensual' => $monto_segun_rango / 12
        ]);
    }

    /**
     * @Route("/aceptar-pago", name="aceptar_pago")
     */
    public function aceptarPago(EntityManagerInterface $em, Request $request)
    {
        $quincena = intval($request->request->get('quincena'));
        $observacion = $request->request->get('observacion');
        $fecha = AuxFunctions::getCurrentDate($em, AuxFunctions::getUnidad($em, $this->getUser()));
        $mes = $fecha->format('m');
        $anno = $fecha->format('Y');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());

        $data_nominas = $em->getRepository(NominaPago::class)->findBy([
            'elaborada' => true,
            'aprobada' => false,
            'mes' => $mes,
            'anno' => $anno,
            'id_unidad' => $unidad,
            'quincena' => $quincena
        ]);
        if (empty($data_nominas)) {
            $this->addFlash('success', 'No ha nominas pagadas que apectar');
            return $this->redirectToRoute($quincena == 1 ? 'contabilidad_capital_humano_nomina_pago_primera_quincena' : 'contabilidad_capital_humano_nomina_pago_segunda_quincena');
        }

        //debito  a la 823/0010 elemento de gasto 5001
        $total_ingreso = 0;
        $total_ingreso_cotisable_tss = 0;
        // credito 440/0005
        $total_impuesto_sobre_renta = 0;
        // credito 440/0006
        $total_ars = 0;
        // credito 440/0007
        $total_afp = 0;
        // credito 440/0008
        $total_cooperativa = 0;
        // credito 440/0009
        $total_plan_medico_complementario = 0;
        // credito 440/0010
        $total_restaurant = 0;
        $total_deducido = 0;
        //credito 455/0010(por crear la subcuenta)
        $total_sueldo_neto = 0;
        //debito  a la 855/0010 credito a la 440/0011
        $total_afp_empleador = 0;
        //debito  a la 855/0020 credito a la 440/0012
        $total_sfs_empleador = 0;
        //debito 855/0030 credito 440/0013
        $total_srl_empleador = 0;
        //debito 855/0040 credito 440/0014
        $total_infotep_empleador = 0;

        /** @var NominaPago $item */
        foreach ($data_nominas as $item) {
            $item
                ->setAprobada(true)
                ->setIdUsuarioAprueba($this->getUser());
            $em->persist($item);
            $total_ingreso += $item->getTotalIngresos();
            $total_ingreso_cotisable_tss += $item->getIngresosCotizablesTss();
            $total_impuesto_sobre_renta += $item->getIsr();
            $total_ars += $item->getArs();
            $total_afp += $item->getAfp();
            $total_cooperativa += $item->getCooperativa();
            $total_plan_medico_complementario += $item->getPlanMedicoComplementario();
            $total_restaurant += $item->getRestaurant();
            $total_deducido += $item->getTotalDeducido();
            $total_sueldo_neto += $item->getSueldoNetoPagar();
            $total_afp_empleador += $item->getAfpEmpleador();
            $total_sfs_empleador += $item->getSfsEmpleador();
            $total_srl_empleador += $item->getSrlEmpleador();
            $total_infotep_empleador += $item->getInfotepEmpleador();
        }

        /** Creando el Comprobante */
        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);
        $all_comprobantes_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy([
            'id_tipo_comprobante' => $tipo_comprobante,
            'id_unidad' => $unidad,
            'anno' => $anno
        ]);
        $consecutivo = count($all_comprobantes_operaciones) + 1;

        /** Obteniendo debitos y creditos */
        $debito = $total_ingreso + $total_afp_empleador + $total_sfs_empleador + $total_srl_empleador + $total_infotep_empleador;

        $new_registro_comprobante = new RegistroComprobantes();
        $new_registro_comprobante
            ->setDescripcion($observacion)
            ->setIdUsuario($this->getUser())
            ->setFecha($fecha)
            ->setAnno($anno)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_NOMINAS)
            ->setCredito(floatval($debito))
            ->setDebito(floatval($debito))
            ->setIdAlmacen(null)
            ->setIdTipoComprobante($tipo_comprobante)
            ->setIdUnidad($unidad)
            ->setNroConsecutivo($consecutivo);
        $em->persist($new_registro_comprobante);

        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        /**** Obteniendo las cuentas y subcuentas **/
        //DEBITOS
        $cuenta_total_ingreso = $cuenta_er->findOneBy(['activo'=>true,'nro_cuenta'=>'823']);
        $cuenta_debito_empleador = $cuenta_er->findOneBy(['activo'=>true,'nro_cuenta'=>'855']);
        $subcuenta_total_ingreso = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_total_ingreso,'nro_subcuenta'=>'0010']);
        $subcuenta_afp_empleador = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_debito_empleador,'nro_subcuenta'=>'0010']);
        $subcuenta_sfs_empleador = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_debito_empleador,'nro_subcuenta'=>'0020']);
        $subcuenta_srl_empleador = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_debito_empleador,'nro_subcuenta'=>'0030']);
        $subcuenta_infotep_empleador = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_debito_empleador,'nro_subcuenta'=>'0040']);

        //CREDITOS
        $cuenta_creditos = $cuenta_er->findOneBy(['activo'=>true,'nro_cuenta'=>'440']);
        $cuenta_efectivo_creditos = $cuenta_er->findOneBy(['activo'=>true,'nro_cuenta'=>'455']);
        $subcuenta_efectivo_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_efectivo_creditos,'nro_subcuenta'=>'0010']);
        $subcuenta_isr_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0005']);
        $subcuenta_ars_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0006']);
        $subcuenta_afp_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0007']);
        $subcuenta_cooperativa_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0008']);
        $subcuenta_plan_medico_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0009']);
        $subcuenta_restaurant_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0010']);
        $subcuenta_sfs_empleador_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0011']);
        $subcuenta_afp_empleador_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0012']);
        $subcuenta_srl_empleador_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0013']);
        $subcuenta_infotep_empleador_credito = $subcuenta_er->findOneBy(['activo'=>true,'id_cuenta'=>$cuenta_creditos,'nro_subcuenta'=>'0014']);

        /** Asentando las operaciones */
        /****** DEBITOS *****/
        //GASTO DE SUELDO

        $em->flush();
        $this->addFlash('success', 'El pago ha sido Aceptado satisfactoriamente');

        if ($quincena == 1)
            return $this->index_primera_quincena($em, $request);
        return $this->index_segunda_quincena($em, $request);
    }

    /**
     * @Route("/revertir-pago", name="revertir_pago")
     */
    public function revertirPago(EntityManagerInterface $em, Request $request)
    {
        $quincena = intval($request->request->get('quincena'));
        $observacion = $request->request->get('observacion');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fecha = AuxFunctions::getCurrentDate($em, $unidad);
        $mes = $fecha->format('m');
        $anno = $fecha->format('Y');

        $data_nominas = $em->getRepository(NominaPago::class)->findBy([
            'elaborada' => true,
            'aprobada' => true,
            'mes' => $mes,
            'anno' => $anno,
            'id_unidad' => $unidad,
            'quincena' => $quincena
        ]);
//        dd($data_nominas);
        if (empty($data_nominas)) {
            $this->addFlash('success', 'No ha nominas pagadas que apectar');
            return $this->redirectToRoute($quincena == 1 ? 'contabilidad_capital_humano_nomina_pago_primera_quincena' : 'contabilidad_capital_humano_nomina_pago_segunda_quincena');
        }

        /** @var NominaPago $item */
        foreach ($data_nominas as $item) {
            $item
                ->setAprobada(false)
                ->setIdUsuarioAprueba(null);
            $em->persist($item);
        }
        $em->flush();
        $this->addFlash('success', 'El pago ha sido revertido satisfactoriamente');

        if ($quincena == 1)
            return $this->index_primera_quincena($em, $request);
        return $this->index_segunda_quincena($em, $request);
    }

    /**
     * @Route("/add", name="contabilidad_capital_humano_add_nomina")
     */
    public function addNomina(EntityManagerInterface $em, Request $request)
    {
        $nomina_pago = $request->request->get('nomina_pago');
        $salario_x_hora = isset($nomina_pago['salario_x_hora']) ? floatval($nomina_pago['salario_x_hora']) : 0;
        $horas_trabajadas = isset($nomina_pago['sueldo_bruto']) ? 0 : floatval($nomina_pago['horas_trabajadas']);
        $salario_bruto = isset($nomina_pago['sueldo_bruto']) ? floatval($nomina_pago['sueldo_bruto']) : ($salario_x_hora * $horas_trabajadas);


        $comision = floatval($nomina_pago['comision']);
        $quincena = floatval($nomina_pago['quincena']);
        $vacaciones = floatval($nomina_pago['vacaciones']);
        $horas_extra = floatval($nomina_pago['horas_extra']);
        $otros = floatval($nomina_pago['otros']);
        $total_ingresos = floatval($nomina_pago['total_ingresos']);
        $ingresos_cotizables_tss = floatval($nomina_pago['ingresos_cotizables_tss']);
        $impuesto_sobre_renta = $nomina_pago['impuesto_sobre_renta'];
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

        $fecha = AuxFunctions::getCurrentDate($em, $obj_empleado->getIdUnidad());

        $nomina_pago = $em->getRepository(NominaPago::class)->findOneBy([
            'id_empleado' => $obj_empleado,
            'mes' => $fecha->format('m'),
            'anno' => $fecha->format('Y'),
            'quincena' => $quincena
        ]);

        if (!$nomina_pago)
            $nomina_pago = new NominaPago();
        $nomina_pago
            ->setFecha($fecha)
            ->setAnno($anno)
            ->setMes(AuxFunctions::getCurrentDate($em, $obj_empleado->getIdUnidad())->format('m'))
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
            ->setQuincena($quincena)
            ->setRestaurant($restaurant)
            ->setSfsEmpleador($sfs_empleador)
            ->setSrlEmpleador($srl_empleador)
            ->setSueldoNetoPagar($sueldo_neto_pagar)
            ->setTotalDeducido($total_deducido)
            ->setTotalIngresos($total_ingresos)
            ->setVacaciones($vacaciones)
            ->setSalarioBruto($salario_bruto)
            ->setCantHorasTrabajadas($horas_trabajadas);
        $em->persist($nomina_pago);

        $obj_impuesto_sobre_renta = $em->getRepository(ImpuestoSobreRenta::class)->findOneBy(['id_nomina_pago' => $nomina_pago]);
        if (!$obj_impuesto_sobre_renta)
            $obj_impuesto_sobre_renta = new ImpuestoSobreRenta();
        $obj_impuesto_sobre_renta
            ->setFecha(AuxFunctions::getCurrentDate($em, AuxFunctions::getUnidad($em, $this->getUser())))
            ->setExcedenteSegunRangoEscala(isset($impuesto_sobre_renta['excedente_segun_rango_escala']) ? floatval($impuesto_sobre_renta['excedente_segun_rango_escala']) : 0)
            ->setIdNominaPago($nomina_pago)
            ->setIdEmpleado($nomina_pago->getIdEmpleado())
            ->setImpuestoRentaPagarAnual(isset($impuesto_sobre_renta['impuesto_renta_pagar_anual']) ? floatval($impuesto_sobre_renta['impuesto_renta_pagar_anual']) : 0)
            ->setMontoAdicionalRangoEscala(isset($impuesto_sobre_renta['monto_adicional_rango_escala']) ? floatval($impuesto_sobre_renta['monto_adicional_rango_escala']) : 0)
            ->setImpuestoRentaPagarMensual(isset($impuesto_sobre_renta['impuesto_renta_pagar_mensual']) ? floatval($impuesto_sobre_renta['impuesto_renta_pagar_mensual']) : 0)
            ->setMontoSegunRango(isset($impuesto_sobre_renta['monto_segun_rango_escala']) ? floatval($impuesto_sobre_renta['monto_segun_rango_escala']) : 0)
            ->setMontoSegunRangoEscala(isset($impuesto_sobre_renta['monto_segun_rango_escala']) ? floatval($impuesto_sobre_renta['monto_segun_rango_escala']) : 0)
            ->setPorCientoImpuestoExcedente(isset($impuesto_sobre_renta['por_ciento_impuesto_excedente']) ? floatval($impuesto_sobre_renta['por_ciento_impuesto_excedente']) : 0)
            ->setSalarioBrutoAnual(isset($impuesto_sobre_renta['salario_bruto_anual']) ? floatval($impuesto_sobre_renta['salario_bruto_anual']) : 0)
            ->setSalarioDespuesSeguridadSocial(isset($impuesto_sobre_renta['salario_despues_seguridad_social']) ? floatval($impuesto_sobre_renta['salario_despues_seguridad_social']) : 0)
            ->setSeguridadSocialAnual(isset($impuesto_sobre_renta['seguridad_social_anual']) ? floatval($impuesto_sobre_renta['seguridad_social_anual']) : 0)
            ->setSeguridadSocialMensual(isset($impuesto_sobre_renta['seguridad_social_mensual']) ? floatval($impuesto_sobre_renta['seguridad_social_mensual']) : 0);

        if (isset($impuesto_sobre_renta['id_escala_escala']) && $impuesto_sobre_renta['id_escala_escala'] != '') {
            $obj_impuesto_sobre_renta
                ->setIdRangoEscala($em->getRepository(RangoEscalaDGII::class)->find(intval($impuesto_sobre_renta['id_escala_escala'])));
        }

        $em->persist($obj_impuesto_sobre_renta);


        $em->flush();

        if ($quincena == '1' || $quincena == 1)
            $url = 'contabilidad_capital_humano_nomina_pago_primera_quincena';
        else
            $url = 'contabilidad_capital_humano_nomina_pago_segunda_quincena';
        return $this->redirectToRoute($url);
    }
}
