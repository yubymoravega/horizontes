<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\General\CobrosPagos;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\Contabilidad\Venta\Factura;
use App\Form\Contabilidad\General\ComprobanteOperacionesType;
use App\Form\Contabilidad\General\CuentasComprobanteOperacionesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteOperacionesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/comprobante-operaciones")
 */
class ComprobanteOperacionesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_comprobante_operaciones")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
//        EJEMPLO D COMO DEBE LIQUIDAR UNA FACTURA DE SERVICIO EN LA FUNCIONALIDAD DE CHEKOUT
//        $add = AuxFunctions::addComprobanteCobro($em, 3, 4,
//            1, 2,
//            'transferencia', 20.00, $this->getUser());
//        if ($add != '')
//            $em->flush();
//        else
//            dd($add);
        /** @var Unidad $obj_unidad */
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fecha = AuxFunctions::getCurrentDate($em,$obj_unidad);
        $arr_fecha = explode('-', $fecha);
        $year_ = AuxFunctions::getCurrentYear($em,$obj_unidad);

        $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_unidad' => $obj_unidad,
            'anno' => $year_
        ));
        $nro_consecutivo = count($arr_registros) + 1;

        $form_comprobante = $this->createForm(ComprobanteOperacionesType::class);
        $form_comprobante->handleRequest($request);
        $form_cuentas_comprobantes = $this->createForm(CuentasComprobanteOperacionesType::class);
        if ($form_comprobante->isSubmitted()) {
            $total_debito = floatval($request->get('debito_total'));
            $total_credito = floatval($request->get('credito_total'));
            $comprobante = $request->get('comprobante_operaciones');
            $operaciones = json_decode($request->get('operaciones'));
            $pagos_cobros = json_decode($request->get('pagos_cobros'));
//            dd($comprobante,$operaciones,$pagos_cobros);
            if ($total_credito == $total_debito) {
                $new_registro = new RegistroComprobantes();

                /** verificando que el nro que mostre en pantalla sea el mismo que le corresponde al registro,
                 * y nadie halla hecho un comprobante en el tiempo que el usuario llenava el
                 * formulario
                 **/
                $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                    'id_unidad' => $obj_unidad,
                    'anno' => $year_
                ));
                $nro_consecutivo_real = count($arr_registros) + 1;
                $obj_tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(intval($comprobante['tipo_comprobante']));
                $new_registro
                    ->setDescripcion($comprobante['explicacion'])
                    ->setIdUsuario($this->getUser())
                    ->setFecha($fecha)
                    ->setAnno($year_)
                    ->setTipo(AuxFunctions::$COMMPROBANTE_OPERACONES_CONTABILIDAD)
                    ->setCredito($total_credito)
                    ->setDebito($total_debito)
                    ->setIdTipoComprobante($obj_tipo_comprobante)
                    ->setIdUnidad($obj_unidad)
                    ->setDocumento($comprobante['documento'])
                    ->setNroConsecutivo($nro_consecutivo_real);
                $em->persist($new_registro);
                /** Adicionando las operaciones con las cuentas del comprobante de operaciones recien creado */
                $cuenta_er = $em->getRepository(Cuenta::class);
                $subcuenta_er = $em->getRepository(Subcuenta::class);
                $centro_costo_er = $em->getRepository(CentroCosto::class);
                $orden_trabajo_er = $em->getRepository(OrdenTrabajo::class);
                $elemento_gasto_er = $em->getRepository(ElementoGasto::class);
                $expediente_er = $em->getRepository(Expediente::class);
                $proveedor_er = $em->getRepository(Proveedor::class);
                $almacen_er = $em->getRepository(Almacen::class);
                $unidad_er = $em->getRepository(Unidad::class);
                $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
                $factura_er = $em->getRepository(Factura::class);

                if (!empty($pagos_cobros)){
                    foreach ($pagos_cobros as $pagos) {
                        if ($pagos->type == 'IR') {
                            $informe_recepcion_obj = $informe_recepcion_er->find(intval($pagos->id_factura));
                            $new_cobro_pago = new CobrosPagos();
                            $new_cobro_pago
                                ->setIdInforme($informe_recepcion_obj)
                                ->setIdProveedor($informe_recepcion_obj->getIdProveedor())
                                ->setCredito(floatval($pagos->importe))
                                ->setDebito(0);
                            $em->persist($new_cobro_pago);
                        }
                        if ($pagos->type == 'FACT') {
                            /** @var Factura $factura */
                            $factura = $factura_er->find(intval($pagos->id_factura));
                            $new_cobro_pago = new CobrosPagos();
                            $new_cobro_pago
                                ->setIdFactura($factura)
                                ->setIdTipoCliente($factura->getTipoCliente())
                                ->setIdClienteVenta($factura->getIdCliente())
                                ->setDebito(floatval($pagos->importe))
                                ->setCredito(0);
                            $em->persist($new_cobro_pago);
                        }
                    }
                }

                foreach ($operaciones as $item) {
                    $cuenta = $cuenta_er->find(intval($item->cuenta));
                    $subcuenta = $subcuenta_er->findOneBy([
                        'id_cuenta' => $cuenta,
                        'nro_subcuenta' => $item->subcuenta,
                        'activo' => true
                    ]);

                    $new_operaciones_comprobante = new OperacionesComprobanteOperaciones();
                    $new_operaciones_comprobante
                        ->setIdCliente(isset($item->cliente) ? intval($item->cliente) : null)
                        ->setIdProveedor(isset($item->proveedor) ? $proveedor_er->find(intval($item->proveedor)) : null)
                        ->setIdCentroCosto(isset($item->centro_costo) ? $centro_costo_er->find(intval($item->centro_costo)) : null)
                        ->setIdOrdenTrabajo(isset($item->orden_tabajo) ? $orden_trabajo_er->find(intval($item->orden_tabajo)) : null)
                        ->setIdElementoGasto(isset($item->elemento_gasto) ? $elemento_gasto_er->find(intval($item->elemento_gasto)) : null)
                        ->setIdExpediente(isset($item->expediente) ? $expediente_er->find(intval($item->expediente)) : null)
                        ->setIdAlmacen(isset($item->almacen) ? $almacen_er->find(intval($item->almacen)) : null)
                        ->setIdUnidad(isset($item->unidad) ? $unidad_er->find(intval($item->unidad)) : $obj_unidad)
                        ->setIdCuenta($cuenta_er->find(intval($item->cuenta)))
                        ->setIdSubcuenta($subcuenta)
                        ->setCredito(floatval($item->credito))
                        ->setDebito(floatval($item->debito))
                        ->setIdTipoCliente(intval($item->tipo_cliente) != 0 ? intval($item->tipo_cliente) : null)
                        ->setIdRegistroComprobantes($new_registro);
                    $em->persist($new_operaciones_comprobante);

                    //asentando las operacones
                    $new_asiento = new Asiento();
                    $new_asiento
                        ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha))
                        ->setAnno($year_)
                        ->setNroDocumento('-')
                        ->setIdDocumento(null)
                        ->setIdFactura(null)
                        ->setIdComprobante($new_registro)
                        ->setIdTipoComprobante($obj_tipo_comprobante)
                        ->setIdCliente(isset($item->cliente) ? intval($item->cliente) : null)
                        ->setIdProveedor(isset($item->proveedor) ? $proveedor_er->find(intval($item->proveedor)) : null)
                        ->setIdCentroCosto(isset($item->centro_costo) ? $centro_costo_er->find(intval($item->centro_costo)) : null)
                        ->setIdOrdenTrabajo(isset($item->orden_tabajo) ? $orden_trabajo_er->find(intval($item->orden_tabajo)) : null)
                        ->setIdElementoGasto(isset($item->elemento_gasto) ? $elemento_gasto_er->find(intval($item->elemento_gasto)) : null)
                        ->setIdExpediente(isset($item->expediente) ? $expediente_er->find(intval($item->expediente)) : null)
                        ->setIdAlmacen(isset($item->almacen) ? $almacen_er->find(intval($item->almacen)) : null)
                        ->setIdUnidad(isset($item->unidad) ? $unidad_er->find(intval($item->unidad)) : $obj_unidad)
                        ->setIdCuenta($cuenta_er->find(intval($item->cuenta)))
                        ->setIdSubcuenta($subcuenta)
                        ->setCredito(floatval($item->credito))
                        ->setDebito(floatval($item->debito))
                        ->setTipoCliente(intval($item->tipo_cliente) != 0 ? intval($item->tipo_cliente) : null);
                    $em->persist($new_asiento);
                }

                try {
                    $em->flush();
                } catch (FileException $exception) {
                    return $exception->getMessage();
                }
                if ($nro_consecutivo == $nro_consecutivo_real)
                    $message = 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo_real . ', para ver detalles consulte el registro de comprobantes.';
                else {
                    $message = 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo_real . ', esto se debe a que algun usuario generó un comprobante en el tiempo que usted llenaba los datos del formulario. Para ver detalles consulte el registro de comprobantes.';
                }
                return $this->render('contabilidad/general/comprobante_operaciones/notify.html.twig', [
                    'controller_name' => 'ComprobanteOperacionesController',
                    'title' => '!!Exito',
                    'message' => $message
                ]);
            } else
                $this->$this->addFlash('error', 'El los débitos y créditos debe ser iguales.');
        }
        return $this->render('contabilidad/general/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'form_comprobante' => $form_comprobante->createView(),
            'form_cuentas_comprobantes' => $form_cuentas_comprobantes->createView(),
            'nro_consecutivo' => $nro_consecutivo
        ]);
    }

    /** @Route("/getFacturas", name="contabilidad_general_get_facturas", methods={"POST"}) */
    public function getFacturas(EntityManagerInterface $em, Request $request)
    {
        $tipo_cliente = $request->request->get('tipo_cliente');
        $cliente = $request->request->get('cliente');
        $facturas = $em->getRepository(Factura::class)->findBy([
            'tipo_cliente' => intval($tipo_cliente),
            'id_cliente' => intval($cliente),
            'cancelada' => false,
            'activo' => true,
            'id_factura_cancela' => null
        ]);
        $row = [];
        $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
        $cobros_er = $em->getRepository(CobrosPagos::class);
        /** @var Factura $item */
        foreach ($facturas as $item) {
//            dd($item);
            $cobro_factura = $cobros_er->findBy([
                'id_factura' => $item
            ]);
            $resto = floatval($item->getImporte());
            if (!empty($cobro_factura))
                /** @var CobrosPagos $cobro */
                foreach ($cobro_factura as $cobro)
                    $resto = $resto - floatval($cobro->getDebito());
            if ($resto > 0)
                $row[] = array(
                    'id' => $item->getId(),
                    'documento' => 'FACT-' . $item->getNroFactura(),
                    'importe_mostrar' => number_format($item->getImporte(), 2),
                    'importe' => number_format($resto, 2),
                    'resto' => number_format($resto,2),
                    'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                    'antiguedad' => $today->diff($item->getFechaFactura())->days
                );
        }
        return new JsonResponse(['success' => true, 'data' => $row]);
    }

    /** @Route("/getDeudas", name="contabilidad_general_get_deudas", methods={"POST"}) */
    public function getDeudas(EntityManagerInterface $em, Request $request)
    {
        $proveedor = $request->request->get('proveedor');
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $almacenes = $em->getRepository(Almacen::class)->findBy([
            'id_unidad' => $unidad
        ]);

        $informes = $em->getRepository(InformeRecepcion::class)->findBy([
            'id_proveedor' => $em->getRepository(Proveedor::class)->find(intval($proveedor)),
            'activo' => true,
            'producto' => false
        ]);
        $row = [];
        $cobros_er = $em->getRepository(CobrosPagos::class);
        $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
        /** @var InformeRecepcion $item */
        foreach ($informes as $item) {
            if (in_array($item->getIdDocumento()->getIdAlmacen(), $almacenes)) {

                $pago_informe = $cobros_er->findBy([
                    'id_informe' => $item
                ]);
                $resto = floatval($item->getIdDocumento()->getImporteTotal());
                if (!empty($pago_informe))
                    /** @var CobrosPagos $cobro */
                    foreach ($pago_informe as $cobro)
                        $resto = $resto - floatval($cobro->getCredito());
                if ($resto > 0)
                    $row[] = array(
                        'id' => $item->getId(),
                        'documento' => $item->getCodigoFactura(),
                        'importe_mostrar' => number_format($item->getIdDocumento()->getImporteTotal(), 2),
                        'importe' => number_format($resto, 2),
                        'resto' => number_format($resto,2),
                        'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                        'antiguedad' => $today->diff($item->getFechaFactura())->days
                    );
            }
        }
        return new JsonResponse(['success' => true, 'data' => $row]);
    }
}
