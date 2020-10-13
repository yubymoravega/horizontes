<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CerrarDiaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/cerrar-dia")
 */
class CerrarDiaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_cerrar_dia")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/cerrar_dia/index.html.twig', [
            'controller_name' => 'CerrarDiaController',
        ]);
    }
    /**
     * @Route("/cerrar", name="contabilidad_inventario_cerrar_dia_cerrar")
     */
    public function cerrar(EntityManagerInterface $em,Request $request)
    {
        $id_almacen = $request->getSession()->get('almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);
        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        //1- obtener todos los debitos(entradas)
        //1.1 mercancias
            $movimientos_mercancias_arr = $movimiento_mercancias_er->findBy(array(
                'fecha'=>'',
                'entrada'=>true,
                'activo'=>true,
                'id_almacen'=>$almacen_obj
            ));
        //1.2 productos
        $movimientos_productos_arr = $movimiento_producto_er->findBy(array(
            'fecha'=>'',
            'entrada'=>true,
            'activo'=>true,
            'id'
        ));

        //obtener todos los creditos(salidas)

        return $this->render('contabilidad/inventario/comprobante_operaciones/index.html.twig', [
            'controller_name' => 'CerrarDiaController',
        ]);
    }
}
