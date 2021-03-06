<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ComprobanteAnotacionesController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/comprobante-anotaciones")
 */
class ComprobanteAnotacionesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_comprobante_anotaciones")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {

        return $this->render('contabilidad/inventario/comprobante_anotaciones/index.html.twig', [
            'datos' => $this->getData($request, $em),
            'controller_name' => 'ComprobanteAnotacionesController',
        ]);
    }

    public function getData($request, $em)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen,
            'activo' => true
        ));
        foreach ($arr_obj_documentos as $obj_documento) {
            $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
            /**@var $obj_documento Documento* */
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            //informe recepcion mercancia
            if ($id_tipo_documento == 1) {
                $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_informe);
            } //informe recepcion producto
            elseif ($id_tipo_documento == 2) {

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
                $rows = array_merge($rows, []);
            }//devolucion
            elseif ($id_tipo_documento == 9) {
                $datos_devolucion = AuxFunctions::getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_devolucion);
            }//Apertura
            elseif ($id_tipo_documento == 12) {
                $datos_devolucion = AuxFunctions::getDataApertura($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_devolucion);
            }//Servicios
            elseif ($id_tipo_documento == 13) {
                $datos_devolucion = AuxFunctions::getDataApertura($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_devolucion);
            }
        }
        return $rows;
    }

    public function getDataEntrada($request, $em)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen
        ));

        foreach ($arr_obj_documentos as $obj_documento) {
            $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
            /**@var $obj_documento Documento* */
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            //informe recepcion mercancia
            if ($id_tipo_documento == 1) {
                if(!$obj_documento->getIdDocumentoCancelado()){
                    $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                }
            } //informe recepcion producto
            elseif ($id_tipo_documento == 2) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_informe = AuxFunctions::getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                }
            } //Ajuste de entrada
            elseif ($id_tipo_documento == 3) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_ajuste_entreada = AuxFunctions::getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_entreada);
                }
            } //Ajuste de salida
            elseif ($id_tipo_documento == 4) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_ajuste_salida = AuxFunctions::getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_salida);
                }
            } //transferencia de entrada
            elseif ($id_tipo_documento == 5) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_transferencia_entrada = AuxFunctions::getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia_entrada);
                }
            } //transferencia de salida
            elseif ($id_tipo_documento == 6) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_transferencia = AuxFunctions::getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia);
                }
            } //vale salida de mercancia
            elseif ($id_tipo_documento == 7) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_vale = AuxFunctions::getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_vale);
                }
            } //vale salida de producto
            elseif ($id_tipo_documento == 8) {
                //  $rows = array_merge($rows, []);
            }//devolucion
            elseif ($id_tipo_documento == 9) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_devolucion = AuxFunctions::getDataDevolucion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_devolucion);
                }
            }//Factura
            elseif ($id_tipo_documento == 10) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_venta = AuxFunctions::getDataVentaCancelada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_venta);
                }
            }//Apertura mercancia
            elseif ($id_tipo_documento == 12) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_venta = AuxFunctions::getDataApertura($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_venta);
                }
            }//Apertura Producto
            elseif ($id_tipo_documento == 13) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_venta = AuxFunctions::getDataAperturaProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_venta);
                }
            }
        }
        return $rows;
    }

    public function getDataSalida($request, $em)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen' => $id_almacen,
        ));
        foreach ($arr_obj_documentos as $obj_documento) {
            $cod_almacen = $obj_documento->getIdAlmacen()->getCodigo();
            /**@var $obj_documento Documento* */
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            //informe recepcion mercancia
            if ($id_tipo_documento == 1) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_informe = AuxFunctions::getDataInformeRecepcion($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                }
            } //informe recepcion producto
            elseif ($id_tipo_documento == 2) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_informe = AuxFunctions::getDataInformeRecepcionProducto($em, $cod_almacen, $obj_documento, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_informe);
                }
            } //Ajuste de entrada
            elseif ($id_tipo_documento == 3) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_ajuste_entreada = AuxFunctions::getDataAjusteEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_entreada);
                }
            } //Ajuste de salida
            elseif ($id_tipo_documento == 4) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_ajuste_salida = AuxFunctions::getDataAjusteSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_ajuste_salida);
                }
            } //transferencia de entrada
            elseif ($id_tipo_documento == 5) {
                if ($obj_documento->getIdDocumentoCancelado()) {
                    $datos_transferencia_entrada = AuxFunctions::getDataTransferenciaEntrada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia_entrada);
                }
            } //transferencia de salida
            elseif ($id_tipo_documento == 6) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_transferencia = AuxFunctions::getDataTransferenciaSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_transferencia);
                }
            } //vale salida de mercancia
            elseif ($id_tipo_documento == 7) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_vale = AuxFunctions::getDataValeSalida($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_vale);
                }

            }//Factura
            elseif ($id_tipo_documento == 10) {
                if(!$obj_documento->getIdDocumentoCancelado()) {
                    $datos_venta = AuxFunctions::getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento);
                    $rows = array_merge($rows, $datos_venta);
                }
            }
        }
        return $rows;
    }

    /**
     * @Route("/entrada/print", name="contabilidad_inventario_comprobante_anotaciones_print_entrada")
     */
    public function printEntrada(Request $request, EntityManagerInterface $em, PaginatorInterface $pagination)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $almacen_obj */
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);

        $rows = $this->getDataEntrada($request, $em);
        $total = 0;
        foreach ($rows as $d) {
            if (isset($d['total'])) {
                $total += floatval($d['total']);
            }
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => 'TOTAL',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '', 'analisis_3' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total
        );
        $paginator = $pagination->paginate(
            $rows,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/inventario/comprobante_anotaciones/print.html.twig', [
            'datos' => $paginator,
            'almacen' => $almacen_obj->getCodigo() . ': ' . $almacen_obj->getDescripcion(),
            'unidad' => $almacen_obj->getIdUnidad()->getCodigo() . ': ' . $almacen_obj->getIdUnidad()->getNombre(),
            'estado' => ' de Entrada'
        ]);
    }

    /**
     * @Route("/salida/print", name="contabilidad_inventario_comprobante_anotaciones_print_salida")
     */
    public function printSalida(Request $request, EntityManagerInterface $em, PaginatorInterface $pagination)
    {
        $rows = $this->getDataSalida($request, $em);
        $total = 0;
        foreach ($rows as $d) {
            if (isset($d['total'])) {
                $total += floatval($d['total']);
            }
        }
        $rows[] = array(
            'nro_doc' => '',
            'fecha' => '',
            'nro_cuenta' => 'TOTAL',
            'nro_subcuenta' => '',
            'analisis_1' => '',
            'analisis_2' => '', 'analisis_3' => '',
            'debito' => number_format($total, 2),
            'credito' => number_format($total, 2),
            'total' => $total
        );

        $paginator = $pagination->paginate(
            $rows,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        //dd($total);

        $id_almacen = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $almacen_obj */
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        return $this->render('contabilidad/inventario/comprobante_anotaciones/print.html.twig', [
            'datos' => $paginator,
            'almacen' => $almacen_obj->getCodigo() . ': ' . $almacen_obj->getDescripcion(),
            'unidad' => $almacen_obj->getIdUnidad()->getCodigo() . ': ' . $almacen_obj->getIdUnidad()->getNombre(),
            'estado' => ' de Salida'
        ]);
    }
}
