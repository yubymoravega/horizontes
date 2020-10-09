<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\Producto;
use Doctrine\ORM\Query\Expr\Math;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class MercanciaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/existencia-almacen")
 */
class MercanciaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_mercancia",methods={"GET"})
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array(
            'activo' => true
        ));
        $id_almacen = $id_almacen = $request->getSession()->get('selected_almacen/id');
        $row = [];
        foreach ($cuentas_arr as $cuenta) {
            /**@var $cuenta Cuenta * */
            $nro = $cuenta->getNroCuenta();
            $datos = $this->getDatosPorCuenta($em, $nro, $id_almacen);
            if (!empty($datos['data']))
                $row[] = array(
                    'cuenta' => $nro . ' - ' . $cuenta->getNombre(),
                    'existencia' => $datos['data'],
                    'total' => $datos['total']
                );
        }
        return $this->render('contabilidad/inventario/mercancia/index.html.twig', [
            'controller_name' => 'MercanciaController',
            'mercancias' => $row
        ]);
    }

    public function getDatosPorCuenta($em, $nro_cuenta, $id_amlacen)
    {
        $mercancia_er = $em->getRepository(Mercancia::class);
        $producto_er = $em->getRepository(Producto::class);
        $total = 0;
        $mercancia_arr = $mercancia_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'cuenta' => $nro_cuenta
        ));
        $producto_arr = $producto_er->findBy(array(
            'activo' => true,
            'id_amlacen' => $id_amlacen,
            'cuenta' => $nro_cuenta
        ));
        $row_mercancia = [];
        $row_producto = [];
        if (!empty($mercancia_arr)) {
            foreach ($mercancia_arr as $mercancia_obj) {
                $row_mercancia[] = array(
                    'codigo' => $mercancia_obj->getCodigo(),
                    'descripcion' => $mercancia_obj->getDescripcion(),
                    'unidad_medida' =>strtoupper($mercancia_obj->getIdUnidadMedida()->getAbreviatura()) ,
                    'existencia' => $mercancia_obj->getExistencia(),
                    'precio' => number_format(($mercancia_obj->getImporte() / $mercancia_obj->getExistencia()), 5, '.', ''),
                    'importe' => $mercancia_obj->getImporte()
                );
                $total += floatval($mercancia_obj->getImporte());
            }
        }
        if (!empty($producto_arr)) {
            foreach ($producto_arr as $producto_obj) {
                /**@var $producto_obj Producto* */
                $row_producto[] = array(
                    'codigo' => $producto_obj->getCodigo(),
                    'descripcion' => $producto_obj->getDescripcion(),
                    'unidad_medida' => $producto_obj->getIdUnidadMedida()->getNombre(),
                    'existencia' => $producto_obj->getExistencia(),
                    'precio' => number_format(($producto_obj->getImporte() / $producto_obj->getExistencia()), 5, '.', ''),
                    'importe' => $producto_obj->getImporte()
                );
                $total += floatval($producto_obj->getImporte());
            }
        }
        return ['data' => array_merge($row_mercancia, $row_producto), 'total' => $total];
    }
}
