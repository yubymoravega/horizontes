<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Apertura;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Venta\Factura;
use App\Entity\Contabilidad\Venta\FacturaDocumento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubmayorInventarioProductoController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/submayor-inventario-producto")
 */
class SubmayorInventarioProductoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_submayor_inventario_producto", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $documentos_apertura = $em->getRepository(Documento::class)->findBy([
            'id_almacen'=>$em->getRepository(Almacen::class)->find($id_almacen),
            'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(12)
        ]);

        if(empty($documentos_apertura)){
            $documentos_apertura = $em->getRepository(Documento::class)->findBy([
                'id_almacen'=>$em->getRepository(Almacen::class)->find($id_almacen),
                'id_tipo_documento'=>$em->getRepository(TipoDocumento::class)->find(13)
            ]);
        }
        return $this->render('contabilidad/inventario/submayor_inventario_producto/index.html.twig', [
            'controller_name' => 'SubmayorInventarioProductoController',
            'apertura'=>empty($documentos_apertura)?true:false
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
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $msg = 'Producto encontrado con ??xito';
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
                $msg = "No se encontr?? ningun producto con el c??digo introducido";
            else
                $descripcion = $obj_producto->getDescripcion();
        } else {
            $descripcion = $obj_mercancia->getDescripcion();
        }

        return new JsonResponse(['success' => true, 'descripcion' => $descripcion, 'msg' => $msg]);
    }

    /**
     * @Route("/getProductosByDesc/{descripcion}", name="contabilidad_inventario_submayor_inventario_producto_getproductosbydesc", methods={"POST"})
     */
    public function getProductosByDesc(EntityManagerInterface $em, Request $request, $descripcion)
    {
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $query_mercancia = $mercancia_er->createQueryBuilder('p')
            ->where('p.descripcion LIKE :word')
            ->andWhere('p.id_amlacen = :almacen')
            ->setParameter('word', '%' . $descripcion . '%')
            ->setParameter('almacen', $id_almacen)
            ->getQuery();
        $result_mercancia = $query_mercancia->getResult();
        $query_producto = $producto_er->createQueryBuilder('p')
            ->where('p.descripcion LIKE :word')
            ->andWhere('p.id_amlacen = :almacen')
            ->setParameter('word', '%' . $descripcion . '%')
            ->setParameter('almacen', $id_almacen)
            ->getQuery();
        $result_producto = $query_producto->getResult();
        $values = array_merge($result_producto, $result_mercancia);
        $rows = [];
        foreach ($values as $key => $d) {
            $rows[$key] = $d->getCodigo() . ' - ' . $d->getDescripcion();
        }
        return new JsonResponse(['success' => true, 'data' => array_unique($rows)]);
    }

    /**
     * @Route("/print/{cod}", name="contabilidad_inventario_submayor_print",methods={"GET"})
     */

    public function print(EntityManagerInterface $em, $cod, Request $request)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $almacen_er = $em->getRepository(Almacen::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $obj_almacen = $almacen_er->find($id_almacen);
        $rows = [];
        $codigo_unidad = $obj_almacen->getIdUnidad()->getCodigo();
        $nombre_unidad = $obj_almacen->getIdUnidad()->getNombre();
        $nombre_almacen = $request->getSession()->get('selected_almacen/name');

        $obj_mercancia_arr = $mercancia_er->findBy(array(
            'codigo' => $cod,
            'id_amlacen' => $id_almacen
        ));
        if (empty($obj_mercancia_arr)) {
            $obj_producto = $producto_er->findOneBy(array(
                'codigo' => $cod,
                'id_amlacen' => $id_almacen
            ));
            if (!$obj_producto)
                $msg = "No se encontr?? ningun producto con el c??digo introducido";
            else {
                //imprimo el producto
                /**@var $obj_producto Producto* */
                $descripcion_producto = $obj_producto->getDescripcion();
                $um_producto = $obj_producto->getIdUnidadMedida()->getAbreviatura();

                $arr_movimientos_producto = $movimiento_producto_er->findBy(array(
                    'id_producto' => $obj_producto,
                ));
                $existencia_anterior = 0;
                $saldo_anterior = 0;
                /**@var $obj_mivimiento MovimientoProducto* */
                foreach ($arr_movimientos_producto as $key => $obj_mivimiento) {
                    $obj_documento = $obj_mivimiento->getIdDocumento();
                    if (!$obj_documento->getIdDocumentoCancelado()) {
                        $saldo_anterior = $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                        $existencia_anterior = $obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                    } else {
                        $saldo_anterior = !$obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                        $existencia_anterior = !$obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                    }

                    if (!$obj_documento->getIdDocumentoCancelado()) {
                        $rows [] = array(
                            'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                            'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                            'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                            'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                            'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                            'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                            'cant_existencia' => $existencia_anterior,
                            'importe_existencia' => number_format($saldo_anterior, 2)
                        );
                    } else {
                        $rows [] = array(
                            'fecha' => $obj_documento->getFecha()->format('d/m/Y'),
                            'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                            'cant_entrada' => !$obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                            'importe_entrada' => !$obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                            'cant_salida' => !$obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                            'importe_salida' => !$obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                            'cant_existencia' => $existencia_anterior,
                            'importe_existencia' => number_format($saldo_anterior, 2)
                        );
                    }

                }
            }
        }
        else {
            $descripcion_producto = $obj_mercancia_arr[0]->getDescripcion();
            $um_producto = $obj_mercancia_arr[0]->getIdUnidadMedida()->getAbreviatura();
            foreach ($obj_mercancia_arr as $obj_mercancia) {
                /**@var $obj_mercancia Mercancia* */
                $arr_movimientos_mercancia = $movimiento_mercancia_er->findBy(array(
                    'id_mercancia' => $obj_mercancia
                ));
                $existencia_anterior = 0;
                $saldo_anterior = 0;
                /**@var $obj_mivimiento MovimientoMercancia* */
                foreach ($arr_movimientos_mercancia as $key => $obj_mivimiento) {
                    /** @var Documento $obj_documento */
                    $obj_documento = $obj_mivimiento->getIdDocumento();
                    if (!$obj_documento->getIdDocumentoCancelado()) {
                        $saldo_anterior = $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                        $existencia_anterior = $obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                    } else {
                        $saldo_anterior = !$obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                        $existencia_anterior = !$obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                    }

                    if (!$obj_documento->getIdDocumentoCancelado()) {
                        $rows [] = array(
                            'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                            'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                            'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                            'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                            'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                            'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                            'cant_existencia' => $existencia_anterior,
                            'importe_existencia' => number_format($saldo_anterior, 2)
                        );
                    } else {
                        $rows [] = array(
                            'fecha' => $obj_documento->getFecha()->format('d/m/Y'),
                            'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                            'cant_entrada' => !$obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                            'importe_entrada' => !$obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                            'cant_salida' => !$obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                            'importe_salida' => !$obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                            'cant_existencia' => $existencia_anterior,
                            'importe_existencia' => number_format($saldo_anterior, 2)
                        );
                    }
                }
            }
        }
        return $this->render('contabilidad/inventario/submayor_inventario_producto/print.html.twig', [
            'datos' => array(
                'codigo_producto' => $cod,
                'descripcion_producto' => $descripcion_producto,
                'um_producto' => strtoupper($um_producto),
                'codigo_unidad' => $codigo_unidad,
                'nombre_unidad' => $nombre_unidad,
                'nombre_almacen' => $nombre_almacen,
                'cant_movimientos' => count($rows)
            ),
            'movimientos' => $rows,
        ]);
    }

    public function printOriginal1(EntityManagerInterface $em, $cod, Request $request)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $almacen_er = $em->getRepository(Almacen::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $obj_almacen = $almacen_er->find($id_almacen);
        $rows = [];
        $codigo_unidad = $obj_almacen->getIdUnidad()->getCodigo();
        $nombre_unidad = $obj_almacen->getIdUnidad()->getNombre();
        $nombre_almacen = $request->getSession()->get('selected_almacen/name');

        $obj_mercancia_arr = $mercancia_er->findBy(array(
            'codigo' => $cod,
            'id_amlacen' => $id_almacen
        ));
        if (empty($obj_mercancia_arr)) {
            $obj_producto = $producto_er->findOneBy(array(
                'codigo' => $cod,
                'id_amlacen' => $id_almacen
            ));
            if (!$obj_producto)
                $msg = "No se encontr?? ningun producto con el c??digo introducido";
            else {
                //imprimo el producto
                /**@var $obj_producto Producto* */
                $descripcion_producto = $obj_producto->getDescripcion();
                $um_producto = $obj_producto->getIdUnidadMedida()->getAbreviatura();

                $arr_movimientos_producto = $movimiento_producto_er->findBy(array(
                    'id_producto' => $obj_producto,
                ));
                $existencia_anterior = 0;
                $saldo_anterior = 0;
                foreach ($arr_movimientos_producto as $key => $obj_mivimiento) {
                    /**@var $obj_mivimiento MovimientoMercancia* */
                    if ($obj_mivimiento->getActivo()) {
                        if ($key == 0) {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                                'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                                'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                                'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $obj_mivimiento->getCantidad(),
                                'importe_existencia' => $obj_mivimiento->getEntrada() ? number_format(($saldo_anterior + $obj_mivimiento->getImporte()), 2) : number_format(($saldo_anterior - $obj_mivimiento->getImporte()), 2)
                            );
                        } else {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                                'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                                'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                                'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $obj_mivimiento->getEntrada() ? ($existencia_anterior + $obj_mivimiento->getCantidad()) : ($existencia_anterior - $obj_mivimiento->getCantidad()),
                                'importe_existencia' => $obj_mivimiento->getEntrada() ? number_format(($saldo_anterior + $obj_mivimiento->getImporte()), 2) : number_format(($saldo_anterior - $obj_mivimiento->getImporte()), 2)
                            );
                        }
                    } else {
                        if ($key == 0) {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getCantidad(),
                                'importe_entrada' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_salida' => $obj_mivimiento->getCantidad(),
                                'importe_salida' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => '0',
                                'importe_existencia' => '0.00'
                            );
                        } else {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getCantidad(),
                                'importe_entrada' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_salida' => $obj_mivimiento->getCantidad(),
                                'importe_salida' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $existencia_anterior,
                                'importe_existencia' => number_format($saldo_anterior, 2)
                            );
                        }
                    }
                    if ($key == 0) {
                        if (!$obj_mivimiento->getActivo()) {
                            $saldo_anterior = 0;
                            $existencia_anterior = 0;
                        } else {
                            $saldo_anterior = $obj_mivimiento->getImporte();
                            $existencia_anterior = $obj_mivimiento->getCantidad();
                        }
                    } else {
                        if (!$obj_mivimiento->getActivo()) {
//                            $saldo_anterior = $arr_movimientos_producto[$key - 1]->getImporte();
//                            $existencia_anterior = $arr_movimientos_producto[$key - 1]->getCantidad();
                        } else {
                            $saldo_anterior = $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                            $existencia_anterior = $obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                        }
                    }

                }
            }
        } else {
            $descripcion_producto = $obj_mercancia_arr[0]->getDescripcion();
            $um_producto = $obj_mercancia_arr[0]->getIdUnidadMedida()->getAbreviatura();
            foreach ($obj_mercancia_arr as $obj_mercancia) {
                /**@var $obj_mercancia Mercancia* */
                $arr_movimientos_mercancia = $movimiento_mercancia_er->findBy(array(
                    'id_mercancia' => $obj_mercancia
                ));
                $existencia_anterior = 0;
                $saldo_anterior = 0;
                foreach ($arr_movimientos_mercancia as $key => $obj_mivimiento) {
                    /**@var $obj_mivimiento MovimientoMercancia* */
                    if ($obj_mivimiento->getActivo()) {
                        if ($key == 0) {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                                'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                                'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                                'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $obj_mivimiento->getCantidad(),
                                'importe_existencia' => $obj_mivimiento->getEntrada() ? number_format(($saldo_anterior + $obj_mivimiento->getImporte()), 2) : number_format(($saldo_anterior - $obj_mivimiento->getImporte()), 2)
                            );
                        } else {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                                'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                                'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                                'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $obj_mivimiento->getEntrada() ? ($existencia_anterior + $obj_mivimiento->getCantidad()) : ($existencia_anterior - $obj_mivimiento->getCantidad()),
                                'importe_existencia' => $obj_mivimiento->getEntrada() ? number_format(($saldo_anterior + $obj_mivimiento->getImporte()), 2) : number_format(($saldo_anterior - $obj_mivimiento->getImporte()), 2)
                            );
                        }
                    } else {
                        if ($key == 0) {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getCantidad(),
                                'importe_entrada' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_salida' => $obj_mivimiento->getCantidad(),
                                'importe_salida' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => '0',
                                'importe_existencia' => '0.00'
                            );
                        } else {
                            $rows [] = array(
                                'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                                'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                                'cant_entrada' => $obj_mivimiento->getCantidad(),
                                'importe_entrada' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_salida' => $obj_mivimiento->getCantidad(),
                                'importe_salida' => number_format($obj_mivimiento->getImporte(), 2),
                                'cant_existencia' => $existencia_anterior,
                                'importe_existencia' => number_format($saldo_anterior, 2)
                            );
                        }
                    }
                    if ($key == 0) {
                        if (!$obj_mivimiento->getActivo()) {
                            $saldo_anterior = 0;
                            $existencia_anterior = 0;
                        } else {
                            $saldo_anterior = $obj_mivimiento->getImporte();
                            $existencia_anterior = $obj_mivimiento->getCantidad();
                        }
                    } else {
                        if (!$obj_mivimiento->getActivo()) {
//                            $saldo_anterior = $arr_movimientos_mercancia[$key - 1]->getImporte();
//                            $existencia_anterior = $arr_movimientos_mercancia[$key - 1]->getCantidad();
                        } else {
                            $saldo_anterior = $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
                            $existencia_anterior = $obj_mivimiento->getEntrada() ? $existencia_anterior + $obj_mivimiento->getCantidad() : $existencia_anterior - $obj_mivimiento->getCantidad();
                        }
                    }

                }
            }
        }
        return $this->render('contabilidad/inventario/submayor_inventario_producto/print.html.twig', [
            'datos' => array(
                'codigo_producto' => $cod,
                'descripcion_producto' => $descripcion_producto,
                'um_producto' => strtoupper($um_producto),
                'codigo_unidad' => $codigo_unidad,
                'nombre_unidad' => $nombre_unidad,
                'nombre_almacen' => $nombre_almacen,
                'cant_movimientos' => count($rows)
            ),
            'movimientos' => $rows,
        ]);
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
                $prefijo = 'D';
                break;
            case 10:
                $prefijo = 'FACT';
                break;
            case 11:
                $prefijo = 'DV';
                break;
            case 12:
                $prefijo = 'AP';
                break;
            case 13:
                $prefijo = 'APP';
                break;
        }
        return $prefijo;
    }

    public function getNroConsecutivo(EntityManagerInterface $em, $id_documento, $id_tipo_documento)
    {
        $consecutivo = '';
        if ($id_tipo_documento == 1 || $id_tipo_documento == 2) {
            //informe de recepcion
            $inf_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $inf_recepcion ? $inf_recepcion->getNroConcecutivo() : '-';
        } elseif ($id_tipo_documento == 3 || $id_tipo_documento == 4) {
            //ajuste
            $ajuste = $em->getRepository(Ajuste::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $ajuste ? $ajuste->getNroConcecutivo() : '-';
        } elseif ($id_tipo_documento == 5 || $id_tipo_documento == 6) {
            //transferencia
            $transferencia = $em->getRepository(Transferencia::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $transferencia ? $transferencia->getNroConcecutivo() : '-';
        } elseif ($id_tipo_documento == 7 || $id_tipo_documento == 8) {
            //vale de salida
            $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $vale_salida ? $vale_salida->getNroConsecutivo() : '-';
        } elseif ($id_tipo_documento == 9) {
            //devolucion
            $devolucion = $em->getRepository(Devolucion::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $devolucion ? $devolucion->getNroConcecutivo() : '-';
        } elseif ($id_tipo_documento == 10) {
            //Factura
            /** @var FacturaDocumento $factura_documento */
            $factura_documento = $em->getRepository(FacturaDocumento::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $factura_documento ? $factura_documento->getIdFactura()->getNroFactura() : '-';
        }elseif ($id_tipo_documento == 12) {
            //Factura
            /** @var Apertura $factura_documento */
            $factura_documento = $em->getRepository(Apertura::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $factura_documento ? $factura_documento->getNroConcecutivo() : '-';
        }elseif ($id_tipo_documento == 13) {
            //Factura
            /** @var Apertura $factura_documento */
            $factura_documento = $em->getRepository(Apertura::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $factura_documento ? $factura_documento->getNroConcecutivo() : '-';
        }
        return 0;
    }

    public
    function getFecha(EntityManagerInterface $em, $id_documento, $id_tipo_documento)
    {
        if ($id_tipo_documento == 1 || $id_tipo_documento == 2) {
            //informe de recepcion
            $inf_recepcion = $em->getRepository(InformeRecepcion::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $inf_recepcion ? $inf_recepcion->getFechaFactura()->format('d/m/Y') : '';
        } elseif ($id_tipo_documento == 3 || $id_tipo_documento == 4) {
            //ajuste
            /** @var Ajuste $ajuste */
            $ajuste = $em->getRepository(Ajuste::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            return $ajuste ? $ajuste->getIdDocumento()->getFecha()->format('d/m/Y') : '';
        } elseif ($id_tipo_documento == 5 || $id_tipo_documento == 6) {
            //transferencia
            $documento = $em->getRepository(Documento::class)->find($id_documento);
            return $documento ? $documento->getFecha()->format('d/m/Y') : '';
        } elseif ($id_tipo_documento == 7 || $id_tipo_documento == 8) {
            //vale de salida
            $vale_salida = $em->getRepository(ValeSalida::class)->findOneBy(array(
                'id_documento' => $id_documento
            ));
            /**@var $vale_salida ValeSalida */
            return $vale_salida ? $vale_salida->getFechaSolicitud()->format('d/m/Y') : '';
        }
        return 0;
    }

    public function printOriginal(EntityManagerInterface $em, $cod, Request $request)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $rows = [];
        $codigo_unidad = $em->getRepository(Almacen::class)->find($id_almacen)->getIdUnidad()->getCodigo();
        $nombre_unidad = $em->getRepository(Almacen::class)->find($id_almacen)->getIdUnidad()->getNombre();
        $nombre_almacen = $request->getSession()->get('selected_almacen/name');

        $obj_mercancia = $mercancia_er->findOneBy(array(
            'codigo' => $cod,
            'id_amlacen' => $id_almacen
        ));
        if (!$obj_mercancia) {
            $obj_producto = $producto_er->findOneBy(array(
                'codigo' => $cod,
                'id_amlacen' => $id_almacen
            ));
            if (!$obj_producto)
                $msg = "No se encontr?? ningun producto con el c??digo introducido";
            else {
                //imprimo el producto
                /**@var $obj_producto Producto* */
                $descripcion_producto = $obj_producto->getDescripcion();
                $um_producto = $obj_producto->getIdUnidadMedida()->getAbreviatura();

                $arr_movimientos_producto = $movimiento_producto_er->findBy(array(
                    'id_producto' => $obj_producto,
                    'activo' => true
//                'fecha' => \DateTime::createFromFormat('Y-m-d', '2020-10-07')
                ));
                foreach ($arr_movimientos_producto as $obj_mivimiento) {
                    /**@var $obj_mivimiento MovimientoProducto* */
                    $rows [] = array(
                        'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                        'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                        'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                        'importe_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getImporte() : '',
                        'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                        'importe_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getImporte(),
                        'cant_existencia' => $obj_mivimiento->getExistencia(),
                        'importe_existencia' => round(($obj_mivimiento->getExistencia() * ($obj_mivimiento->getImporte() / $obj_mivimiento->getCantidad())), 2)
                    );
                }
            }
        } else {
            //imprimo la mercancia
            /**@var $obj_mercancia Mercancia* */
            $descripcion_producto = $obj_mercancia->getDescripcion();
            $um_producto = $obj_mercancia->getIdUnidadMedida()->getAbreviatura();

            $arr_movimientos_mercancia = $movimiento_mercancia_er->findBy(array(
                'id_mercancia' => $obj_mercancia,
                'activo' => true
//                'fecha' => \DateTime::createFromFormat('Y-m-d', '2020-10-07')
            ));
            $existencia_anterior = 0;
            $saldo_anterior = 0;
            foreach ($arr_movimientos_mercancia as $key => $obj_mivimiento) {
                /**@var $obj_mivimiento MovimientoMercancia* */
                $rows [] = array(
                    'fecha' => $obj_mivimiento->getIdDocumento()->getFecha()->format('d/m/Y'),
                    'nro_documento' => $this->getPrefijo($obj_mivimiento->getIdTipoDocumento()->getId()) . '-' . $this->getNroConsecutivo($em, $obj_mivimiento->getIdDocumento()->getId(), $obj_mivimiento->getIdTipoDocumento()->getId()),
                    'cant_entrada' => $obj_mivimiento->getEntrada() ? $obj_mivimiento->getCantidad() : '',
                    'importe_entrada' => $obj_mivimiento->getEntrada() ? number_format($obj_mivimiento->getImporte(), 2) : '',
                    'cant_salida' => $obj_mivimiento->getEntrada() ? '' : $obj_mivimiento->getCantidad(),
                    'importe_salida' => $obj_mivimiento->getEntrada() ? '' : number_format($obj_mivimiento->getImporte(), 2),
                    'cant_existencia' => $obj_mivimiento->getExistencia(),
                    'importe_existencia' => $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte()
                );
                $saldo_anterior = $obj_mivimiento->getEntrada() ? $saldo_anterior + $obj_mivimiento->getImporte() : $saldo_anterior - $obj_mivimiento->getImporte();
            }
        }
        return $this->render('contabilidad/inventario/submayor_inventario_producto/print.html.twig', [
            'datos' => array(
                'codigo_producto' => $cod,
                'descripcion_producto' => $descripcion_producto,
                'um_producto' => strtoupper($um_producto),
                'codigo_unidad' => $codigo_unidad,
                'nombre_unidad' => $nombre_unidad,
                'nombre_almacen' => $nombre_almacen,
                'cant_movimientos' => count($rows)
            ),
            'movimientos' => $rows,
        ]);
    }

}
