<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
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
        $debito = 0;
        $credito = 0;
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
            $debito += floatval($cierre->getDebito());
            $credito += floatval($cierre->getCredito());
        }

        if (!empty($obj_cierre_abierto)) {
            $i = count($obj_cierre_abierto);
            $fecha_cierre = $obj_cierre_abierto[$i - 1]->getFecha();
            return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen' => $nombre_almacen,
                'unidad' => $nombre_unidad,
                'fecha' => $fecha_cierre->format('d-m-Y'),
                'datos' => $row,
                'total_debito'=>$debito,
                'total_credito'=>$credito
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

    /**
     * @Route("/save", name="contabilidad_inventario_comprobante_operaciones_guardar")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $cierre_er = $em->getRepository(Cierre::class);
        $fecha = $request->get('fecha');
        $observacion = $request->get('observacion');
        $debito = $request->get('debito');
        $credito = $request->get('credito');
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
        return $this->render('contabilidad/inventario/comprobante_operaciones/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' .$new_registro->getIdTipoComprobante()->getAbreviatura().'-'. $nro_consecutivo .', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}
