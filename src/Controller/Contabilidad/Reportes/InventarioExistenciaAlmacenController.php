<?php

namespace App\Controller\Contabilidad\Reportes;

use App\Controller\Contabilidad\ActivoFijo\ActivoFijoXCriterioController;
use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Producto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InventarioExistenciaAlmacenController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/inventario-existencia-almacen")
 */
class InventarioExistenciaAlmacenController extends ControllerContabilidadReport
{
     /**
     * @Route("/", name="contabilidad_reportes_inventario_existencia_almacen", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        return $this->render('contabilidad/reportes/inventario_existencia_almacen/index.html.twig', [
            'controller_name' => 'MercanciaController',
            'mercancias' => $this->getData($em,$request),
        ]);
    }

    public function getData($em,$request){
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array(
            'activo' => true
        ));
        $obj_unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $almacenes = $em->getRepository(Almacen::class)->findBy(['id_unidad'=>$obj_unidad,'activo'=>true]);
        $data= [];

        /** @var Almacen $obj_almacen */
        foreach ($almacenes as $obj_almacen){
            $row = [];
            foreach ($cuentas_arr as $cuenta) {
                $total_general = 0;
                /**@var $cuenta Cuenta * */
                $nro = $cuenta->getNroCuenta();
                $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
                    'id_cuenta' => $cuenta,
                    'activo' => true
                ));
                $row_data = [];
                /**@var $subcuenta Subcuenta */
                foreach ($arr_subcuentas as $subcuenta) {
                    $nro_subcuenta = $subcuenta->getNroSubcuenta();
                    $datos = $this->getDatosPorSubCuenta($em, $nro_subcuenta, $nro, $obj_almacen->getId());
                    if (!empty($datos['data'])) {
                        $row_data[] = array(
                            'subcuenta' => $nro_subcuenta . ' - ' . $subcuenta->getDescripcion(),
                            'existencia_subcuenta' => $datos['data'],
                            'total' => $datos['total']
                        );
                        $total_general += floatval($datos['total_count']);
                    }
                }

                // validar solo las subcuentas de la cuenta contiene mercancias
                if (!empty($row_data)) {
                    $row = [
                        'cuenta' => $nro . ' - ' . $cuenta->getNombre(),
                        'existencia' => $row_data,
                        'total' => number_format($total_general, 2)
                    ];
                }
            }
            $data[] = [
                'almacen'=>$obj_almacen->getCodigo().' - '.$obj_almacen->getDescripcion(),
                'data' => $row
            ];
        }
        return $data;
    }
    public function getDatosPorSubCuenta($em, $nro_subcuenta, $cuenta, $id_amlacen)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $total = 0;
        $mercancia_arr = $mercancia_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'nro_subcuenta_inventario' => $nro_subcuenta,
            'cuenta' => $cuenta
        ));
        $producto_arr = $producto_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'nro_subcuenta_inventario' => $nro_subcuenta,
            'cuenta' => $cuenta
        ));
        $row_mercancia = [];
        $row_producto = [];
        if (!empty($mercancia_arr)) {
            foreach ($mercancia_arr as $mercancia_obj) {
                if ($mercancia_obj->getExistencia() > 0)
                    $row_mercancia[] = array(
                        'codigo' => $mercancia_obj->getCodigo(),
                        'descripcion' => $mercancia_obj->getDescripcion(),
                        'unidad_medida' => strtoupper($mercancia_obj->getIdUnidadMedida()->getAbreviatura()),
                        'existencia' => $mercancia_obj->getExistencia(),
                        'precio' => number_format(($mercancia_obj->getImporte() / $mercancia_obj->getExistencia()), 5, '.', ''),
                        'importe' => number_format($mercancia_obj->getImporte(), 2)
                    );
                $total += floatval($mercancia_obj->getImporte());
            }
//            $total += floatval($mercancia_obj->getImporte());
        }
        if (!empty($producto_arr)) {
            foreach ($producto_arr as $producto_obj) {
                if ($producto_obj->getExistencia() > 0)
                    /**@var $producto_obj Producto* */
                    $row_producto[] = array(
                        'codigo' => $producto_obj->getCodigo(),
                        'descripcion' => $producto_obj->getDescripcion(),
                        'unidad_medida' => $producto_obj->getIdUnidadMedida()->getNombre(),
                        'existencia' => $producto_obj->getExistencia(),
                        'precio' => number_format(($producto_obj->getImporte() / $producto_obj->getExistencia()), 5, '.', ''),
                        'importe' => number_format($producto_obj->getImporte(), 2)
                    );
                $total += floatval($producto_obj->getImporte());
            }
        }

        $data = array_merge($row_mercancia, $row_producto);

        return ['data' => $data, 'total' => number_format($total, 2), 'total_count' => $total];
    }

    /**
     * @Route("/print",priority="1" , name="contabilidad_reportes_inventario_existencia_almacen_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        return $this->render('contabilidad/reportes/inventario_existencia_almacen/print.html.twig', [
            'controller_name' => 'MercanciaController',
            'mercancias' => $this->getData($em,$request),
            'unidad'=>$unidad->getCodigo().' - '.$unidad->getNombre()
        ]);
    }
}
