<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Repository\Contabilidad\Config\AlmacenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InventarioComprobanteAnotacionesSalidaController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/inventario-comprobante-anotaciones-salida")
 */
class InventarioComprobanteAnotacionesSalidaController extends ControllerContabilidadReport
{
    /**
     * @Route("/contabilidad/reportes/inventario/comprobante/anotaciones/salida", name="contabilidad_reportes_inventario_comprobante_anotaciones_salida")
     */
    public function index(EntityManagerInterface $em, AlmacenRepository $almacenRepository)
    {
        $alamcenes = $almacenRepository->findBy(['id_unidad' => AuxFunctions::getUnidad($em, $this->getUser())]);
        return $this->render('contabilidad/reportes/inventario_comprobante_anotaciones_salida/index.html.twig', [
            'controller_name' => 'InventarioComprobanteAnotacionesSalidaController',
            'almacenes' => $alamcenes
        ]);
    }

    public function getDataSalida($request, $em,$id_almacen)
    {
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
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
     * @Route("/print/{id}", name="contabilidad_reportes_inventario_comprobante_anotaciones_print_salida")
     */
    public function printSalida(Request $request, EntityManagerInterface $em, PaginatorInterface $pagination,$id)
    {
        $rows = $this->getDataSalida($request, $em,$id);
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

        /** @var Almacen $almacen_obj */
        $almacen_obj = $em->getRepository(Almacen::class)->find($id);
        return $this->render('contabilidad/inventario/comprobante_anotaciones/print.html.twig', [
            'datos' => $paginator,
            'almacen' => $almacen_obj->getCodigo() . ': ' . $almacen_obj->getDescripcion(),
            'unidad' => $almacen_obj->getIdUnidad()->getCodigo() . ': ' . $almacen_obj->getIdUnidad()->getNombre(),
            'estado' => ' de Salida'
        ]);
    }
}
