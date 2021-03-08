<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\ComprobanteSalario;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use App\Entity\Contabilidad\CapitalHumano\NominasConsecutivos;
use App\Entity\Contabilidad\CapitalHumano\NominaTerceroComprobante;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PagoNavidadesController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/pago-mes-13")
 */
class PagoNavidadesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_pago_navidades")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $rows = [];
        $anno = intval(Date('Y'));
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $nomina_pago_er = $em->getRepository(NominaPago::class);
        $arr_data = $nomina_pago_er->findBy([
            'anno' => $anno,
            'quincena' => 4,
            'id_unidad' => $unidad
        ]);

        if (!empty($arr_data)) {
            if ($arr_data[0]->getAprobada()) {
                $message = 'El pago del mes 13 del año ' . ($anno - 1) . ' ya ha sido efectuado.';
                return $this->render('contabilidad/capital_humano/pago_navidades/error.html.twig', [
                    'controller_name' => 'PagoNavidadesController',
                    'message' => $message
                ]);
            } else {
                /** @var NominaPago $data */
                foreach ($arr_data as $data) {
                    $rows[] = array(
                        'elaborada' => true,
                        'aprobada' => false,
                        'empleado' => $data->getIdEmpleado()->getNombre(),
                        'sueldo_bruto' => number_format($data->getIdEmpleado()->getSueldoBrutoMensual(), 2),
                        'a_pagar' => number_format($data->getSueldoNetoPagar(), 2),
                    );
                }
                return $this->render('contabilidad/capital_humano/pago_navidades/index.html.twig', [
                    'controller_name' => 'PagoNavidadesController',
                    'datos' => $rows
                ]);
            }
        }

        $empleados_er = $em->getRepository(Empleado::class);
        $empleados_unidad = $empleados_er->findBy([
            'id_unidad' => $unidad,
        ]);
        /** @var Empleado $item */
        foreach ($empleados_unidad as $item) {
            if ($item->getFechaAlta()->format('Y') <= ($anno - 1)) {
                if ($item->getFechaBaja() == null) {
                    if ($item->getFechaAlta()->format('Y') == ($anno - 1))
                        $cant_meses = 12 - intval($item->getFechaAlta()->format('m')) + 1;
                    else
                        $cant_meses = 12;
                } else {
                    if ($item->getFechaBaja()->format('Y') == $anno) {
                        $cant_meses = 12;
                    } else {
                        if ($item->getFechaBaja()->format('Y') == ($anno - 1)) {
                            $cant_meses = intval($item->getFechaBaja()->format('m'));
                        } else {
                            $cant_meses = 0;
                        }
                    }
                }
            } else {
                $cant_meses = 0;
            }
            if ($cant_meses > 0) {
                $nomina_pago = new NominaPago();
                $nomina_pago
                    ->setIdUnidad($unidad)
                    ->setMes(Date('m'))
                    ->setAnno(Date('Y'))
                    ->setQuincena(4)
                    ->setIdEmpleado($item)
                    ->setSalarioBruto(round(($item->getSueldoBrutoMensual() / 12 * $cant_meses), 2))
                    ->setTotalIngresos(round(($item->getSueldoBrutoMensual() / 12 * $cant_meses), 2))
                    ->setSueldoNetoPagar(round(($item->getSueldoBrutoMensual() / 12 * $cant_meses), 2))
                    ->setIngresosCotizablesTss(0)
                    ->setElaborada(true)
                    ->setAprobada(false)
                    ->setFecha(\DateTime::createFromFormat('d-m-Y', Date('d-m-Y')));
                $em->persist($nomina_pago);

                //--mostrar datos
                $rows[] = array(
                    'elaborada' => true,
                    'aprobada' => false,
                    'empleado' => $item->getNombre(),
                    'cantidad_mese' => $cant_meses,
                    'fecha_alta' => $item->getFechaAlta()->format('d-m-y'),
                    'fecha_baja' => $item->getFechaBaja() ? $item->getFechaBaja()->format('d-m-y') : '',
                    'sueldo_bruto' => $item->getSueldoBrutoMensual(),
                    'sueldo_bruto_calculo' => round(($item->getSueldoBrutoMensual() / 12), 2),
                    'a_pagar' => round(($item->getSueldoBrutoMensual() / 12 * $cant_meses), 2),
                );
            }
        }
        $em->flush();

        return $this->render('contabilidad/capital_humano/pago_navidades/index.html.twig', [
            'controller_name' => 'PagoNavidadesController',
            'datos ' => $rows
        ]);
    }

    /**
     * @Route("/aceptar-pago", name="aceptar_pago_navidades")
     */
    public function aceptarPago(EntityManagerInterface $em, Request $request)
    {
        $quincena = 4;
        $observacion = $request->request->get('observacion');
        $fecha = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
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
        //credito 455/0010(por crear la subcuenta)
        $total_sueldo_neto = 0;

        /** @var NominaPago $item */
        foreach ($data_nominas as $item) {
            $item
                ->setAprobada(true)
                ->setIdUsuarioAprueba($this->getUser());
            $em->persist($item);
            $total_ingreso += $item->getTotalIngresos();
            $total_sueldo_neto += $item->getSueldoNetoPagar();
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
        $debito = $total_sueldo_neto;
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
        $cuenta_total_ingreso = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '823']);
        $subcuenta_total_ingreso = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_total_ingreso, 'nro_subcuenta' => '0010']);

        //CREDITOS
        $cuenta_efectivo_creditos = $cuenta_er->findOneBy(['activo' => true, 'nro_cuenta' => '455']);
        $subcuenta_efectivo_credito = $subcuenta_er->findOneBy(['activo' => true, 'id_cuenta' => $cuenta_efectivo_creditos, 'nro_subcuenta' => '0010']);

        //insertando consecutivo de la nomina
        $nominas = $em->getRepository(NominasConsecutivos::class)->findBy([
            'anno' => $anno,
            'id_unidad' => $unidad
        ]);
        $numero = count($nominas) + 1;

        if ($numero < 10)
            $str = '0' . $numero;
        else
            $str = $numero;
        $new_nomina_consecutivo = new NominasConsecutivos();
        $new_nomina_consecutivo
            ->setIdUnidad($unidad)
            ->setAnno($anno)
            ->setMes(13)
            ->setNroConsecutivo($numero);
        $em->persist($new_nomina_consecutivo);

        $str_nomina = $str . '.13.' . $anno;

        //ELEMENTO DEL GASTO
        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findOneBy(['activo' => true, 'codigo' => '5001']);

        /** Asentando las operaciones */
        /****** DEBITOS *****/
        $gasto_sueldo = AuxFunctions::createAsiento($em, $cuenta_total_ingreso, $subcuenta_total_ingreso, null, $unidad, null,
            null, $elemento_gasto, null, null, null, 0, 0, $fecha, $anno,
            0, $total_ingreso, $str_nomina, null, null, null, $new_registro_comprobante);

        /****** CREDITOS *****/
        $efectivo = AuxFunctions::createAsiento($em, $cuenta_efectivo_creditos, $subcuenta_efectivo_credito, null, $unidad, null,
            null, null, null, null, null, 0, 0, $fecha, $anno,
            $total_sueldo_neto, 0, $str_nomina, null, null, null, $new_registro_comprobante);

        /** ACTUALIZAR LA ENTIDAD DE ComprobanteSalario**/
        $comprobante_salario_obj = $em->getRepository(ComprobanteSalario::class)->findOneBy([
            'mes' => 13,
            'anno' => $anno,
            'quincena' => 4,
            'id_unidad' => $unidad
        ]);
        if (!$comprobante_salario_obj) {
            $new_comprobante_salario = new ComprobanteSalario();
            $new_comprobante_salario
                ->setQuincena(4)
                ->setMes(13)
                ->setAnno($anno)
                ->setIdUnidad($unidad)
                ->setIdRegistroComprobante($new_registro_comprobante);
            $em->persist($new_comprobante_salario);
        } else {
            $comprobante_salario_obj
                ->setIdRegistroComprobante($new_registro_comprobante);
            $em->persist($comprobante_salario_obj);
        }

        $em->flush();
        $this->addFlash('success', 'El pago ha sido Aceptado satisfactoriamente');
        return $this->index($em, $request);
        }

    /**
     * @Route("/revertir-pago", name="revertir_pago")
     */
    public function revertirPago(EntityManagerInterface $em, Request $request)
    {
        $quincena = 4;
        $observacion = $request->request->get('observacion');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fecha = AuxFunctions::getCurrentDate($em, $unidad);
        $mes = 13;
        $anno = $fecha->format('Y');

        $data_nominas = $em->getRepository(NominaPago::class)->findBy([
            'elaborada' => true,
            'anno' => $anno,
            'id_unidad' => $unidad,
            'quincena'=>$quincena
        ]);

        if (empty($data_nominas)) {
            $this->addFlash('error', 'No ha nominas pagadas que revertir');
            return $this->redirectToRoute('contabilidad_capital_humano_pago_navidades');
        }

        $data_nominas = $em->getRepository(NominaPago::class)->findBy([
            'elaborada' => true,
            'aprobada' => true,
            'anno' => $anno,
            'id_unidad' => $unidad,
            'quincena' => $quincena
        ]);

        /** @var NominaPago $item */
        foreach ($data_nominas as $item) {
            $item
                ->setAprobada(false)
                ->setIdUsuarioAprueba(null);
            $em->persist($item);
        }

        /*** OBTENER EL cOMPROBANTE DE SALARIO PARA REVERTIR LOS ASIENTOS**/
        /** @var ComprobanteSalario $comprobante_salario_obj */
        $comprobante_salario_obj = $em->getRepository(ComprobanteSalario::class)->findOneBy([
            'mes' => $mes,
            'anno' => $anno,
            'quincena' => $quincena,
            'id_unidad' => $unidad
        ]);

        $all_comprobantes_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy([
            'id_tipo_comprobante' => $comprobante_salario_obj->getIdRegistroComprobante()->getIdTipoComprobante(),
            'id_unidad' => $unidad,
            'anno' => $anno
        ]);
        $consecutivo = count($all_comprobantes_operaciones) + 1;

        /**YA CON EL COMPROBANTE, PROCEDO A INVERTIRNLO**/
        $new_registro_comprobante = new RegistroComprobantes();
        $new_registro_comprobante
            ->setDescripcion($observacion)
            ->setIdUsuario($this->getUser())
            ->setFecha($fecha)
            ->setAnno($anno)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_NOMINAS)
            ->setCredito($comprobante_salario_obj->getIdRegistroComprobante()->getDebito())
            ->setDebito($comprobante_salario_obj->getIdRegistroComprobante()->getDebito())
            ->setIdAlmacen(null)
            ->setIdTipoComprobante($comprobante_salario_obj->getIdRegistroComprobante()->getIdTipoComprobante())
            ->setIdUnidad($unidad)
            ->setNroConsecutivo($consecutivo);
        $em->persist($new_registro_comprobante);

        /*** OBTENER TODOS LOS ASIENTOS CONTABLES DEL COMPROBANTE REVERTIDO ***/
        $asientos = $em->getRepository(Asiento::class)->findBy([
            'id_comprobante' => $comprobante_salario_obj->getIdRegistroComprobante()
        ]);
        foreach ($asientos as $item) {
            $new_asiento = AuxFunctions::createAsiento($em, $item->getIdCuenta(), $item->getIdSubcuenta(), null, $unidad, null,
                null, $item->getIdElementoGasto(), null, null, null, 0, 0, $fecha, $anno,
                $item->getDebito(), $item->getCredito(), $item->getNroDocumento(), null, null, null, $new_registro_comprobante);
        }

        $em->flush();
        $this->addFlash('success', 'El pago ha sido revertido satisfactoriamente');
            return $this->index($em, $request);
    }

}
