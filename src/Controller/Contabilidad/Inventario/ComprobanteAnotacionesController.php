<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
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

        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $documento_er = $em->getRepository(Documento::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];

        //1. Recorro todos los documentos del almacen
        $arr_obj_documentos = $documento_er->findBy(array(
            'id_almacen'=>$id_almacen,
            'activo'=>true
        ));
        foreach ($arr_obj_documentos as $obj_documento){
            /**@var $obj_documento Documento**/
            $id_tipo_documento = $obj_documento->getIdTipoDocumento()->getId();
            if ($id_tipo_documento ==1 || $id_tipo_documento ==2 ){
                //informe recepcion
            }
            elseif ($id_tipo_documento ==3 || $id_tipo_documento ==4){
                //ajuste
            }
            elseif ($id_tipo_documento ==5 || $id_tipo_documento ==6){
                //transferencia
            }
            elseif ($id_tipo_documento ==7 || $id_tipo_documento ==8){
                
            }
        }


//        $obj_mercancia = $mercancia_er->findOneBy(array(
//            'codigo' => $cod,
//            'id_amlacen' => $id_almacen
//        ));
//        if (!$obj_mercancia) {
//            $obj_producto = $producto_er->findOneBy(array(
//                'codigo' => $cod,
//                'id_amlacen' => $id_almacen
//            ));
//            if (!$obj_producto)
//                $msg = "No se encontró ningun producto con el código introducido";
//            else {
//                //imprimo el producto
//                /**@var $obj_producto Producto* */
//                $descripcion_producto = $obj_producto->getDescripcion();
//                $um_producto = $obj_producto->getIdUnidadMedida()->getAbreviatura();
//
//                $arr_movimientos_producto = $movimiento_producto_er->findBy(array(
//                    'id_producto' => $obj_producto,
////                'fecha' => \DateTime::createFromFormat('Y-m-d', '2020-10-07')
//                ));
//                foreach ($arr_movimientos_producto as $obj_mivimiento) {
//                    /**@var $obj_mivimiento MovimientoProducto* */
//                    $rows [] = array(
//                        'fecha' => $obj_mivimiento->getFecha()->format('d/m/Y'),
//                        'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em,$obj_mivimiento->getIdDocumento()->getId(),$obj_mivimiento->getIdTipoDocumento()->getId()),
//                        'cant_entrada'=>$obj_mivimiento->getEntrada()?$obj_mivimiento->getCantidad():'',
//                        'importe_entrada'=>$obj_mivimiento->getEntrada()?$obj_mivimiento->getImporte():'',
//                        'cant_salida'=>$obj_mivimiento->getEntrada()?'':$obj_mivimiento->getCantidad(),
//                        'importe_salida'=>$obj_mivimiento->getEntrada()?'':$obj_mivimiento->getImporte(),
//                        'cant_existencia'=>$obj_mivimiento->getExistencia(),
//                        'importe_existencia'=>round(($obj_mivimiento->getExistencia()*($obj_mivimiento->getImporte()/$obj_mivimiento->getCantidad())),2)
//                    );
//                }
//            }
//        } else {
//            //imprimo la mercancia
//            /**@var $obj_mercancia Mercancia* */
//            $descripcion_producto = $obj_mercancia->getDescripcion();
//            $um_producto = $obj_mercancia->getIdUnidadMedida()->getAbreviatura();
//
//            $arr_movimientos_mercancia = $movimiento_mercancia_er->findBy(array(
//                'id_mercancia' => $obj_mercancia,
////                'fecha' => \DateTime::createFromFormat('Y-m-d', '2020-10-07')
//            ));
//            foreach ($arr_movimientos_mercancia as $obj_mivimiento) {
//                /**@var $obj_mivimiento MovimientoMercancia* */
//                $rows [] = array(
//                    'fecha' => $this->getFecha($em,$obj_mivimiento->getIdDocumento()->getId(),$obj_mivimiento->getIdTipoDocumento()->getId()),
//                    'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em,$obj_mivimiento->getIdDocumento()->getId(),$obj_mivimiento->getIdTipoDocumento()->getId()),
//                    'cant_entrada'=>$obj_mivimiento->getEntrada()?$obj_mivimiento->getCantidad():'',
//                    'importe_entrada'=>$obj_mivimiento->getEntrada()?$obj_mivimiento->getImporte():'',
//                    'cant_salida'=>$obj_mivimiento->getEntrada()?'':$obj_mivimiento->getCantidad(),
//                    'importe_salida'=>$obj_mivimiento->getEntrada()?'':$obj_mivimiento->getImporte(),
//                    'cant_existencia'=>$obj_mivimiento->getExistencia(),
//                    'importe_existencia'=>round(($obj_mivimiento->getExistencia()*($obj_mivimiento->getImporte()/$obj_mivimiento->getCantidad())),2)
//                );
//            }
//
//        }
//        return $this->render('contabilidad/inventario/submayor_inventario_producto/print.html.twig', [
//            'datos' => array(
//                'codigo_producto' => $cod,
//                'descripcion_producto' => $descripcion_producto,
//                'um_producto' => strtoupper($um_producto),
//                'codigo_unidad' => $codigo_unidad,
//                'nombre_unidad' => $nombre_unidad,
//                'nombre_almacen' => $nombre_almacen,
//                'cant_movimientos'=>count($rows)
//            ),
//            'movimientos' => $rows,
//        ]);
        return $this->render('contabilidad/inventario/comprobante_anotaciones/index.html.twig', [
            'movimientos' => $rows,
            'controller_name' => 'ComprobanteAnotacionesController',
        ]);
    }

    /**
     * @Route("/getProducto/{codigo}", name="contabilidad_inventario_submayor_inventario_producto_get", methods={"POST"})
     */
    public function getProducto(EntityManagerInterface $em, Request $request, $codigo)
    {
        $descripcion = '';
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $msg = 'Producto encontrado con éxito';
        $obj_mercancia = $mercancia_er->findOneBy(array(
            'codigo' => $codigo,
            'id_amlacen' => $id_almacen,
//            'activo'=>true
        ));
        if (!$obj_mercancia) {
            $obj_producto = $producto_er->findOneBy(array(
                'codigo' => $codigo,
                'id_amlacen' => $id_almacen
            ));
            if (!$obj_producto)
                $msg = "No se encontró ningun producto con el código introducido";
            else
                $descripcion = $obj_producto->getDescripcion();
        } else {
            $descripcion = $obj_mercancia->getDescripcion();
        }

        return new JsonResponse(['success' => true, 'descripcion' => $descripcion, 'msg' => $msg]);
    }
    public function getPrefijo($id)
    {
        $prefijo = '';
        switch ($id) {
            case 1:
                $prefijo = 'IRM';
                break;
            case 2:
                $prefijo = 'IRP';
                break;
            case 3:
                $prefijo = 'AE';
                break;
            case 4:
                $prefijo = 'AS';
                break;
            case 5:
                $prefijo = 'TE';
                break;
            case 6:
                $prefijo = 'TS';
                break;
            case 7:
                $prefijo = 'VSM';
                break;
            case 8:
                $prefijo = 'VSP';
                break;
            case 9:
                $prefijo = 'DEV';
                break;
        }
        return $prefijo;
    }

    public function getNroConsecutivo(EntityManagerInterface $em,$id_documento, $id_tipo_documento)
    {
        $consecutivo = '';
        if ($id_tipo_documento == 1 || $id_tipo_documento == 2){
            //informe de recepcion
            $inf_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $inf_recepcion ?$inf_recepcion->getNroConcecutivo():'-';
        }
        elseif ($id_tipo_documento == 3 || $id_tipo_documento == 4){
            //ajuste
            $ajuste = $em->getRepository(Ajuste::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $ajuste ?$ajuste->getNroConcecutivo():'-';
        }
        elseif ($id_tipo_documento == 5 || $id_tipo_documento == 6){
            //transferencia
            $transferencia = $em->getRepository(Transferencia::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $transferencia ?$transferencia->getNroConcecutivo():'-';
        }
        elseif ($id_tipo_documento == 7 || $id_tipo_documento == 8){
            //vale de salida
            $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $vale_salida ?$vale_salida->getNroConsecutivo():'-';
        }
        return 0;
    }

    public function getFecha(EntityManagerInterface $em,$id_documento, $id_tipo_documento)
    {
        if ($id_tipo_documento == 1 || $id_tipo_documento == 2){
            //informe de recepcion
            $inf_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $inf_recepcion ?$inf_recepcion->getFechaFactura()->format('d/m/Y'):'';
        }
        elseif ($id_tipo_documento == 3 || $id_tipo_documento == 4){
            //ajuste
            $ajuste = $em->getRepository(Ajuste::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            return $ajuste ?$ajuste->getFechaFactura()->format('d/m/Y'):'';
        }
        elseif ($id_tipo_documento == 5 || $id_tipo_documento == 6){
            //transferencia
            $documento = $em->getRepository(Documento::class)->find($id_documento);
            return $documento ?$documento->getFecha()->format('d/m/Y'):'';
        }
        elseif ($id_tipo_documento == 7 || $id_tipo_documento == 8){
            //vale de salida
            $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
                'id_documento'=>$id_documento
            ));
            /**@var $vale_salida ValeSalida*/
            return $vale_salida ?$vale_salida->getFechaSolicitud()->format('d/m/Y'):'';
        }
        return 0;
    }
}
