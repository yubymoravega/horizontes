<?php

namespace App\Controller\Contabilidad;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use App\Entity\Contabilidad\Inventario\Cierre;
use App\Entity\Contabilidad\Inventario\Mercancia;
use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use App\Entity\Contabilidad\Inventario\MovimientoProducto;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class InventarioController extends AbstractController
{

    /**
     * @Route("/contabilidad/inventario", name="inventario")
     */
    public function index()
    {

        return $this->render('contabilidad/inventario/index.html.twig', [
            'controller_name' => 'Dashboard',
            'config' => array(
                ['title' => 'Ejemplo', 'descrip' => 'Descripcion de prueba....'],)
        ]);
    }


    /**
     * @Route("/contabilidad/inventario/selAlmacen", name="sel_alamacen_inventario")
     */
    public function selAlmacen(Request $request)
    {
        if ($request->getSession()->get('selected_almacen/id'))
            return $this->redirectToRoute('inventario');

        $row = [];
        $obj_user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'baja' => false,
            'id_usuario' => $obj_user->getId()
        ));
        if ($empleado) {
            /**@var $empleado Empleado** */
            $almacenes = $em->getRepository(Almacen::class)->findBy(array(
                'activo' => true,
                'id_unidad' => $empleado->getIdUnidad()->getId()
            ));
            $almacen_ocupado_er = $em->getRepository(AlmacenOcupado::class);
            foreach ($almacenes as $almacen) {
                /**@var $almacen Almacen* */
                $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                    'id_almacen' => $almacen
                ));
                $row[] = array(
                    'id' => $almacen->getId(),
                    'descripcion' => $almacen->getCodigo() . ' - ' . $almacen->getDescripcion(),
                    'disable' => !$obj_almacen_ocupado ? false : true
                );
            }
        }
        //verifico si cerro el ultimo dia, o sea si tiene operaciones por liquidar
        return $this->render('contabilidad/inventario/selalmacen.html.twig', [
            'controller_name' => 'Dashboard',
            'almacenes' => $row
        ]);
    }

    /**
     * @Route("/contabilidad/inventario/seleccionarAlmacen", name="seleccionar_alamacen_inventario")
     */
    public function seleccionarAlmacen(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $almacen_id = $request->get('almacenes_select');

        $session->set('selected_almacen/id', $almacen_id);
        $fecha_sistema = AuxFunctions::getDateToClose($em, $almacen_id);
        $arr_part_fecha = explode('-', $fecha_sistema);
        $fecha = $arr_part_fecha[2] . '/' . $arr_part_fecha[1] . '/' . $arr_part_fecha[0];
        $session->set('date_system', $fecha);
        $session->set('min_date', '2020-10-01');
        $session->set('max_date', Date('Y-m-d'));


        $id_usuario = $this->getUser();
        $almacen_obj = $em->getRepository(Almacen::class)->find($almacen_id);
        $name_almacen = $almacen_obj->getCodigo().' - '.$almacen_obj->getDescripcion();
        $session->set('selected_almacen/name', $name_almacen);
        if ($almacen_obj && $id_usuario) {
            //buscar nuevamente que ningun usuario este usando el almacen
            $almacen_ocupado_er = $em->getRepository(AlmacenOcupado::class);
            $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                'id_almacen' => $almacen_obj
            ));
            if (!$obj_almacen_ocupado) {
                $nuevo_almacen_ocupado = new AlmacenOcupado();
                $nuevo_almacen_ocupado
                    ->setIdAlmacen($almacen_obj)
                    ->setIdUsuario($id_usuario);
                try {
                    $em->persist($nuevo_almacen_ocupado);
                    $em->flush();
                    $this->addFlash('success', 'Usted se encuentra trabajando dento del almacén ' . $name_almacen);
                } catch (FileException $e) {
                    return $e->getMessage();
                }
            }
        }
        return $this->redirectToRoute('inventario');
    }

    /**
     * @Route("/contabilidad/inventario/salirAlmacen", name="salir_alamacen_inventario")
     */
    public function salirAlmacen(Request $request)
    {
        $session = $request->getSession();
        $almacen_id = $request->getSession()->get('selected_almacen/id');
        $name_almacen = $request->getSession()->get('selected_almacen/name');

        $id_usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $almacen_obj = $em->getRepository(Almacen::class)->find($almacen_id);
        if ($almacen_obj && $id_usuario) {
            //buscar nuevamente que ningun usuario este usando el almacen
            $almacen_ocupado_er = $em->getRepository(AlmacenOcupado::class);
            $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                'id_almacen' => $almacen_obj
            ));
            if ($obj_almacen_ocupado) {
                try {
                    $em->remove($obj_almacen_ocupado);
                    $em->flush();

                    $this->addFlash('success', 'Usted ha salido del almacen ' . $name_almacen);
                    $session->set('selected_almacen/id', null);
                    $session->set('selected_almacen/name', null);
                } catch (FileException $e) {
                    return $e->getMessage();
                }
            }
        }
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/contabilidad/inventario/cambiar-fecha", name="contabilidad_inventario_cambiar_fecha")
     */
    public function cambiar(EntityManagerInterface $em, Request $request)
    {
        $id_almacen = $request->getSession()->get('selected_almacen/id');
        $almacen_obj = $em->getRepository(Almacen::class)->find($id_almacen);

        $movimiento_mercancias_er = $em->getRepository(MovimientoMercancia::class);
        $movimiento_producto_er = $em->getRepository(MovimientoProducto::class);
        $cierre_er = $em->getRepository(Cierre::class);

        $obj_cierre_abierto = $cierre_er->findOneBy(array(
            'id_almacen' => $almacen_obj,
            'abierto' => true,
        ));
        $fecha_seleccionada = $request->get('fecha_cierre');

        /**@var Cierre $obj_cierre_abierto */
        $today = $request->getSession()->get('date_system');;

        //1- obtener todos los debitos(entradas) y creditos(salidas)
        //1.1 mercancias
        $movimientos_mercancias_arr = $movimiento_mercancias_er->findBy(array(
            'fecha' => \DateTime::createFromFormat('d/m/Y', $today),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));

        if(empty($movimientos_mercancias_arr) && !$obj_cierre_abierto){
            $arr_split_fecha = explode('-', $fecha_seleccionada);
            $session = $request->getSession();
            $fecha = $arr_split_fecha[2] . '/' . $arr_split_fecha[1] . '/' . $arr_split_fecha[0];
            $session->set('date_system', $fecha);
            $session->set('min_date', $fecha_seleccionada);
            $session->set('max_date', Date('Y-m-d'));
            $this->addFlash('success', 'Fecha cambiada satisfactoriamente');
            return $this->redirectToRoute('inventario');
        }

        $debitos = 0;
        $creditos = 0;
        /** @var MovimientoMercancia $obj_mercancia */
        foreach ($movimientos_mercancias_arr as $obj_mercancia) {
            if ($obj_mercancia->getEntrada())
                $debitos += floatval($obj_mercancia->getImporte());
            else
                $creditos += floatval($obj_mercancia->getImporte());
        }
        //1.2 productos
        $movimientos_productos_arr = $movimiento_producto_er->findBy(array(
            'fecha' => \DateTime::createFromFormat('d/m/Y', $today),
            'activo' => true,
            'id_almacen' => $almacen_obj
        ));
        /** @var MovimientoProducto $obj_producto */
        foreach ($movimientos_productos_arr as $obj_producto) {
            if ($obj_producto->getEntrada())
                $debitos += floatval($obj_producto->getImporte());
            else
                $creditos += floatval($obj_producto->getImporte());
        }


        if ($debitos > 0 || $creditos > 0) {
            $this->addFlash('error', 'No puede cambiar de fecha porque tiene operaciones sin cerrar.');
            return $this->redirectToRoute('inventario');
        } else {
            $arr_split_fecha = explode('-', $fecha_seleccionada);
            $obj_cierre_abierto
                ->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_seleccionada))
                ->setMes(intval($arr_split_fecha[1]))
                ->setAnno(intval($arr_split_fecha[0]));
            $em->persist($obj_cierre_abierto);
            try {
                $em->flush();
            } catch (FileException $e) {
                return $e->getMessage();
            }
            $session = $request->getSession();
            $fecha = $arr_split_fecha[2] . '/' . $arr_split_fecha[1] . '/' . $arr_split_fecha[0];
            $session->set('date_system', $fecha);
            $session->set('min_date', $fecha_seleccionada);
            $session->set('max_date', Date('Y-m-d'));

            $this->addFlash('success', 'Fecha cambiada satisfactoriamente');
            return $this->redirectToRoute('inventario');
        }
    }
}

