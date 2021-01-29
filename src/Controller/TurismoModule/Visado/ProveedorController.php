<?php

namespace App\Controller\TurismoModule\Visado;

use App\Entity\Cliente;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\ProveedorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProveedorController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/turismo/gestion-consular/proveedores")
 */
class ProveedorController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_proveedor")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $id_cliente = $request->request->get('id_cliente');
        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));
        $form = $this->createForm(ProveedorType::class);
        $data = $em->getRepository(Proveedor::class)->findBy(['activo' => true]);
        $row = [];
        /**@var $item Proveedor** */
        foreach ($data as $item){
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo()
            );
        }
        return $this->render('turismo_module/visado/proveedor/index.html.twig', [
            'controller_name' => 'ProveedorController',
            'form' => $form->createView(),
            'proveedores' => $row,
            'telefono'=>$obj_cliente->getTelefono(),
            'nombre'=>$obj_cliente->getNombre(),
            'apellidos'=>$obj_cliente->getApellidos(),
            'correo'=>$obj_cliente->getCorreo(),
            'direccion'=>$obj_cliente->getDireccion(),
            'id_cliente'=>$id_cliente
        ]);
    }
}
