<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoComprobante;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use App\Entity\Contabilidad\General\Asiento;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\ComprobanteCierre;
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
        $nombre_unidad = $obj_almacen->getIdUnidad()->getNombre();

        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha = explode('-', $fecha);
        $year_ = intval($arr_fecha[0]);

        $registro_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_tipo_comprobante' => $em->getRepository(TipoComprobante::class)->find(2),
            'id_unidad' => $obj_unidad,
            'anno' => $year_,
            'id_almacen' => $obj_almacen
        ));

        $arr_cierre = $cierre_er->findBy(array(
            'id_almacen' => $obj_almacen,
            'abierto' => false,
            'anno' => $year_,
            'diario' => true
        ));
        $row = [];
        $debito = 0;
        $credito = 0;

        if (!empty($registro_operaciones)) {
            /** @var RegistroComprobantes $obj_comprobante */
            $obj_comprobante = $registro_operaciones[count($registro_operaciones) - 1];
            $last_id_cierre = 0;

            $arr_registro_cierre = $em->getRepository(ComprobanteCierre::class)->findBy(['id_comprobante' => $obj_comprobante]);
            if (!empty($arr_registro_cierre)) {
                /** @var ComprobanteCierre $registro_cierre */
                foreach ($arr_registro_cierre as $registro_cierre) {
                    if ($registro_cierre->getIdCierre()->getId() > $last_id_cierre)
                        $last_id_cierre = $registro_cierre->getIdCierre()->getId();
                }
            }
            if (!empty($arr_cierre)) {
                /** @var Cierre $cierre */
                foreach ($arr_cierre as $cierre) {
                    if ($cierre->getId() > $last_id_cierre) {
                        $row = array_merge($row, $this->getData($request, $em, $cierre->getFecha()));
                    }
                }
            }
        } else {
            foreach ($arr_cierre as $cierre) {
                $row = array_merge($row, $this->getData($request, $em, $cierre->getFecha()));
            }
        }

        foreach ($row as $d) {
            $arr = explode(',', $d['datos'][count($d['datos']) - 1]['debito']);
            if (count($arr) > 1)
                $debito += floatval($arr[0]) * 1000 + floatval($arr[1]);
            else
                $debito += floatval($d['datos'][count($d['datos']) - 1]['debito']);
            $arr_ = explode(',', $d['datos'][count($d['datos']) - 1]['credito']);
            if (count($arr_) > 1)
                $credito += floatval($arr_[0]) * 1000 + floatval($arr_[1]);
            else
                $credito += floatval($d['datos'][count($d['datos']) - 1]['credito']);
        }

        if (!empty($arr_cierre)) {
            $i = count($arr_cierre);
            $fecha_cierre = $arr_cierre[$i - 1]->getFecha();
            return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'almacen' => $nombre_almacen,
                'unidad' => $nombre_unidad,
                'fecha' => $fecha_cierre->format('d-m-Y'),
                'datos' => $row,
                'total_debito' => number_format($debito, 2),
                'total_credito' => number_format($credito, 2),
                'debito' => $debito,
                'credito' => $credito
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
            }//ventas
            elseif ($id_tipo_documento == 10) {
                $datos_venta = AuxFunctions::getDataVenta($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_venta);
                $datos_venta_cancelada = AuxFunctions::getDataVentaCancelada($em, $cod_almacen, $obj_documento, $movimiento_mercancia_er, $movimiento_producto_er, $id_tipo_documento);
                $rows = array_merge($rows, $datos_venta_cancelada);
            }
            $retur_rows [] = array(
                'nro_doc' => $rows[0]['nro_doc'],
                'datos' => $rows
            );
            $rows = [];
        }
        return !empty($retur_rows) ? $retur_rows : [];
    }

    public function getDocumentos(EntityManagerInterface $em, $obj_almacen, $fecha)
    {
        $documentos = $em->getRepository(Documento::class)->findBy([
            'id_almacen' => $obj_almacen,
            'fecha' => $fecha
        ]);
        $row = [];
        foreach ($documentos as $d) {
            $row[]=$d->getId();
        }
        return $row;
    }

    /**
     * @Route("/save", name="contabilidad_inventario_comprobante_operaciones_guardar")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        /** @var Almacen $obj_almacen */
        $obj_almacen = $em->getRepository(Almacen::class)->find($id_almacen);
        /** @var Unidad $obj_unidad */
        $obj_unidad = $obj_almacen->getIdUnidad();
        $cierre_er = $em->getRepository(Cierre::class);

        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha = explode('-', $fecha);
        $year_ = intval($arr_fecha[0]);

        $registro_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_tipo_comprobante' => $em->getRepository(TipoComprobante::class)->find(2),
            'id_unidad' => $obj_unidad,
            'anno' => $year_,
            'id_almacen' => $obj_almacen
        ));

        $arr_cierre = $cierre_er->findBy(array(
            'id_almacen' => $obj_almacen,
            'abierto' => false,
            'anno' => $year_,
            'diario' => true
        ));
        $row = [];

        if (!empty($registro_operaciones)) {
            /** @var RegistroComprobantes $obj_comprobante */
            $obj_comprobante = $registro_operaciones[count($registro_operaciones) - 1];
            $last_id_cierre = 0;

            $arr_registro_cierre = $em->getRepository(ComprobanteCierre::class)->findBy(['id_comprobante' => $obj_comprobante]);
            if (!empty($arr_registro_cierre)) {
                /** @var ComprobanteCierre $registro_cierre */
                foreach ($arr_registro_cierre as $registro_cierre) {
                    if ($registro_cierre->getIdCierre()->getId() > $last_id_cierre)
                        $last_id_cierre = $registro_cierre->getIdCierre()->getId();
                }
            }
            if (!empty($arr_cierre)) {
                /** @var Cierre $cierre */
                foreach ($arr_cierre as $cierre) {
                    if ($cierre->getId() > $last_id_cierre) {
                        $row = array_merge($row, $this->getDocumentos($em, $obj_almacen, $cierre->getFecha()));
                    }
                }
            }
        } else {
            foreach ($arr_cierre as $cierre) {
                $row = array_merge($row, $this->getDocumentos($em, $obj_almacen, $cierre->getFecha()));
            }
        }

        $observacion = $request->get('observacion');
        $debito = $request->get('debito');
        $credito = $request->get('credito');
        
        $fecha = AuxFunctions::getDateToClose($em, $id_almacen);
        $arr_fecha = explode('-', $fecha);
        $year_ = intval($arr_fecha[0]);

        $registro_operaciones = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_tipo_comprobante' => $em->getRepository(TipoComprobante::class)->find(2),
            'id_unidad' => $obj_unidad,
            'anno' => $year_,
            'id_almacen' => $obj_almacen
        ));

        $arr_registros = $em->getRepository(RegistroComprobantes::class)->findBy(array(
            'id_unidad' => $obj_unidad,
            'anno' => $year_
        ));
        $nro_consecutivo = count($arr_registros) + 1;

        $new_registro = new RegistroComprobantes();
        $new_registro
            ->setDescripcion($observacion)
            ->setIdUsuario($this->getUser())
            ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha))
            ->setAnno($year_)
            ->setTipo(AuxFunctions::$COMMPROBANTE_OPERACONES_INVENTARIO)
            ->setCredito(floatval($credito))
            ->setDebito(floatval($debito))
            ->setIdAlmacen($obj_almacen)
            ->setIdTipoComprobante($em->getRepository(TipoComprobante::class)->find(2))
            ->setIdUnidad($obj_unidad)
            ->setNroConsecutivo($nro_consecutivo);
        $em->persist($new_registro);

        /**
         * actualizando datos de asiento
        */
        $asiento_er = $em->getRepository(Asiento::class);
        foreach ($row as $id_documento){
            $arr_asiento = $asiento_er->findBy([
                'id_documento'=>$id_documento,
                'id_almacen'=>$obj_almacen
            ]);
            foreach ($arr_asiento as $obj_asiento){
                if($obj_asiento){
                    $obj_asiento
                        ->setIdComprobante($new_registro)
                        ->setIdTipoComprobante($new_registro->getIdTipoComprobante());
                    $em->persist($obj_asiento);
                }
            }
        }

        $arr_cierre = $cierre_er->findBy(array(
            'abierto' => false,
            'id_almacen' => $obj_almacen,
            'anno' => $year_,
            'diario' => true
        ));

        if (empty($arr_cierre))
            return $this->render('contabilidad/inventario/comprobante_operaciones/success.html.twig', [
                'controller_name' => 'ComprobanteOperacionesController',
                'title' => '!!Error',
                'message' => 'No existen cierres registrados, para generar el comprobante de operaciones debe cerrar primero las operaciones del día'
            ]);

        if (!empty($registro_operaciones)) {
            /** @var RegistroComprobantes $obj_comprobante */
            $obj_comprobante = $registro_operaciones[count($registro_operaciones) - 1];
            $last_id_cierre = 0;

            $arr_registro_cierre = $em->getRepository(ComprobanteCierre::class)->findBy(['id_comprobante' => $obj_comprobante]);
            if (!empty($arr_registro_cierre)) {
                /** @var ComprobanteCierre $registro_cierre */
                foreach ($arr_registro_cierre as $registro_cierre) {
                    if ($registro_cierre->getIdCierre()->getId() > $last_id_cierre)
                        $last_id_cierre = $registro_cierre->getIdCierre()->getId();
                }
            }
            if (!empty($arr_cierre)) {
                /** @var Cierre $cierre */
                foreach ($arr_cierre as $cierre) {
                    if ($cierre->getId() > $last_id_cierre) {
                        //adiciono en la relacion
                        $comprobante_cierre = new ComprobanteCierre();
                        $comprobante_cierre
                            ->setIdCierre($cierre)
                            ->setIdComprobante($new_registro);
                        $em->persist($comprobante_cierre);
                    }
                }
            }
        } else {
            foreach ($arr_cierre as $cierre) {
                //adiciono en la relacion
                $comprobante_cierre = new ComprobanteCierre();
                $comprobante_cierre
                    ->setIdCierre($cierre)
                    ->setIdComprobante($new_registro);
                $em->persist($comprobante_cierre);
            }
        }
        $em->flush();
        return $this->render('contabilidad/inventario/comprobante_operaciones/success.html.twig', [
            'controller_name' => 'ComprobanteOperacionesController',
            'title' => '!!Exito',
            'message' => 'Comprobante de operaciones generado satisfactoriamente, su nro es ' . $new_registro->getIdTipoComprobante()->getAbreviatura() . '-' . $nro_consecutivo . ', para ver detalles consulte el registro de comprobantes .'
        ]);
    }
}
