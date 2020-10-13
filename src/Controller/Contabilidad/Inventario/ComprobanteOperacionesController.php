<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(EntityManagerInterface $em,Request $request)
    {
        $cierre_er = $em->getRepository(Cierre::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $nombre_almacen = $request->getSession()->get('selected_almacen/name');
        /** @var Almacen $almacen_obj */
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $nombre_unidad = $almacen_obj->getIdUnidad()->getNombre();

        $obj_cierre_abierto = $cierre_er->findOneBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => true,
        ));
        if($obj_cierre_abierto){
            $fecha = $obj_cierre_abierto->getFecha()->format('d-m-Y');
            return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen'=>$nombre_almacen,
                'unidad'=>$nombre_unidad,
                'fecha'=>$fecha,
                'datos' => $this->getData($request,$em,)
            ]);
        }
        else{
            return $this->render('contabilidad/inventario/comprobante_operaciones/error.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen'=>$nombre_almacen,
                'unidad'=>$nombre_unidad,
                'message'=>'No existen cierres realizados en el almacén.'
            ]);
        }

    }

    public function getData($request, $em){
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen,
            'activo' => true,
//            'fecha'=>$fecha
        ));
        foreach ($arr_obj_documentos as $obj_documento) {
            /**@var $obj_documento Documento**/
            $nro_doc ='';
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
            }
            elseif ($id_tipo_documento == 2) {
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
                    'debito' => number_format($total,2),
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
                    'credito' => number_format($total,2)
                );
                $rows[] = array(
                    'nro_doc' => '',
                    'fecha' => '',
                    'nro_cuenta' => '',
                    'nro_subcuenta' => '',
                    'analisis_1' => '',
                    'analisis_2' => '',
                    'debito' => number_format($total,2),
                    'credito' => number_format($total,2)
                );
            }
            elseif ($id_tipo_documento == 3) {
                //ajuste de entrada
                $obj_informe = $em->getRepository(Ajuste::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => true
                ));
                /**@var $obj_informe Ajuste* */
                $nro_doc = 'AJE' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            }
            elseif ($id_tipo_documento == 4)
            {
                //Ajuste de salida
                $obj_informe = $em->getRepository(Ajuste::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => false
                ));
                /**@var $obj_informe Ajuste* */
                $nro_doc = 'AJS' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            }
            elseif ($id_tipo_documento == 5) {
                //transferencia de entrada
                $obj_informe = $em->getRepository(Transferencia::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => true
                ));
                /**@var $obj_informe Transferencia* */
                $nro_doc = 'TE' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            }
            elseif ($id_tipo_documento == 6) {
                //transferencia de salida
                $obj_informe = $em->getRepository(Transferencia::class)->findOneBy(array(
                    'id_documento' => $obj_documento,
                    'entrada' => false
                ));
                /**@var $obj_informe Transferencia* */
                $nro_doc = 'TS' . '-' . $obj_informe->getNroConcecutivo();
                $fecha_doc = $obj_documento->getFecha()->format('d/m/Y');
            }
            elseif ($id_tipo_documento == 7) {
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
                $total_general=0;
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
                            'debito' => number_format($total,2),
                            'credito' => ''
                        );
                        $total_general += $total;
                    }
                }

                $i = 0;
                foreach ($arr_obj_movimiento_mercancia as $d) {
                    /** @var  $d  MovimientoMercancia*/
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
                            'credito' => number_format($total,2)
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
                    'debito' => number_format($total_general,2),
                    'credito' => number_format($total_general,2)
                );
            }
            elseif ($id_tipo_documento == 8) {
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
                $total_general=0;
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
                            'debito' => number_format($total,2),
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
                            'credito' => number_format($total,2)
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
                    'debito' => number_format($total_general,2),
                    'credito' => number_format($total_general,2)
                );
            }
            $retur_rows [] = array(
                'nro_doc' => $nro_doc,
                'datos'=>$rows
            );
            $rows = [];
        }
        return !empty($retur_rows)?$retur_rows:[];
    }
}
