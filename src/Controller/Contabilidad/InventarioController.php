<?php

namespace App\Controller\Contabilidad;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\User;
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
        $row = [];
        $obj_user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $empleado = $em->getRepository(Empleado::class)->findBy(array(
            'baja'=>false,
            'id_usuario'=>$obj_user->getId()
        ));
        if($empleado){
            /**@var $empleado Empleado***/
            $almacenes = $em->getRepository(Almacen::class)->findBy(array(
                'activo'=>true,
//                'id_unidad'=>$empleado->getIdUnidad()->getId()
            ));
            foreach ($almacenes as $almacen){
                /**@var $almacen Almacen**/
                $row[] = array(
                    'id'=>$almacen->getId(),
                    'descripcion'=>$almacen->getDescripcion()
                );
            }
        }
        return $this->render('contabilidad/inventario/selalmacen.html.twig', [
            'controller_name' => 'Dashboard',
            'almacenes'=>$row
        ]);
    }

    /**
     * @Route("/contabilidad/inventario/seleccionarAlmacen", name="seleccionar_alamacen_inventario")
     */
    public function seleccionarAlmacen(Request $request)
    {
        $session = $request->getSession();
        $almacen_id =$request->get('id_almacen');
        $name_almacen =$request->get('name_almacen');
        $session->set('selected_almacen/id', $almacen_id);
        $session->set('selected_almacen/name', $name_almacen);
        $this->addFlash('success', 'Usted se encuentra trabajando dento del almacén '.$name_almacen);
        return new JsonResponse(['success'=>true]);
    }
}

