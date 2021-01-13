<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Cliente;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\ComprobanteMovimientoActivoFijo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\OperacionesComprobanteOperaciones;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\General\FacturasComprobante;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\MovimientoServicio;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContabilidadRegistroComprobanteController extends ControllerContabilidadReport
{
    /**
     * @Route("/contabilidad/reportes/contabilidad-registro-comprobante", name="contabilidad_reportes_contabilidad_registro_comprobante")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        return $this->render('contabilidad/reportes/contabilidad_registro_comprobante/index.html.twig', [
            'controller_name' => 'ContabilidadRegistroComprobanteController',
            'registro' => $this->getData($em, $request)
        ]);
    }

    public function getData(EntityManagerInterface $em, Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $user
        ));
        $row = [];
        if ($empleado) {
            /** @var Unidad $obj_unidad */
//            $obj_unidad = $empleado->getIdUnidad();
            $obj_unidad = AuxFunctions::getUnidad($em, $user);
            $comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                'anno' => AuxFunctions::getCurrentYear($em, $obj_unidad),
                'id_unidad' => $obj_unidad
            ));
            /** @var RegistroComprobantes $comp */
            foreach ($comprobantes as $comp) {
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $comp->getIdUsuario()->getId()
                ));
                $row[] = array(
                    'id' => $comp->getId(),
                    'nro' => $comp->getNroConsecutivo(),
                    'tipo_comprobante' => $comp->getIdTipoComprobante()->getDescripcion(),
                    'abreviatura_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                    'descripcion' => $comp->getDescripcion(),
                    'fecha' => $comp->getFecha()->format('d-m-Y'),
                    'debito' => number_format($comp->getDebito(), 2),
                    'credito' => number_format($comp->getCredito(), 2),
                    'usuario' => $obj_empleado->getNombre(),
                    'almacen' => $comp->getIdAlmacen() ? $comp->getIdAlmacen()->getCodigo() . '-' . $comp->getIdAlmacen()->getDescripcion() : $comp->getIdUnidad()->getCodigo() . ' - ' . $comp->getIdUnidad()->getNombre()
                );
            }
        }
        return $row;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @Route("/print_registro", name="contabilidad_general_registro_comprobantes_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $id_user = $this->getUser()->getId();
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_user
        ));
        $codigo = $obj_empleado->getIdUnidad()->getCodigo();
        $nombre = $obj_empleado->getIdUnidad()->getNombre();
        return $this->render('contabilidad/general/registro_comprobantes/print.html.twig', [
            'datos' => $this->getData($em, $request),
            'unidad_nombre' => $nombre,
            'unidad_codigo' => $codigo
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @Route("/detalles/{id}", name="contabilidad_general_registro_comprobantes_detalles", methods={"GET"})
     */
    public function getDetalles(EntityManagerInterface $em, Request $request, $id)
    {
        /** @var RegistroComprobantes $registro_obj */
        $registro_obj = $em->getRepository(RegistroComprobantes::class)->find($id);

        /** @var Almacen $obj_almacen */
        $obj_almacen = $registro_obj->getIdAlmacen();
        /** @var Unidad $obj_unidad */
        $obj_unidad = $obj_almacen ? $obj_almacen->getIdUnidad() : AuxFunctions::getUnidad($em, $this->getUser());
        $cierre_er = $em->getRepository(Cierre::class);
        $nombre_almacen = $registro_obj->getIdAlmacen() ? $registro_obj->getIdAlmacen()->getDescripcion() : '';
        $nombre_unidad = $obj_unidad->getNombre();

        $row = [];
        //comprobante de operaciones de inventario
        if ($registro_obj->getTipo() == 1) {
            $cierres_por_comprobantes = $em->getRepository(ComprobanteCierre::class)->findBy(array(
                'id_comprobante' => $registro_obj
            ));
            /** @var ComprobanteCierre $comprobanteCierre */
            foreach ($cierres_por_comprobantes as $comprobanteCierre) {
                $row = array_merge($row, $this->getDataDetalles($request, $em, $comprobanteCierre->getIdCierre()->getFecha(), $obj_almacen));
            }
        } //comprobante de venta
        elseif ($registro_obj->getTipo() == 2) {
            $row = $this->getDataDetallesVenta($em, $registro_obj->getId(), $obj_unidad->getId());
        } //comprobante de operaciones de la contabilidad
        elseif ($registro_obj->getTipo() == AuxFunctions::COMMPROBANTE_OPERACONES_CONTABILIDAD) {
            $row = $this->getDataDetallesComprobanteOperaciones($em, $registro_obj->getId(), $obj_unidad->getId());
        } //depreciacion de activo fijo
        elseif ($registro_obj->getTipo() == AuxFunctions::COMMPROBANTE_OPERACONES_DEPRECIACIONACTIVO_FIJO) {
            $row = $this->getDataDetallesDepreciacion($em, $registro_obj->getId(), $obj_unidad->getId());
        } //comprobante de operaciones de activo fijo
        elseif ($registro_obj->getTipo() == AuxFunctions::COMMPROBANTE_OPERACONES_ACTIVO_FIJO) {
            $row = $this->getDataDetallesActivoFijo($em, $registro_obj->getId(), $obj_unidad->getId());
        }

        return $this->render('contabilidad/general/registro_comprobantes/detalle_registro.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'almacen' => $nombre_almacen,
            'observacion' => $registro_obj->getDescripcion(),
            'unidad' => $nombre_unidad,
            'fecha' => $registro_obj->getFecha()->format('d-m-Y'),
            'datos' => $row,
            'tipo' => $registro_obj->getTipo(),
            'total_debito' => number_format($registro_obj->getDebito(), 2),
            'total_credito' => number_format($registro_obj->getCredito(), 2),
        ]);
    }

    public function getDataDetalles($request, $em, $fecha, $id_almacen)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen,
            'activo' => true,
            'fecha' => $fecha
        ));
        foreach ($arr_obj_documentos as $obj_documento) {
            /**@var $obj_documento Documento* */
            $nro_doc = '';
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
            /**@var $obj_documento Documento* */
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            //informe recepcion mercancia
            if ($id_tipo_documento == 1) {
                $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_informe);
            } //informe recepcion producto
            elseif ($id_tipo_documento == 2) {
                $datos_informe = AuxFunctions::getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_informe);
            } //Ajuste de entrada
            elseif ($id_tipo_documento == 3) {
                $datos_ajuste_entreada = AuxFunctions::getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_ajuste_entreada);
            } //Ajuste de salida
            elseif ($id_tipo_documento == 4) {
                $datos_ajuste_salida = AuxFunctions::getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_ajuste_salida);
            } //transferencia de entrada
            elseif ($id_tipo_documento == 5) {
                $datos_transferencia_entrada = AuxFunctions::getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_transferencia_entrada);
            } //transferencia de salida
            elseif ($id_tipo_documento == 6) {
                $datos_transferencia = AuxFunctions::getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_transferencia);
            } //vale salida de mercancia
            elseif ($id_tipo_documento == 7) {
                $datos_vale = AuxFunctions::getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_vale);
            } //vale salida de producto
            elseif ($id_tipo_documento == 8) {

            }//devolucion
            elseif ($id_tipo_documento == 9) {
                $datos_devolucion = AuxFunctions::getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_devolucion);
            } elseif ($id_tipo_documento == 10) {
                $datos_venta = AuxFunctions::getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_venta);
            }
            $retur_rows [] = array(
                'nro_doc' => $rows[0]['nro_doc'],
                'datos' => $rows
            );
            $rows = [];
        }
        return !empty($retur_rows) ? $retur_rows : [];
    }

    public function getDataDetallesComprobanteOperaciones(EntityManagerInterface $em, $registro_id, $id_unidad)
    {
        $retur_rows = [];
        $registro = $em->getRepository(RegistroComprobantes::class)->find($registro_id);
        $arr_data_comprobante = $em->getRepository(OperacionesComprobanteOperaciones::class)->findBy([
            'id_registro_comprobantes' => $registro
        ]);
//        dd($registro);
        /** @var OperacionesComprobanteOperaciones $data */
        foreach ($arr_data_comprobante as $index => $data) {
            if ($index == 0)
                $retur_rows[] = [
                    'nro_doc' => $registro->getNroConsecutivo(),
                    'fecha' => $registro->getFecha()->format('d/m/Y'),
                    'nro_cuenta' => $data->getIdCuenta()->getNroCuenta(),
                    'nro_subcuenta' => $data->getIdSubcuenta()->getNroSubcuenta(),
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $registro->getFecha()->format('m'),
                    'anno' => $registro->getFecha()->format('Y'),
                    'debito' => number_format($data->getDebito(), 2),
                    'credito' => number_format($data->getCredito(), 2)
                ];
            else
                $retur_rows[] = [
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $data->getIdCuenta()->getNroCuenta(),
                    'nro_subcuenta' => $data->getIdSubcuenta()->getNroSubcuenta(),
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'analisis_3' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $registro->getFecha()->format('m'),
                    'anno' => $registro->getFecha()->format('Y'),
                    'debito' => number_format($data->getDebito(), 2),
                    'credito' => number_format($data->getCredito(), 2)
                ];
        }
        $data_return [] = array(
            'nro_doc' => $registro->getDocumento(),
            'datos' => $retur_rows
        );
        return $data_return;
    }

    public function getDataDetallesDepreciacion(EntityManagerInterface $em, $registro_id, $id_unidad)
    {
        $retur_rows = [];
        $registro = $em->getRepository(RegistroComprobantes::class)->find($registro_id);
        $arr_data_comprobante = $em->getRepository(Asiento::class)->findBy([
            'id_comprobante' => $registro
        ]);
        $total_debito = 0;
        $total_credito = 0;
        /** @var Asiento $data */
        foreach ($arr_data_comprobante as $index => $data) {
            $total_debito += $data->getDebito();
            $total_credito += $data->getCredito();

            if ($index == 0)
                $retur_rows[] = [
                    'nro_doc' => $registro->getNroConsecutivo(),
                    'fecha' => $registro->getFecha()->format('d/m/Y'),
                    'nro_cuenta' => $data->getIdCuenta()->getNroCuenta(),
                    'nro_subcuenta' => $data->getIdSubcuenta()->getNroSubcuenta(),
                    'analisis_1' => $data->getIdCentroCosto()?$data->getIdCentroCosto()->getCodigo():'',
                    'analisis_2' => $data->getIdElementoGasto()?$data->getIdElementoGasto()->getCodigo():'',
                    'analisis_3' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $registro->getFecha()->format('m'),
                    'anno' => $registro->getFecha()->format('Y'),
                    'debito' => number_format($data->getDebito(), 2),
                    'credito' => number_format($data->getCredito(), 2)
                ];
            else
                $retur_rows[] = [
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $data->getIdCuenta()->getNroCuenta(),
                    'nro_subcuenta' => $data->getIdSubcuenta()->getNroSubcuenta(),
                    'analisis_1' => $data->getIdCentroCosto()?$data->getIdCentroCosto()->getCodigo():'',
                    'analisis_2' => $data->getIdElementoGasto()?$data->getIdElementoGasto()->getCodigo():'',
                    'analisis_3' => '',
                    'value_1' => '',
                    'value_2' => '',
                    'value_3' => '',
                    'mes' => $registro->getFecha()->format('m'),
                    'anno' => $registro->getFecha()->format('Y'),
                    'debito' => number_format($data->getDebito(), 2),
                    'credito' => number_format($data->getCredito(), 2)
                ];
        }
        $retur_rows[] = [
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => '',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '',
            'analisis_3' => '',
            'value_1' => '',
            'value_2' => '',
            'value_3' => '',
            'mes' => '',
            'anno' => '',
            'debito' => number_format($total_debito, 2),
            'credito' => number_format($total_credito, 2)
        ];
        $data_return [] = array(
            'nro_doc' => $registro->getDocumento(),
            'datos' => $retur_rows
        );
        return $data_return;
    }

    public function getDataDetallesVenta(EntityManagerInterface $em, $registro_id, $id_unidad)
    {
        $data = $em->getRepository(FacturasComprobante::class)->findBy([
            'id_unidad' => $id_unidad,
            'id_comprobante' => $registro_id
        ]);
        $movimiento_venta_er = $em->getRepository(MovimientoVenta::class);
        /** @var Factura $factura */
        $total_debito = 0;
        $total_credito = 0;
        $cliente_extero = $em->getRepository(ClienteContabilidad::class);
        $cliente_interno = $em->getRepository(Unidad::class);
        $persona_natural = $em->getRepository(Cliente::class);
        /** @var FacturasComprobante $datafacturas */
        foreach ($data as $datafacturas) {
            $total_impuesto = 0;
            /** @var Factura $obj_factura */
            $factura = $datafacturas->getIdFactura();
            $row = [];
            $total_debito += $factura->getImporte();
            $mes = $factura->getFechaFactura()->format('m');
            $anno = $factura->getFechaFactura()->format('Y');
            $nro_doc = 'FACT-' . $factura->getNroFactura();
            /** Addiciono la factura con la cuenta de obligacion */
            if ($factura->getTipoCliente() == 1) {
                $cliente = $persona_natural->find($factura->getIdCliente())->getNombre();
            } elseif ($factura->getTipoCliente() == 2) {
                $cliente = $cliente_interno->find($factura->getIdCliente())->getCodigo();
            } elseif ($factura->getTipoCliente() == 3) {
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
                $arr_movimientos = $em->getRepository(MovimientoServicio::class)->findBy(['id_factura' => $factura]);
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
                $data_return [] = array(
                    'nro_doc' => $nro_doc,
                    'datos' => $row
                );
            } else {
                $fecha = $row[0]['fecha'];
                $reverse = array_reverse($row);
                $new_row = [];
                foreach ($reverse as $key => $item) {
                    if ($key > 0)
                        $new_row[] = [
                            'nro_doc' => $nro_doc,
                            'fecha' => $fecha,
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
                    'credito' => $row[0]['debito'],
                ];
                $data_return [] = array(
                    'nro_doc' => $nro_doc,
                    'datos' => $new_row
                );
            }
        }
//        dd($data_return);
        return $data_return;
    }

    public function getDataDetallesActivoFijo(EntityManagerInterface $em, $registro_id, $id_unidad)
    {
        $retur_rows = [];
        $registro = $em->getRepository(RegistroComprobantes::class)->find($registro_id);
        $arr_data_movimientos_comprobante = $em->getRepository(ComprobanteMovimientoActivoFijo::class)->findBy([
            'id_registro_comprobante' => $registro
        ]);

        $total = 0;

        if (!empty($arr_data_movimientos_comprobante)) {
            $cuenta_activo_er = $em->getRepository(ActivoFijoCuentas::class);
            /** @var ComprobanteMovimientoActivoFijo $data */
            foreach ($arr_data_movimientos_comprobante as $data) {
                $movimiento = $data->getIdMovimientoActivo();
                /** @var ActivoFijoCuentas $cuentas_activo_fijo */
                $cuentas_activo_fijo = $cuenta_activo_er->findOneBy(['id_activo' => $movimiento->getIdActivoFijo()]);
                $total += $movimiento->getIdActivoFijo()->getValorInicial();
                if ($movimiento->getEntrada()) {
                    $row[] = array(
                        'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                        'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                        'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                        'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => '',
                        'analisis_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                        'analisis_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                    );
                    if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                        $row[] = array(
                            'nro' => '',
                            'fecha' => '',
                            'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                            'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                            'debito' => '',
                            'credito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                            'analisis_1' => '',
                            'analisis_2' => ''
                        );
                    }
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                        'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                        'debito' => '',
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                        'analisis_1' => '',
                        'analisis_2' => ''
                    );
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'nro_cuenta' => '',
                        'nro_subcuenta' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'analisis_1' => '',
                        'analisis_2' => ''
                    );
                } else {
                    if ($movimiento->getIdTipoMovimiento()->getId() == 6)
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaGasto() ? $cuentas_activo_fijo->getIdCuentaGasto()->getNroCuenta() : '',
                            'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaGasto() ? $cuentas_activo_fijo->getIdSubcuentaGasto()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'analisis_1' => '',
                            'analisis_2' => ''
                        );
                    else if ($movimiento->getIdTipoMovimiento()->getId() == 3)
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaActivo() ? $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta() : '',
                            'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo() ? $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'analisis_1' => '',
                            'analisis_2' => ''
                        );
                    else
                        $row[] = array(
                            'nro' => $movimiento->getIdTipoMovimiento()->getCodigo() . '-' . $movimiento->getNroConsecutivo(),
                            'fecha' => $movimiento->getFecha()->format('d/m/Y'),
                            'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaAcreedora() ? $cuentas_activo_fijo->getIdCuentaAcreedora()->getNroCuenta() : '',
                            'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaAcreedora() ? $cuentas_activo_fijo->getIdSubcuentaAcreedora()->getNroSubcuenta() : '',
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getValorReal(), 2),
                            'analisis_1' => '',
                            'analisis_2' => ''
                        );
                    if ($movimiento->getIdActivoFijo()->getDepreciacionAcumulada() > 0) {
                        $row[] = array(
                            'nro' => '',
                            'fecha' => '',
                            'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaDepreciacion()->getNroCuenta(),
                            'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaDepreciacion()->getNroSubcuenta(),
                            'credito' => '',
                            'debito' => number_format($movimiento->getIdActivoFijo()->getDepreciacionAcumulada(), 2),
                            'analisis_1' => '',
                            'analisis_2' => ''
                        );
                    }
                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'nro_cuenta' => $cuentas_activo_fijo->getIdCuentaActivo()->getNroCuenta(),
                        'nro_subcuenta' => $cuentas_activo_fijo->getIdSubcuentaActivo()->getNroSubcuenta(),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'debito' => '',
                        'analisis_1' => $cuentas_activo_fijo->getIdCentroCostoActivo()->getCodigo(),
                        'analisis_2' => $cuentas_activo_fijo->getIdAreaResponsabilidadActivo()->getCodigo()
                    );

                    $row[] = array(
                        'nro' => '',
                        'fecha' => '',
                        'nro_cuenta' => '',
                        'nro_subcuenta' => '',
                        'debito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'credito' => number_format($movimiento->getIdActivoFijo()->getValorInicial(), 2),
                        'analisis_1' => '',
                        'analisis_2' => ''
                    );
                }

                $retur_rows [] = array(
                    'nro_doc' => $row[0]['nro'],
                    'datos' => $row
                );
                $row = [];
            }
        }

//        $data_return [] = array(
//            'nro_doc' => $registro->getDocumento(),
//            'datos' => $retur_rows
//        );
        return $retur_rows;
    }
}
