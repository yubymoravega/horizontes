<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class ComprobanteOperacionesController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/comprobante-operaciones")
 */
class ComprobanteOperacionesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_comprobante_operaciones")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $obj_almacen */
        $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
        /** @var Unidad $obj_unidad */
        $obj_unidad = $obj_almacen->getIdUnidad();
        $cierre_er = $em->getRepository(Cierre::class);
        $nombre_almacen = $request->getSession()->get('selected_almacen/name');
        /** @var Almacen $almacen_obj */
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $nombre_unidad = $almacen_obj->getIdUnidad()->getNombre();

        $registro_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_tipo_comprobante' => $em->getRepository(TipoComprobante::class)->find(2),
            'id_unidad' => $obj_unidad
        ));

        if (empty($registro_operaciones)) {
            //recorro todos los cierres para formar el arreglo de operaciones
            $anno = Date('Y');
        } else {
            /** @var RegistroComprobantes $ultimo */
            $j = count($registro_operaciones);
            $ultimo = $registro_operaciones[$j - 1];
            $fecha_ultimo_registro = $ultimo->getFecha();
            $anno = $ultimo->getAnno();
        }

        //obtengo todos los cierres diarios del anno
        $obj_cierre_abierto = $cierre_er->findBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => false,
            'anno' => $anno,
            'diario' => true
        ));

        $row = [];
        /** @var Cierre $cierre */
        foreach ($obj_cierre_abierto as $cierre) {
            if (!empty($registro_operaciones)) {
                if ($cierre->getFecha() > $fecha_ultimo_registro) {
                    $fecha = $cierre->getFecha();
                    $row = array_merge($row, $this->getData($request, $em, $fecha));
                }
            } else {
                $fecha = $cierre->getFecha();
                $row = array_merge($row, $this->getData($request, $em, $fecha));
            }
        }
        if (!empty($obj_cierre_abierto)) {
            $i = count($obj_cierre_abierto);
            $fecha_cierre = $obj_cierre_abierto[$i - 1]->getFecha();
            return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen' => $nombre_almacen,
                'unidad' => $nombre_unidad,
                'fecha' => $fecha_cierre->format('d-m-Y'),
                'datos' => $row
            ]);
        } else {
            return $this->render('contabilidad/inventario/comprobante_operaciones/error.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen' => $nombre_almacen,
                'unidad' => $nombre_unidad,
                'title' => '!!Error',
                'message' => 'No existen cierres realizados en el almacén.'
            ]);
        }


    }

    public function getData($request, $em, $fecha)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
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
            if ($id_tipo_documento == 1) {
                //informe recepcion mercancia
                $obj_informe = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'producto' => false
                ));
                /**@var $obj_informe InformeRecepcion* */
                $nro_doc = 'IRM' . '-' . $obj_informe->getNroConcecutivo();
                $nro_cuenta_deudora = $obj_informe->getNroCuentaInventario();
                $nro_subcuenta_deudora = $obj_informe->getNroSubcuentaInventario();
                $nro_cuenta_acreedora = $obj_informe->getNroCuentaAcreedora();
                $nro_subcuenta_acreedora = $obj_informe->getNroSubcuentaAcreedora();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
                $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
                $cod_proveedor = $obj_informe->getIdProveedor()->getCodigo();
                $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                    'id_documento' => $obj_documento,
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
                ));
                $total = 0;
                //totalizar importe
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    $total += floatval($obj_movimiento_mercancia->getImporte());
                }
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $nro_cuenta_deudora,
                    'nro_subcuenta' => $nro_subcuenta_deudora,
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($total, 2),
                    'credito' => ''
                );
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $nro_cuenta_acreedora,
                    'nro_subcuenta' => $nro_subcuenta_acreedora,
                    'analisis_1' => $cod_proveedor,
                    'analisis_2' => '',
                    'debito' => '',
                    'credito' => number_format($total, 2)
                );
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'debito' => number_format($total, 2),
                    'credito' => number_format($total, 2)
                );
            } elseif ($id_tipo_documento == 2) {
                //informe recepcion producto
                $obj_informe = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'producto' => true
                ));
                /**@var $obj_informe InformeRecepcion* */
                $nro_doc = 'IRP' . '-' . $obj_informe->getNroConcecutivo();
                $nro_cuenta_deudora = $obj_informe->getNroCuentaInventario();
                $nro_subcuenta_deudora = $obj_informe->getNroSubcuentaInventario();
                $nro_cuenta_acreedora = $obj_informe->getNroCuentaAcreedora();
                $nro_subcuenta_acreedora = $obj_informe->getNroSubcuentaAcreedora();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
                $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
                $cod_proveedor = $obj_informe->getIdProveedor()->getCodigo();
                $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                    'id_documento' => $obj_documento,
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
                ));
                $total = 0;
                //totalizar importe
                foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                    /**@var $obj_movimiento_mercancia MovimientoMercancia */
                    $total += floatval($obj_movimiento_mercancia->getImporte());
                }
                $rows[] = array(
                    'nro_doc' => $nro_doc,
                    'fecha' => $fecha_doc,
                    'nro_cuenta' => $nro_cuenta_deudora,
                    'nro_subcuenta' => $nro_subcuenta_deudora,
                    'analisis_1' => $cod_almacen,
                    'analisis_2' => '',
                    'debito' => number_format($total, 2),
                    'credito' => ''
                );
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => $nro_cuenta_acreedora,
                    'nro_subcuenta' => $nro_subcuenta_acreedora,
                    'analisis_1' => $cod_proveedor,
                    'analisis_2' => '',
                    'debito' => '',
                    'credito' => number_format($total, 2)
                );
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'debito' => number_format($total, 2),
                    'credito' => number_format($total, 2)
                );
            } elseif ($id_tipo_documento == 3) {
                //ajuste de entrada
                $obj_informe = $em->getRepository(Ajuste::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => true
                ));
                /**@var $obj_informe Ajuste* */
                $nro_doc = 'AJE' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            } elseif ($id_tipo_documento == 4) {
                //Ajuste de salida
                $obj_informe = $em->getRepository(Ajuste::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => false
                ));
                /**@var $obj_informe Ajuste* */
                $nro_doc = 'AJS' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            } elseif ($id_tipo_documento == 5) {
                //transferencia de entrada
                $obj_informe = $em->getRepository(Transferencia::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => true
                ));
                /**@var $obj_informe Transferencia* */
                $nro_doc = 'TE' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            } elseif ($id_tipo_documento == 6) {
                //transferencia de salida
                $obj_informe = $em->getRepository(Transferencia::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => false
                ));
                /**@var $obj_informe Transferencia* */
                $nro_doc = 'TS' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            } elseif ($id_tipo_documento == 7) {
                //vale salida de mercancia
                $obj_informe = $em->getRepository(ValeSalida::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'producto' => false
                ));
                /**@var $obj_informe ValeSalida* */
                $nro_doc = 'VSM' . '-' . $obj_informe->getNroConsecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

                $arr_obj_movimiento_mercancia = $movimiento_mercancia_er->findBy(array(
                    'id_documento' => $obj_documento,
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
                ));
                //totalizar importe
                $rep_arr = [];
                $i = 0;
                $total_general = 0;
                foreach ($arr_obj_movimiento_mercancia as $d) {
                    $cc = $d->getIdCentroCosto()->getId() . '-' . $d->getIdElementoGasto()->getId();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                            /**@var $obj_movimiento_mercancia MovimientoMercancia */
                            if ($obj_movimiento_mercancia->getIdCentroCosto()->getId() == $d->getIdCentroCosto()->getId() &&
                                $obj_movimiento_mercancia->getIdElementoGasto()->getId() == $d->getIdElementoGasto()->getId())
                                $total += floatval($obj_movimiento_mercancia->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => $i == 1 ? $nro_doc : '',
                            'fecha' => $i == 1 ? $fecha_doc : '',
                            'nro_cuenta' => $obj_informe->getNroCuentaDeudora(),
                            'nro_subcuenta' => $obj_informe->getNroSubcuentaDeudora(),
                            'analisis_1' => $d->getIdCentroCosto()->getCodigo(),
                            'analisis_2' => $d->getIdElementoGasto()->getCodigo(),
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                        $total_general += $total;
                    }
                }

                $i = 0;
                foreach ($arr_obj_movimiento_mercancia as $d) {
                    /** @var  $d  MovimientoMercancia */
                    $cc = $d->getIdMercancia()->getCuenta() . '-' . $d->getIdMercancia()->getNroSubcuentaInventario();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_mercancia as $obj_movimiento_mercancia) {
                            /**@var $obj_movimiento_mercancia MovimientoMercancia */
                            if ($obj_movimiento_mercancia->getIdMercancia()->getNroCuentaAcreedora() == $d->getIdMercancia()->getNroCuentaAcreedora() &&
                                $obj_movimiento_mercancia->getIdMercancia()->getNroSubcuentaAcreedora() == $d->getIdMercancia()->getNroSubcuentaAcreedora())
                                $total += floatval($obj_movimiento_mercancia->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => '',
                            'fecha' => '',
                            'nro_cuenta' => $d->getIdMercancia()->getCuenta(),
                            'nro_subcuenta' => $d->getIdMercancia()->getNroSubcuentaInventario(),
                            'analisis_1' => $obj_informe->getIdDocumento()->getIdAlmacen()->getCodigo(),
                            'analisis_2' => '',
                            'debito' => '',
                            'credito' => number_format($total, 2)
                        );
                    }
                }

                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'debito' => number_format($total_general, 2),
                    'credito' => number_format($total_general, 2)
                );
            } elseif ($id_tipo_documento == 8) {
                //vale salida de producto
                $obj_informe = $em->getRepository(ValeSalida::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'producto' => true
                ));
                /**@var $obj_informe ValeSalida* */
                $nro_doc = 'VSP' . '-' . $obj_informe->getNroConsecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');

                $arr_obj_movimiento_producto = $movimiento_producto_er->findBy(array(
                    'id_documento' => $obj_documento,
                    'id_tipo_documento' => $em->getRepository(TipoDocumento::class)->find($id_tipo_documento)
                ));
                //totalizar importe
                $rep_arr = [];
                $i = 0;
                $total_general = 0;
                foreach ($arr_obj_movimiento_producto as $d) {
                    $cc = $d->getIdCentroCosto()->getId() . '-' . $d->getIdElementoGasto()->getId();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_producto as $obj_movimiento_producto) {
                            /**@var $obj_movimiento_producto MovimientoProducto */
                            if ($obj_movimiento_producto->getIdCentroCosto()->getId() == $d->getIdCentroCosto()->getId() &&
                                $obj_movimiento_producto->getIdElementoGasto()->getId() == $d->getIdElementoGasto()->getId())
                                $total += floatval($obj_movimiento_producto->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => $i == 1 ? $nro_doc : '',
                            'fecha' => $i == 1 ? $fecha_doc : '',
                            'nro_cuenta' => $obj_informe->getNroCuentaDeudora(),
                            'nro_subcuenta' => $obj_informe->getNroSubcuentaDeudora(),
                            'analisis_1' => $d->getIdCentroCosto()->getCodigo(),
                            'analisis_2' => $d->getIdElementoGasto()->getCodigo(),
                            'debito' => number_format($total, 2),
                            'credito' => ''
                        );
                        $total_general += $total;
                    }
                }

                $i = 0;
                foreach ($arr_obj_movimiento_producto as $d) {
                    $cc = $d->getIdMercancia()->getNroCuentaAcreedora() . '-' . $d->getIdMercancia()->getNroSubcuentaAcreedora();
                    if (!in_array($cc, $rep_arr)) {
                        $rep_arr[$i] = $cc;
                        $i++;
                        $total = 0;
                        foreach ($arr_obj_movimiento_producto as $obj_movimiento_producto) {
                            /**@var $obj_movimiento_producto MovimientoProducto */
                            if ($obj_movimiento_producto->getIdProducto()->getNroCuentaAcreedora() == $d->getIdMercancia()->getNroCuentaAcreedora() &&
                                $obj_movimiento_producto->getIdProducto()->getNroSubcuentaAcreedora() == $d->getIdMercancia()->getNroSubcuentaAcreedora())
                                $total += floatval($obj_movimiento_producto->getImporte());
                        }
                        $rows[] = array(
                            'nro_doc' => '',
                            'fecha' => '',
                            'nro_cuenta' => $d->getIdMercancia()->getNroCuentaAcreedora(),
                            'nro_subcuenta' => $d->getIdMercancia()->getNroSubcuentaAcreedora(),
                            'analisis_1' => $obj_informe->getIdDocumento()->getIdAlmacen()->getCodigo(),
                            'analisis_2' => '',
                            'debito' => '',
                            'credito' => number_format($total, 2)
                        );
                    }
                }

                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'debito' => number_format($total_general, 2),
                    'credito' => number_format($total_general, 2)
                );
            }
            $retur_rows [] = array(
                'nro_doc' => $nro_doc,
                'datos' => $rows
            );
            $rows = [];
        }
        return !empty($retur_rows) ? $retur_rows : [];
    }

    /**
     * @Route("/save", name="contabilidad_inventario_comprobante_operaciones_guardar")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $cierre_er = $em->getRepository(Cierre::class);
        $fecha = $request->get('fecha');
        $observacion = $request->get('observacion');
        $usuario = $this->getUser();
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $obj_almacen */
        $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
        /** @var Unidad $obj_unidad */
        $obj_unidad = $obj_almacen->getIdUnidad();
        /** @var TipoComprobante $tipo_comprobante */
        $tipo_comprobante = $em->getRepository(TipoComprobante::class)->find(2);

        /** @var Cierre $obj_cierre */
        $obj_cierre = $cierre_er->findOneBy(array(
            'id_almacen' => $obj_almacen,
            'abierto' => false,
            'fecha' => \DateTime::createFromFormat('d-m-Y', $fecha),
        ));
        if ($obj_cierre) {
            $debito = $obj_cierre->getDebito();
            $credito = $obj_cierre->getCredito();
            $arr = explode('-', $fecha);
            $anno = $arr[2];

            /** @var RegistroComprobantes $duplicate */
            $duplicate = $em->getRepository(RegistroComprobantes::class)->findOneBy(array(
                'anno' => $anno,
                'fecha' => \DateTime::createFromFormat('d-m-Y', $fecha),
                'id_tipo_comprobante' => $tipo_comprobante,
                'id_unidad' => $obj_unidad
            ));
            if ($duplicate) {
                return $this->render('contabilidad/inventario/comprobante_operaciones/error.html.twig', [
                    'controller_name' => 'ComprobanteOperacionesController',
                    'title' => '!!Error duplicado',
                    'message' => 'Ya existe un comprobante de operaciones registrado para la fecha seleccionada, su numero es ' . $duplicate->getNroConsecutivo() . '/' . $duplicate->getAnno() . ' .'
                ]);
            }
            $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                'id_unidad' => $obj_unidad,
                'anno' => $anno
            ));
            $nro_consecutivo = count($arr_registros) + 1;

            $new_registro = new RegistroComprobantes();
            $new_registro
                ->setDescripcion($observacion)
                ->setIdUsuario($usuario)
                ->setFecha(\DateTime::createFromFormat('d-m-Y', $fecha))
                ->setAnno($anno)
                ->setCredito($credito)
                ->setDebito($debito)
                ->setIdAlmacen($obj_almacen)
                ->setIdTipoComprobante($tipo_comprobante)
                ->setIdUnidad($obj_unidad)
                ->setNroConsecutivo($nro_consecutivo);
            $em->persist($new_registro);
            $em->flush();
        }
        return $this->render('contabilidad/inventario/comprobante_operaciones/error.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $nro_consecutivo . '/' . $anno . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}
