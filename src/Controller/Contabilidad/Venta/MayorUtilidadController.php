<?php

namespace App\Controller\Contabilidad\Venta;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\Contabilidad\Venta\MovimientoVenta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MayorUtilidadController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/productos-con-mayor-utilidad")
 */
class MayorUtilidadController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_mayor_utilidad")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $anno = $request->get('anno') != '' ? $request->get('anno') : Date('Y');
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $movimientos_ventas_arr = $em->getRepository(MovimientoVenta::class)->findBy([
            'anno' => $anno,
            'activo' => true,
        ]);
        $mercancias = [];
        $productos = [];
        $tipos_clientes = [];
        /** @var MovimientoVenta $movimiento_venta */
        foreach ($movimientos_ventas_arr as $movimiento_venta) {
            $tipo = $movimiento_venta->getMercancia();
            $codigo = $movimiento_venta->getCodigo();
            $id_almacen = $movimiento_venta->getIdAlmacen()->getId();
            $combo = $tipo . '->' . $codigo . '->' . $id_almacen;
            if (!in_array($combo, $tipos_clientes)) {
                $tipos_clientes[count($tipos_clientes)] = $combo;
            }
        }
        foreach ($tipos_clientes as $tipo_cliente) {
            $explode = explode('->', $tipo_cliente);
            $tipo = $explode[0];
            $codigo = $explode[1];
            $id_almacen = $explode[2];;
            $cant_facturas = 0;
            $cant_productos = 0;
            $importe_total = 0;
            $costo_total = 0;
            /** @var MovimientoVenta $movimiento_venta */
            foreach ($movimientos_ventas_arr as $movimiento_venta) {
                if ($movimiento_venta->getCodigo() == $codigo && $movimiento_venta->getMercancia() == $tipo && $movimiento_venta->getIdAlmacen()->getId() == $id_almacen) {
                    $cant_facturas++;
                    $importe_total += (floatval($movimiento_venta->getCantidad()) * floatval($movimiento_venta->getPrecio()));
                    $costo_total += (floatval($movimiento_venta->getCantidad()) * floatval($movimiento_venta->getCosto()));
                    $cant_productos += floatval($movimiento_venta->getCantidad());

                }
            }

            if ($tipo == 1) {
                $mercancias[] = array(
                    'codigo' => $codigo,
                    'cant_facturas' => $cant_facturas,
                    'importe' => number_format($importe_total, 2),
                    'costo' => number_format($costo_total, 2),
                    'utilidades' => number_format(($importe_total-$costo_total), 2),
                    'utilidades_value' => ($importe_total-$costo_total),
                    'cant_productos' => $cant_productos,
                    'nombre' => $mercancia_er->findOneBy([
                        'id_amlacen' => $id_almacen,
                        'codigo' => $codigo
                    ])->getDescripcion()
                );
            } else {
                $productos[] = array(
                    'codigo' => $codigo,
                    'cant_facturas' => $cant_facturas,
                    'importe' => number_format($importe_total, 2),
                    'costo' => number_format($costo_total, 2),
                    'utilidades' => number_format(($importe_total-$costo_total), 2),
                    'utilidades_value' => ($importe_total-$costo_total),
                    'cant_productos' => $cant_productos,
                    'nombre' => $producto_er->findOneBy([
                        'id_amlacen' => $id_almacen,
                        'codigo' => $codigo
                    ])->getDescripcion()
                );
            }
        }

        AuxFunctions::array_sort_by($productos, 'utilidades_value', $order = SORT_DESC);
        AuxFunctions::array_sort_by($mercancias, 'utilidades_value', $order = SORT_DESC);
        return $this->render('contabilidad/venta/mayor_utilidad/index.html.twig', [
            'controller_name' => 'PrincipalesClientesController',
            'productos' => $productos,
            'mercancias' => $mercancias,
            'cant_productos'=>count($productos),
            'cant_mercancias'=>count($mercancias),
        ]);
    }


}
