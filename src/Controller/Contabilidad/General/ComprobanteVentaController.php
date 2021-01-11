<?php

namespace App\Controller\Contabilidad\General;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\CoreContabilidad\AuxFunctions;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\General\FacturasComprobante;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use App\Entity\Contabilidad\Inventario\Expediente;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\OrdenTrabajo;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\MovimientoServicio;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use App\Form\Contabilidad\General\ComprobanteVentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteVentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/comprobante-venta")
 */
class ComprobanteVentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_comprobante_venta", methods={"POST","GET"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $year_ = AuxFunctions::getCurrentYear($em, $unidad);
        $facturas = $em->getRepository(Factura::class)->findBy([
            'anno' => $year_,
            'id_unidad' => $unidad,
            'contabilizada' => false
        ]);
        $row = [];
        /** @var Factura $item */
        foreach ($facturas as $item) {
            $row[] = array(
                'nro_factura' => 'FACT' . $item->getNroFactura(),
                'fecha' => $item->getFechaFactura()->format('d/m/Y'),
                'importe' => number_format($item->getImporte(), 2),
                'id' => $item->getId()
            );
        }
        $form = $this->createForm(ComprobanteVentaType::class);
        return $this->render('contabilidad/general/comprobante_venta/index.html.twig', [
            'controller_name' => 'ComprobanteVentaController',
            'facturas' => $row,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/generar", name="contabilidad_general_comprobante_venta_generar", methods={"POST","GET"})
     */
    public function GenerarComprobante(EntityManagerInterface $em, Request $request)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $year_ = AuxFunctions::getCurrentYear($em, $unidad);
        //hacer que las traiga todas, incluyendo las eliminadas y todo
        $facturas = $em->getRepository(Factura::class)->findBy([
            'contabilizada' => true,
            'anno' => $year_,
            'id_unidad' => $unidad,
            'activo' => false
        ]);

        $facturas_contabiliazadas = $em->getRepository(FacturasComprobante::class)->findBy([
            'anno' => $year_,
            'id_unidad' => $unidad
        ]);
        $arr_facturas = [];
        $data = [];
        $arr_ids = [];
        /** @var FacturasComprobante $d */
        foreach ($facturas_contabiliazadas as $d) {
            $arr_ids[count($arr_ids)] = $d->getIdFactura()->getId();
        }
        foreach ($facturas as $fac) {
            if (!in_array($fac->getId(), $arr_ids))
                $arr_facturas[] = $fac;
        }
        $movimiento_venta_er = $em->getRepository(MovimientoVenta::class);
        $movimiento_venta_servicio_er = $em->getRepository(MovimientoServicio::class);
        /** @var Factura $factura */
        $total_debito = 0;
        $cliente_extero = $em->getRepository(ClienteContabilidad::class);
        $cliente_interno = $em->getRepository(Unidad::class);
        $persona_natural = $em->getRepository(Cliente::class);
        foreach ($arr_facturas as $factura) {
            $total_impuesto = 0;
            $row = [];
            $total_debito += $factura->getImporte();
            $mes = $factura->getFechaFactura()->format('m');
            $anno = $factura->getFechaFactura()->format('Y');
            $nro_doc = 'FACT-' . $factura->getNroFactura();
            /** Addiciono la factura con la cuenta de obligacion */
            if ($factura->getTipoCliente() == ClientesAdapter::PERSONA) {
                $cliente = $persona_natural->find($factura->getIdCliente())->getNombre();
            } elseif ($factura->getTipoCliente() == ClientesAdapter::UNIDAD_SISTEMA) {
                $cliente = $cliente_interno->find($factura->getIdCliente())->getCodigo();
            } elseif ($factura->getTipoCliente() == ClientesAdapter::CLIENTE_CONTABILIDAD) {
                $cliente = $cliente_extero->find($factura->getIdCliente())->getCodigo();
            }
            $row[] = array(
                'nro_doc' => $nro_doc,
                'fecha' => $factura->getFechaFactura()->format('d/m/Y'),
                'nro_cuenta' => $factura->getCuentaObligacion(),
                'nro_subcuenta' => $factura->getSubcuentaObligacion(),
                'analisis_1' => $cliente,
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'analisis_2' => '',
                'analisis_3' => '',
                'mes' => $mes,
                'anno' => $anno,
                'debito' => number_format($factura->getImporte(), 2),
                'credito' => ''
            );
            if (!$factura->getServicio())
                $arr_movimientos = $movimiento_venta_er->findBy(['id_factura' => $factura]);
            else
                $arr_movimientos = $movimiento_venta_servicio_er->findBy(['id_factura' => $factura]);

            $str_criterio = [];
            /** @var MovimientoVenta $movimiento_venta */
            foreach ($arr_movimientos as $movimiento_venta) {
                $srt_movimiento = $movimiento_venta->getCuentaAcreedora() . '-' . $movimiento_venta->getSubcuentaAcreedora();
                if (!in_array($srt_movimiento, $str_criterio))
                    $str_criterio[count($str_criterio)] = $srt_movimiento;
            }
            $total = 0;
            foreach ($str_criterio as $criterio) {
                $credito = 0;
                foreach ($arr_movimientos as $movimiento_venta) {
                    $srt_movimiento = $movimiento_venta->getCuentaAcreedora() . '-' . $movimiento_venta->getSubcuentaAcreedora();
                    if ($criterio == $srt_movimiento) {
                        $total_impuesto += ($factura->getServicio() ? $movimiento_venta->getImpuesto() : $movimiento_venta->getDescuentoRecarga());
                        $credito += ($movimiento_venta->getCantidad() * $movimiento_venta->getPrecio());
                    }
                }
                $total += $credito;
                $arr_criterios = explode('-', $criterio);
                /** Voy adicionando los mivimientos de la venta con las cuentas acreedoras */
                $row[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $arr_criterios[0],
                    'nro_subcuenta' => $arr_criterios[1],
                    'analisis_1' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $mes,
                    'anno' => $anno,
                    'debito' => '',
                    'credito' => number_format($credito, 2)
                );
            }
            if ($total_impuesto > 0)
                $row[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '440',
                    'nro_subcuenta' => '0001',
                    'analisis_1' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => $mes,
                    'anno' => $anno,
                    'debito' => '',
                    'credito' => number_format($total_impuesto, 2)
                );
            $row[] = array(
                'nro_doc' => '',
                'fecha' => '',
                'nro_cuenta' => '',
                'nro_subcuenta' => '',
                'analisis_1' => '',
                'value_1' => '',
                'value_2' => '',
                'value_3' => '',
                'analisis_2' => '',
                'analisis_3' => '',
                'mes' => '',
                'anno' => '',
                'debito' => number_format(($total + $total_impuesto), 2),
                'credito' => number_format(($total + $total_impuesto), 2)
            );
            if ($factura->getIdFacturaCancela() == null) {
                $data [] = array(
                    'nro_doc' => $nro_doc,
                    'datos' => $row
                );
            } else {
                $fecha = $row[0]['fecha'];
                $reverse = array_reverse($row);
                $new_row = [];
                $index = 0;
                foreach ($reverse as $key => $item) {
                    if ($key > 0) {
                        $new_row[] = [
                            'nro_doc' => $index == 0 ? $nro_doc : '',
                            'fecha' => $index == 0 ? $fecha : '',
                            'nro_cuenta' => $item['nro_cuenta'],
                            'nro_subcuenta' => $item['nro_subcuenta'],
                            'analisis_1' => $item['analisis_1'],
                            'value_1' => $item['value_1'],
                            'value_2' => $item['value_2'],
                            'value_3' => $item['value_3'],
                            'analisis_2' => $item['analisis_2'],
                            'analisis_3' => $item['analisis_3'],
                            'mes' => $item['mes'],
                            'anno' => $item['anno'],
                            'debito' => $item['credito'],
                            'credito' => $item['debito']
                        ];
                        $index++;
                    }
                }
                $new_row[] = [
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'mes' => '',
                    'anno' => '',
                    'debito' => $row[0]['debito'],
                    'credito' => $row[0]['credito'],
                ];
                $data [] = array(
                    'nro_doc' => $nro_doc,
                    'datos' => $new_row
                );
            }
        }

        return $this->render('contabilidad/general/comprobante_venta/comprobante.html.twig', [
            'unidad' => $unidad->getCodigo() . ' - ' . $unidad->getNombre(),
            'fecha' => AuxFunctions::getCurrentDate($em, $unidad)->format('d-m-Y'),
            'datos' => $data,
            'total_debito' => number_format($total_debito, 2),
            'total_credito' => number_format($total_debito, 2),
            'debito' => $total_debito,
            'credito' => $total_debito
        ]);
    }

    /**
     * @Route("/getListadoMercancias/{id}", name="contabilidad_general_getListado", methods={"POST"})
     */
    public function getMercancias(EntityManagerInterface $em, $id)
    {
        $arr_mercancias = $em->getRepository(MovimientoVenta::class)->findBy(['id_factura' => $id]);
        $row = [];
        /** @var MovimientoVenta $item */
        foreach ($arr_mercancias as $item) {
            $criteria = ['codigo' => $item->getCodigo(), 'id_amlacen' => $item->getIdAlmacen()->getId()];
            $descripcion = $item->getMercancia() == true ? $em->getRepository(Mercancia::class)->findOneBy($criteria)->getDescripcion() : $em->getRepository(Producto::class)->findOneBy($criteria)->getDescripcion();
            $row[] = array(
                'id_movimiento_venta' => $item->getId(),
                'tipo_mercancia' => $item->getMercancia(),
                'id_almacen' => $item->getIdAlmacen()->getId(),
                'mercancia' => $item->getCodigo() . ' - ' . $descripcion
            );
        }
        return new JsonResponse(['success' => true, 'data' => $row]);
    }

    /**
     * @Route("/contabilizar-factura", name="contabilidad_general_contabilizar_factura", methods={"POST"})
     */
    public function contabilizarFactura(EntityManagerInterface $em, Request $request)
    {
        $comprobante_venta = $request->get('comprobante_venta');
        $cuenta_obligacion_deudora = $comprobante_venta['cuenta_obligacion_deudora'];
        $subcuenta_obligacion_deudora = $comprobante_venta['subcuenta_obligacion_deudora'];
        $centro_costo_deudora = $comprobante_venta['centro_costo_deudora'];
        $orden_trabajo_deudora = $comprobante_venta['orden_trabajo_deudora'];
        $elemento_gasto_deudora = $comprobante_venta['elemento_gasto_deudora'];
        $expediente_deudora = $comprobante_venta['expediente_deudora'];
        $id_factura = $request->get('id_factura');

        $list_mercancia = json_decode($comprobante_venta['list_mercancia'], true);

        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercnacia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $movimiento_venta_er = $em->getRepository(MovimientoVenta::class);
        $centro_costo_er = $em->getRepository(CentroCosto::class);
        $orden_trabajo_er = $em->getRepository(OrdenTrabajo::class);
        $elemento_gasto_er = $em->getRepository(ElementoGasto::class);
        $expediente_er = $em->getRepository(Expediente::class);
        $factura = $em->getRepository(Factura::class)->find($id_factura);
        if (!$factura)
            return new JsonResponse(['success' => false, 'msg' => 'La factura no existe.']);
        /** 1. actualizar los datos de la factura***/
        $factura
            ->setCuentaObligacion($cuenta_obligacion_deudora)
            ->setSubcuentaObligacion($subcuenta_obligacion_deudora)
            ->setContabilizada(true)
            ->setIdCentroCosto($centro_costo_er->find($centro_costo_deudora) ? $centro_costo_er->find($centro_costo_deudora) : null)
            ->setIdOrdenTrabajo($orden_trabajo_er->find($orden_trabajo_deudora) ? $orden_trabajo_er->find($orden_trabajo_deudora) : null)
            ->setIdElementoGasto($elemento_gasto_er->find($elemento_gasto_deudora) ? $elemento_gasto_er->find($elemento_gasto_deudora) : null)
            ->setIdExpediente($expediente_er->find($expediente_deudora) ? $expediente_er->find($expediente_deudora) : null);
        $em->persist($factura);
        foreach ($list_mercancia as $mercancias) {
            $cuenta_nominal_acreedora = $mercancias['cuenta_nominal_acreedora'];
            $subcuenta_nominal_acreedora = $mercancias['subcuenta_nominal_acreedora'];
            $centro_costo_acreedora = $mercancias['centro_costo_acreedora'];
            $orden_trabajo_acreedora = $mercancias['orden_tabajo_acreedora'];
            $elemento_gasto_acreedora = $mercancias['elemento_gasto_acreedora'];
            $expediente_acreedora = $mercancias['expediente_acreedora'];

            /** @var MovimientoVenta $movimiento_venta */
            $movimiento_venta = $movimiento_venta_er->find($mercancias['id_movimiento_venta']);
            if ($movimiento_venta) {
                /** 2. actualizo el movimiento de venta***/
                $movimiento_venta
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setCuentaAcreedora($cuenta_nominal_acreedora)
                    ->setSubcuentaAcreedora($subcuenta_nominal_acreedora)
                    ->setIdElementoGastoAcreedor($elemento_gasto_er->find($elemento_gasto_acreedora) ? $elemento_gasto_er->find($elemento_gasto_acreedora) : null)
                    ->setIdCentroCostoAcreedor($centro_costo_er->find($centro_costo_acreedora) ? $centro_costo_er->find($centro_costo_acreedora) : null)
                    ->setIdOrdenTrabajoAcreedor($orden_trabajo_er->find($orden_trabajo_acreedora) ? $orden_trabajo_er->find($orden_trabajo_acreedora) : null)
                    ->setIdExpedienteAcreedor($expediente_er->find($expediente_acreedora) ? $expediente_er->find($expediente_acreedora) : null)
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($movimiento_venta);
            }
            /** 3. Actualizar los movimientos de mercancias o productos en dependencia de lo que sea**/
            if ($movimiento_venta->getMercancia()) {
                /** 3.1. Caso mercancia */
                /** @var Mercancia $obj_mercancia */
                $obj_mercancia = $mercancia_er->findOneBy([
                    'id_amlacen' => $movimiento_venta->getIdAlmacen(),
                    'codigo' => $movimiento_venta->getCodigo(),
//                    'activo' => true
                ]);
                /** @var MovimientoMercancia $obj_movimiento_mercancia */
                $obj_movimiento_mercancia = $movimiento_mercnacia_er->findOneBy([
                    'id_almacen' => $movimiento_venta->getIdAlmacen(),
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(10),
                    'activo' => false,
                    'entrada' => false,
                    'id_mercancia' => $obj_mercancia,
                    'id_factura' => $factura
                ]);
//                dd($obj_movimiento_mercancia,'mercancia');
                $obj_movimiento_mercancia
                    ->setActivo(true)
                    ->setIdCentroCosto($centro_costo_er->find($mercancias['centro_costo']))
                    ->setIdOrdenTrabajo($orden_trabajo_er->find($mercancias['orden_tabajo']))
                    ->setIdElementoGasto($elemento_gasto_er->find($mercancias['elemento_gasto']))
                    ->setIdExpediente($expediente_er->find($mercancias['expediente']))
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($obj_movimiento_mercancia);
            } else {
                /** 3.2. Caso producto */
                /** @var Producto $obj_producto */
                $obj_producto = $producto_er->findOneBy([
                    'id_amlacen' => $movimiento_venta->getIdAlmacen(),
                    'codigo' => $movimiento_venta->getCodigo(),
//                    'activo' => true
                ]);
                /** @var MovimientoProducto $obj_movimiento_producto */
                $obj_movimiento_producto = $movimiento_producto_er->findOneBy([
                    'id_almacen' => $movimiento_venta->getIdAlmacen(),
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find(10),
                    'activo' => false,
                    'entrada' => false,
                    'id_producto' => $obj_producto,
                    'id_factura' => $factura
                ]);
                $obj_movimiento_producto
                    ->setActivo(true)
                    ->setIdCentroCosto($centro_costo_er->find($mercancias['centro_costo']))
                    ->setIdOrdenTrabajo($orden_trabajo_er->find($mercancias['orden_tabajo']))
                    ->setIdElementoGasto($elemento_gasto_er->find($mercancias['elemento_gasto']))
                    ->setIdExpediente($expediente_er->find($mercancias['expediente']))
                    ->setCuenta($mercancias['cuenta_seleccionada'])
                    ->setNroSubcuentaDeudora($mercancias['subcuenta_seleccionada']);
                $em->persist($obj_movimiento_producto);
            }
        }
        $em->flush();
        $this->addFlash('success', 'Factura contabilizada satisfactoriamente.');
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/save", name="contabilidad_general_comprobante_venta_guardar")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $observacion = $request->get('observacion');
        $debito = $request->get('debito');
        $credito = $request->get('credito');

        /** @var Unidad $obj_unidad */
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $fecha = AuxFunctions::getCurrentDate($em, $obj_unidad);
//        $arr_fecha = explode('-', $fecha);
        $year_ = AuxFunctions::getCurrentYear($em, $obj_unidad);

        $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_unidad' => $obj_unidad,
            'anno' => $year_
        ));
        $nro_consecutivo = count($arr_registros) + 1;

        $new_registro = new RegistroComprobantes();
        $new_registro
            ->setDescripcion($observacion)
            ->setIdUsuario($this->getUser())
            ->setFecha($fecha)
            ->setAnno($year_)
            ->setTipo(AuxFunctions::COMMPROBANTE_OPERACONES_VENTA)
            ->setCredito(floatval($credito))
            ->setDebito(floatval($debito))
            ->setIdTipoComprobante($em->getRepository(TipoComprobante::class)->find(2))
            ->setIdUnidad($obj_unidad)
            ->setNroConsecutivo($nro_consecutivo);
        $em->persist($new_registro);

        $facturas = $em->getRepository(Factura::class)->findBy([
            'contabilizada' => true,
            'activo' => true,
            'anno' => $year_,
            'id_unidad' => $obj_unidad
        ]);
        $facturas_comprobante = $em->getRepository(FacturasComprobante::class)->findBy([
            'anno' => $year_,
            'id_unidad' => $obj_unidad
        ]);
        $fact = [];

        /** @var FacturasComprobante $d */
        foreach ($facturas_comprobante as $d) {
            $fact[count($fact)] = $d->getIdFactura()->getId();
        }
        /**
         * actualizando datos de asiento
         */
        $asiento_er = $em->getRepository(Asiento::class);

        foreach ($facturas as $fac) {
            if (!in_array($fac->getId(), $fact)) {
                $fact_comp = new FacturasComprobante();
                $fact_comp
                    ->setIdFactura($fac)
                    ->setIdUnidad($obj_unidad)
                    ->setAnno($year_)
                    ->setIdComprobante($new_registro);
                $em->persist($fact_comp);
            }

            //actualizo los asientos
            $arr_asiento = $asiento_er->findBy([
                'id_documento' => null,
                'id_factura' => $fac
            ]);
            if (!empty($arr_asiento))
                foreach ($arr_asiento as $obj_asiento) {
                    if ($obj_asiento) {
                        $obj_asiento
                            ->setIdComprobante($new_registro)
                            ->setIdTipoComprobante($new_registro->getIdTipoComprobante());
                        $em->persist($obj_asiento);
                    }
                }
        }

        $em->flush();
        return $this->render('contabilidad/general/comprobante_venta/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}