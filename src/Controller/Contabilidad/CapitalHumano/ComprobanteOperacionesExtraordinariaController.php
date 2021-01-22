<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\NominaTerceroComprobante;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesExtraordinariaController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/comprobante-operaciones-extraordinaria")
 */
class ComprobanteOperacionesExtraordinariaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_comprobante_operaciones_extraordinaria")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $nominas_extraordinarias = $em->getRepository(NominaTerceroComprobante::class)->findBy([
            'id_unidad' => $unidad,
            'id_comprobante' => null
        ]);
        $rows = [];
        $data = [];
        $total_general_debito = 0;
        $total_general_credito = 0;
        /** @var NominaTerceroComprobante $item */
        foreach ($nominas_extraordinarias as $item) {
            $data=[];
            $obj_nomina = $item->getIdNomina();
            $obj_empleado = $obj_nomina->getIdEmpleado();
            $empleado = $obj_empleado->getNombre();
            $identificacion = $obj_empleado->getIdentificacion();
            $total_debito = $obj_nomina->getTotalIngresos() +
                $obj_nomina->getSfsEmpleador() +
                $obj_nomina->getAfpEmpleador() +
                $obj_nomina->getSrlEmpleador() +
                $obj_nomina->getInfotepEmpleador();
            $total_credito = $obj_nomina->getSueldoNetoPagar() +
                $obj_nomina->getIsr() +
                $obj_nomina->getArs() +
                $obj_nomina->getAfp() +
                $obj_nomina->getCooperativa() +
                $obj_nomina->getPlanMedicoComplementario() +
                $obj_nomina->getRestaurant() +
                $obj_nomina->getAfpEmpleador() +
                $obj_nomina->getSfsEmpleador() +
                $obj_nomina->getSrlEmpleador() +
                $obj_nomina->getInfotepEmpleador();

//            DEBITOS
            if($obj_nomina->getTotalIngresos()>0)
            $data[count($data)] = [
                'debito'=>number_format($obj_nomina->getTotalIngresos(),2),
                'credito'=>'',
                'cuenta'=>'823',
                'criterio_1'=>'5001',
                'subcuenta'=>'0010',
                'fecha'=>$obj_nomina->getFecha()->format('d-m-Y'),
            ];
            if($obj_nomina->getAfpEmpleador()>0)
            $data[count($data)] = [
                'debito'=>number_format($obj_nomina->getAfpEmpleador(),2),
                'credito'=>'',
                'cuenta'=>'855',
                'criterio_1'=>'',
                'subcuenta'=>'0010',
                'fecha'=>'',
            ];
            if($obj_nomina->getSfsEmpleador()>0)
            $data[count($data)] = [
                'debito'=>number_format($obj_nomina->getSfsEmpleador(),2),
                'credito'=>'',
                'cuenta'=>'855',
                'criterio_1'=>'',
                'subcuenta'=>'0020',
                'fecha'=>'',
            ];
            if($obj_nomina->getSrlEmpleador()>0)
            $data[count($data)] = [
                'debito'=>number_format($obj_nomina->getSrlEmpleador(),2),
                'credito'=>'',
                'cuenta'=>'855',
                'criterio_1'=>'',
                'subcuenta'=>'0030',
                'fecha'=>'',
            ];
            if($obj_nomina->getInfotepEmpleador()>0)
            $data[count($data)] = [
                'debito'=>number_format($obj_nomina->getInfotepEmpleador(),2),
                'credito'=>'',
                'cuenta'=>'855',
                'criterio_1'=>'',
                'subcuenta'=>'0040',
                'fecha'=>'',
            ];

            //CREDITOS
            if($obj_nomina->getSueldoNetoPagar()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getSueldoNetoPagar(),2),
                'debito'=>'',
                'cuenta'=>'455',
                'criterio_1'=>'',
                'subcuenta'=>'0010',
                'fecha'=>'',
            ];
            if($obj_nomina->getIsr()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getIsr(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0005',
                'fecha'=>'',
            ];
            if($obj_nomina->getArs()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getArs(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0006',
                'fecha'=>'',
            ];
            if($obj_nomina->getAfp()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getAfp(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0007',
                'fecha'=>'',
            ];
            if($obj_nomina->getCooperativa()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getCooperativa(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0008',
                'fecha'=>'',
            ];
            if($obj_nomina->getPlanMedicoComplementario()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getPlanMedicoComplementario(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0009',
                'fecha'=>'',
            ];
            if($obj_nomina->getRestaurant()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getRestaurant(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0010',
                'fecha'=>'',
            ];
            if($obj_nomina->getSfsEmpleador()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getSfsEmpleador(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0011',
                'fecha'=>'',
            ];
            if($obj_nomina->getAfpEmpleador()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getAfpEmpleador(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0012',
                'fecha'=>'',
            ];
            if($obj_nomina->getSrlEmpleador()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getSrlEmpleador(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0013',
                'fecha'=>'',
            ];
            if($obj_nomina->getInfotepEmpleador()>0)
            $data[count($data)] = [
                'credito'=>number_format($obj_nomina->getInfotepEmpleador(),2),
                'debito'=>'',
                'cuenta'=>'440',
                'criterio_1'=>'',
                'subcuenta'=>'0014',
                'fecha'=>'',
            ];
            $data[count($data)] = [
                'credito'=>number_format($total_credito,2),
                'debito'=>number_format($total_debito,2),
                'cuenta'=>'',
                'criterio_1'=>'',
                'subcuenta'=>'',
                'fecha'=>'',
            ];

//            dd($data);
            $rows[] = [
                'empleado' => $empleado,
                'identificacion' => $identificacion,
                'datos' => $data,
                'fecha' => $obj_nomina->getFecha()->format('d-m-Y'),
                'total_debito' => number_format($total_debito,2),
                'total_credito' => number_format($total_credito,2)
            ];
            $total_general_debito += $total_debito;
            $total_general_credito += $total_credito;

        }
        return $this->render('contabilidad/capital_humano/comprobante_operaciones_extraordinaria/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesExtraordinariaController',
            'datos' => $rows,
            'total_debito' => number_format($total_general_debito,2),
            'total_credito' => number_format($total_general_credito,2),
            'debito' => $total_general_debito,
            'credito' =>$total_general_credito,
            'unidad'=> $unidad->getCodigo() .' - '. $unidad->getNombre(),
            'fecha' => AuxFunctions::getCurrentDate($em,$unidad)->format('d-m-Y')
        ]);
    }

    /**
     * @Route("/aceptar-comprobante", name="contabilidad_capital_humano_comprobante_operaciones_extraordinaria_aceptar_comprobante")
     */
    public function aceptarComprobante(EntityManagerInterface $em, Request $request){
        $observacion = $request->request->get('observacion');
        $fecha_request = $request->request->get('fecha');
        $debito = $request->request->get('debito');
        $credito = $request->request->get('credito');


        if($debito != $credito)
            return $this->render('contabilidad/capital_humano/comprobante_operaciones_extraordinaria/error.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'title' => '!!Error',
                'message' => 'El total de Débitos tiene que ser igual al total de Créditos .'
            ]);

        $fecha = \DateTime::createFromFormat('d-m-Y',$fecha_request);
        $anno = $fecha->format('Y');
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);

        $arr_registro = $em->getRepository(RegistroComprobantes::class)->findBy([
            'anno'=>$fecha->format('Y'),
            'id_unidad'=>$unidad,
            'id_tipo_comprobante'=>$tipo_comprobante
        ]);
        $nro_consecutivo = count($arr_registro)+1;

        $new_registro_comprobante = new RegistroComprobantes();
        $new_registro_comprobante
            ->setAnno($fecha->format('Y'))
            ->setIdUnidad($unidad)
            ->setFecha($fecha)
            ->setIdTipoComprobante($tipo_comprobante)
            ->setDescripcion($observacion)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_NOMINAS_EXTRAORDINARIAS)
            ->setIdUsuario($this->getUser())
            ->setDebito($debito)
            ->setCredito($credito)
            ->setNroConsecutivo($nro_consecutivo);
        $em->persist($new_registro_comprobante);

        //ASENTAR LA OPERACION
        $nominas_extraordinarias = $em->getRepository(NominaTerceroComprobante::class)->findBy([
            'id_unidad' => $unidad,
            'id_comprobante' => null
        ]);
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
        /** @var NominaTerceroComprobante $nominas */
        foreach ($nominas_extraordinarias as $nominas) {
            $nominas
                ->setIdComprobante($new_registro_comprobante);
            $em->persist($nominas);

            $item = $nominas->getIdNomina();
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

        $cuenta_er = $em->getRepository(Cuenta::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        /**** Obteniendo las cuentas y subcuentas **/
        //DEBITOS
        $cuenta_total_ingreso = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '823']);
        $cuenta_debito_empleador = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '855']);
        $subcuenta_total_ingreso = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_total_ingreso, 'nro_subcuenta' => '0010']);
        $subcuenta_afp_empleador = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_debito_empleador, 'nro_subcuenta' => '0010']);
        $subcuenta_sfs_empleador = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_debito_empleador, 'nro_subcuenta' => '0020']);
        $subcuenta_srl_empleador = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_debito_empleador, 'nro_subcuenta' => '0030']);
        $subcuenta_infotep_empleador = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_debito_empleador, 'nro_subcuenta' => '0040']);

        //CREDITOS
        $cuenta_creditos = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '440']);
        $cuenta_efectivo_creditos = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '455']);
        $subcuenta_efectivo_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_efectivo_creditos, 'nro_subcuenta' => '0010']);
        $subcuenta_isr_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0005']);
        $subcuenta_ars_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0006']);
        $subcuenta_afp_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0007']);
        $subcuenta_cooperativa_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0008']);
        $subcuenta_plan_medico_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0009']);
        $subcuenta_restaurant_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0010']);
        $subcuenta_sfs_empleador_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0011']);
        $subcuenta_afp_empleador_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0012']);
        $subcuenta_srl_empleador_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0013']);
        $subcuenta_infotep_empleador_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_creditos, 'nro_subcuenta' => '0014']);

        //ELEMENTO DEL GASTO
        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findOneBy(['activo' => true, 'codigo' => '5001']);

        /** Asentando las operaciones */
        /****** DEBITOS *****/
        $gasto_sueldo = AuxFunctions::createAsiento($em, $cuenta_total_ingreso, $subcuenta_total_ingreso, null, $unidad, null,
            null, $elemento_gasto, null, null, null, 0, 0, $fecha, $anno,
            0, $total_ingreso, '', null, null, null, $new_registro_comprobante);
        $afp_patrimonial = AuxFunctions::createAsiento($em, $cuenta_debito_empleador, $subcuenta_afp_empleador, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            0, $total_afp_empleador, '', null, null, null, $new_registro_comprobante);
        $sfs_patrimonial = AuxFunctions::createAsiento($em, $cuenta_debito_empleador, $subcuenta_sfs_empleador, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            0, $total_sfs_empleador, '', null, null, null, $new_registro_comprobante);
        $srl_patrimonial = AuxFunctions::createAsiento($em, $cuenta_debito_empleador, $subcuenta_srl_empleador, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            0, $total_srl_empleador, '', null, null, null, $new_registro_comprobante);
        $infotep_patrimonial = AuxFunctions::createAsiento($em, $cuenta_debito_empleador, $subcuenta_infotep_empleador, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            0, $total_infotep_empleador, '', null, null, null, $new_registro_comprobante);
        /****** CREDITOS *****/
        $efectivo = AuxFunctions::createAsiento($em, $cuenta_efectivo_creditos, $subcuenta_efectivo_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_sueldo_neto, 0, '', null, null, null, $new_registro_comprobante);
        $isr = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_isr_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_impuesto_sobre_renta, 0, '', null, null, null, $new_registro_comprobante);
        $ars = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_ars_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_ars, 0, '', null, null, null, $new_registro_comprobante);
        $afp = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_afp_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_afp, 0, '', null, null, null, $new_registro_comprobante);
        $cooperativa = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_cooperativa_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_cooperativa, 0, '', null, null, null, $new_registro_comprobante);
        $plan_medico = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_plan_medico_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_plan_medico_complementario, 0, '', null, null, null, $new_registro_comprobante);
        $restaurant = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_restaurant_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_restaurant, 0, '', null, null, null, $new_registro_comprobante);
        $afp_patrimonial_credito = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_afp_empleador_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_afp_empleador, 0, '', null, null, null, $new_registro_comprobante);
        $sfs_patrimonial_credito = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_sfs_empleador_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_sfs_empleador, 0, '', null, null, null, $new_registro_comprobante);
        $srl_patrimonial_credito = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_srl_empleador_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_srl_empleador, 0, '', null, null, null, $new_registro_comprobante);
        $infotep_patrimonial_credito = AuxFunctions::createAsiento($em, $cuenta_creditos, $subcuenta_infotep_empleador_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_infotep_empleador, 0, '', null, null, null, $new_registro_comprobante);


        $em->flush();
        return $this->render('contabilidad/capital_humano/comprobante_operaciones_extraordinaria/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro_comprobante->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}
