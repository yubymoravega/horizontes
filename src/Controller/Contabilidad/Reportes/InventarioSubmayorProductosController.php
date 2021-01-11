<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Ajuste;
use App\Entity\Contabilidad\Inventario\Devolucion;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Inventario\Transferencia;
use App\Entity\Contabilidad\Inventario\ValeSalida;
use App\Entity\Contabilidad\Venta\FacturaDocumento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InventarioSubmayorProductosController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/inventario-submayor-productos")
 */
class InventarioSubmayorProductosController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_reportes_inventario_submayor_productos")
     */
    public function index(EntityManagerInterface $em)
    {
        $arr_unidades = AuxFunctions::getUnidades($em, $this->getUser());
        $row_unidades = [];
        /** @var Unidad $item */
        foreach ($arr_unidades as $item) {
            $row_unidades[] = [
                'id' => $item->getId(),
                'codigo' => $item->getCodigo() . ' - ' . $item->getNombre(),
            ];
        }
        return $this->render('contabilidad/reportes/inventario_submayor_productos/index.html.twig', [
            'controller_name' => 'InventarioSubmayorProductosController',
            'unidades' => $row_unidades
        ]);
    }


    /**
     * @Route("/getProducto/{codigo_unidad}", name="reportes_inventario-submayor-productos_submayor_inventario_producto_get", methods={"POST"})
     */
    public function getProducto(EntityManagerInterface $em, Request $request, $codigo_unidad)
    {
        $arr = explode('->', $codigo_unidad);
        $codigo = $arr[0];
        $unidad_obj = $em->getRepository(Unidad::class)->find(intval($arr[1]));
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $unidad_obj, 'activo' => true]);
        $rows = [];

        /** @var Almacen $obj_almacen */
        foreach ($almacenes as $obj_almacen) {
            $id_almacen = $obj_almacen->getId();
            $mercancia_er = $em->getRepository(Mercancia::class);
            $producto_er = $em->getRepository(Producto::class);
            $query_mercancia = $mercancia_er->createQueryBuilder('p')
                ->where('p.codigo LIKE :word')
                ->andWhere('p.id_amlacen = :almacen')
                ->setParameter('word', '%' . $codigo . '%')
                ->setParameter('almacen', $id_almacen)
                ->getQuery();
            $result_mercancia = $query_mercancia->getResult();
            $query_producto = $producto_er->createQueryBuilder('p')
                ->where('p.codigo LIKE :word')
                ->andWhere('p.id_amlacen = :almacen')
                ->setParameter('word', '%' . $codigo . '%')
                ->setParameter('almacen', $id_almacen)
                ->getQuery();
            $result_producto = $query_producto->getResult();
//            $values = array_merge($result_producto, $result_mercancia);
            foreach ($result_producto as $key => $d) {
                $rows[] = [
                    'producto' => $d->getCodigo() . ' - ' . $d->getDescripcion(),
                    'almacen' => $obj_almacen->getCodigo() . ' - ' . $obj_almacen->getDescripcion(),
                    'id' => $d->getId(),
                    'tipo' => 'producto'
                ];
            }
            foreach ($result_mercancia as $key => $d) {
                $rows[] = [
                    'producto' => $d->getCodigo() . ' - ' . $d->getDescripcion(),
                    'almacen' => $obj_almacen->getCodigo() . ' - ' . $obj_almacen->getDescripcion(),
                    'id' => $d->getId() . '->mercancia',
                    'tipo' => 'mercancia'
                ];
            }
        }
        return new JsonResponse(['success' => true, 'data' => $rows]);
    }

    /**
     * @Route("/getProductosByDesc/{descripcion_unidad}", name="reportes_inventario-submayor-productos_submayor_inventario_producto_getproductosbydesc", methods={"POST"})
     */
    public function getProductosByDesc(EntityManagerInterface $em, Request $request, $descripcion_unidad)
    {
        $arr = explode('->', $descripcion_unidad);
        $descripcion = $arr[0];
        $unidad_obj = $em->getRepository(Unidad::class)->find(intval($arr[1]));
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad' => $unidad_obj, 'activo' => true]);
        $rows = [];

        /** @var Almacen $obj_almacen */
        foreach ($almacenes as $obj_almacen) {
            $id_almacen = $obj_almacen->getId();
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
//            $values = array_merge($result_producto, $result_mercancia);
            foreach ($result_producto as $key => $d) {
                $rows[] = [
                    'producto' => $d->getCodigo() . ' - ' . $d->getDescripcion(),
                    'almacen' => $obj_almacen->getCodigo() . ' - ' . $obj_almacen->getDescripcion(),
                    'id' => $d->getId() . '->producto',
                    'tipo' => 'producto'
                ];
            }
            foreach ($result_mercancia as $key => $d) {
                $rows[] = [
                    'producto' => $d->getCodigo() . ' - ' . $d->getDescripcion(),
                    'almacen' => $obj_almacen->getCodigo() . ' - ' . $obj_almacen->getDescripcion(),
                    'id' => $d->getId(),
                    'tipo' => 'mercancia'
                ];
            }
        }
        return new JsonResponse(['success' => true, 'data' => $rows]);
    }

    /**
     * @Route("/print/{data}", name="reportes_inventario-submayor-productos_submayor_print",methods={"GET"})
     */

    public function print(EntityManagerInterface $em, $data, Request $request)
    {
        $arr = explode('->', $data);
        $id = intval($arr[0]);
        $tipo = $arr[1];
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimiento_mercancia_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $almacen_er = $em->getRepository(Almacen::class);
//        $id_almacen = $request->getSession()->get('selected_almacen/id');
//        $obj_almacen = $almacen_er->find($id_almacen);
        $rows = [];
        if ($tipo == 'mercancia') {
            /** @var Mercancia $obj_mercancia */
            $obj_mercancia = $mercancia_er->find($id);
            if (!$obj_mercancia)
                $msg = "No se encontró ningun producto con el código introducido";

            $codigo_unidad = $obj_mercancia->getIdAmlacen()->getIdUnidad()->getCodigo();
            $nombre_unidad = $obj_mercancia->getIdAmlacen()->getIdUnidad()->getNombre();
            $nombre_almacen = $obj_mercancia->getIdAmlacen()->getCodigo().' - '.$obj_mercancia->getIdAmlacen()->getDescripcion();
            $cod = $obj_mercancia->getCodigo();
            $descripcion_producto = $obj_mercancia->getDescripcion();
            $um_producto = $obj_mercancia->getIdUnidadMedida()->getAbreviatura();
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

        } else {
            $obj_producto = $producto_er->find($id);
            if (!$obj_producto)
                $msg = "No se encontró ningun producto con el código introducido";
            else {
                //imprimo el producto
                /**@var $obj_producto Producto* */
                $descripcion_producto = $obj_producto->getDescripcion();
                $um_producto = $obj_producto->getIdUnidadMedida()->getAbreviatura();
                $codigo_unidad = $obj_producto->getIdAmlacen()->getIdUnidad()->getCodigo();
                $nombre_unidad = $obj_producto->getIdAmlacen()->getIdUnidad()->getNombre();
                $nombre_almacen = $obj_producto->getIdAmlacen()->getCodigo().' - '.$obj_producto->getIdAmlacen()->getDescripcion();
                $cod = $obj_producto->getCodigo();
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
                $msg = "No se encontró ningun producto con el código introducido";
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
        }
        return 0;
    }

    public function getFecha(EntityManagerInterface $em, $id_documento, $id_tipo_documento)
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
                $msg = "No se encontró ningun producto con el código introducido";
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
