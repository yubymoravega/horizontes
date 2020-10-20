<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistroComprobantesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/registro-comprobantes")
 */
class RegistroComprobantesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_registro_comprobantes")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {

        return $this->render('contabilidad/general/registro_comprobantes/index.html.twig', [
            'controller_name' => 'RegistroComprobantesController',
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
            $obj_unidad = $empleado->getIdUnidad();
            $comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                'anno' => Date('Y'),
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
                    'debito' => $comp->getDebito(),
                    'credito' => $comp->getCredito(),
                    'usuario' => $obj_empleado->getNombre(),
                    'almacen' => $comp->getIdAlmacen()->getCodigo() . '-' . $comp->getIdAlmacen()->getDescripcion()
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
    public function getDetalles(EntityManagerInterface $em, Request $request,$id)
    {
        /** @var RegistroComprobantes $registro_obj */
        $registro_obj = $em->getRepository(RegistroComprobantes::class)->find($id);

        /** @var Almacen $obj_almacen */
        $obj_almacen = $registro_obj->getIdAlmacen();
        /** @var Unidad $obj_unidad */
        $obj_unidad = $obj_almacen->getIdUnidad();
        $cierre_er = $em->getRepository(Cierre::class);
        $nombre_almacen = $registro_obj->getIdAlmacen()->getDescripcion();
        $nombre_unidad = $obj_unidad->getNombre();

        $fecha_ultimo_registro = $registro_obj->getFecha();
        $anno = $registro_obj->getAnno();


        //obtengo todos los cierres diarios del anno
        $obj_cierre_arr = $cierre_er->findBy(array(
            'id_almacen' => $obj_almacen,
            'abierto' => false,
            'anno' => $anno,
            'diario' => true
        ));

        $row = [];
        $debito = 0;
        $credito = 0;

        //obtener la fecha del comprobante anterior para rrecorrer todos los cierres abarcados por el comporbante actual e imprimirlos
        $comprobante_anterior = $em->getRepository(RegistroComprobantes::class)->find($registro_obj->getId() - 1);
        if ($comprobante_anterior)
            $fecha_inicio = $comprobante_anterior->getFecha();
        /** @var Cierre $cierre */
        foreach ($obj_cierre_arr as $cierre) {
            if (!$comprobante_anterior) {
                if ($cierre->getFecha() <= $fecha_ultimo_registro) {
                    $row = array_merge($row, $this->getDataDetalles($request, $em,  $cierre->getFecha(),$obj_almacen));
                }
                $debito += floatval($cierre->getDebito());
                $credito += floatval($cierre->getCredito());
            } else {
                if ($cierre->getFecha() >= $fecha_inicio && $cierre->getFecha() <= $fecha_ultimo_registro) {
                    $row = array_merge($row, $this->getDataDetalles($request, $em,  $cierre->getFecha(),$obj_almacen));
                }
                $debito += floatval($cierre->getDebito());
                $credito += floatval($cierre->getCredito());
            }
        }

        return $this->render('contabilidad/general/registro_comprobantes/detalle_registro.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'almacen' => $nombre_almacen,
            'observacion'=>$registro_obj->getDescripcion(),
            'unidad' => $nombre_unidad,
            'fecha' => $fecha_ultimo_registro->format('d-m-Y'),
            'datos' => $row,
            'total_debito' => $debito,
            'total_credito' => $credito
        ]);


    }

    public function getDataDetalles($request, $em, $fecha,$id_almacen)
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
            }
            $retur_rows [] = array(
                'nro_doc' => $rows[0]['nro_doc'],
                'datos' => $rows
            );
            $rows = [];
        }
        return !empty($retur_rows) ? $retur_rows : [];
    }

}
