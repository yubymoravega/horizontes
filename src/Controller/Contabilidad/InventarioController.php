<?php

namespace App\Controller\Contabilidad;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Inventario\AlmacenOcupado;
use App\Entity\User;
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
                    'descripcion' => $almacen->getDescripcion(),
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
        $session = $request->getSession();
        $almacen_id = $request->get('almacenes_select');
//        dd($request->get('almacenes_select'));
//        $name_almacen = $request->get('name_almacen');
        $session->set('selected_almacen/id', $almacen_id);
        $id_usuario = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $almacen_obj = $em->getRepository(Almacen::class)->find($almacen_id);
        $name_almacen = $almacen_obj->getDescripcion();
        $session->set('selected_almacen/name', $name_almacen);
        if ($almacen_obj && $id_usuario) {
            //buscar nuevamente que ningun usuario este usando el almacen
            $almacen_ocupado_er = $em->getRepository(AlmacenOcupado::class);
            $obj_almacen_ocupado = $almacen_ocupado_er->findOneBy(array(
                'id_almacen' => $almacen_obj
            ));
            if (!$obj_almacen_ocupado) {
//                dd('add');
                $nuevo_almacen_ocupado = new AlmacenOcupado();
                $nuevo_almacen_ocupado
                    ->setIdAlmacen($almacen_obj)
                    ->setIdUsuario($id_usuario);
                try {
                    $em->persist($nuevo_almacen_ocupado);
                    $em->flush();
//                    dd('sasa');
                    $this->addFlash('success', 'Usted se encuentra trabajando dento del almacén ' . $name_almacen);
                } catch (FileException $e) {
                    return $e->getMessage();
                }
            }
        }
//        return new JsonResponse(['success' => true]);
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
}

