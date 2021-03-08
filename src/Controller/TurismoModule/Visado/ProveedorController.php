<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\ProveedorType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ProveedorController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/configuracion-turismo/proveedores")
 */
class ProveedorController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_proveedor")
     */
    public function index(EntityManagerInterface $em, Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
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

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('turismo_module/visado/proveedor/index.html.twig', [
            'controller_name' => 'ProveedorController',
            'form' => $form->createView(),
            'proveedores' => $paginator,
            'telefono'=>$obj_cliente->getTelefono(),
            'nombre'=>$obj_cliente->getNombre(),
            'apellidos'=>$obj_cliente->getApellidos(),
            'correo'=>$obj_cliente->getCorreo(),
            'direccion'=>$obj_cliente->getDireccion(),
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_visado_proveedor_add")
     */
    public function addProveedor(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Proveedor::class);
        $params = array(
            'nombre' => $request->get('nombre'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_cargo = new Proveedor();

            $obj_cargo
                ->setNombre($request->get('nombre'))
                ->setCodigo($request->get('codigo'))
                ->setActivo(true);
            try {
                $em->persist($obj_cargo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Proveedor adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El proveedor ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_visado_proveedor_upd")
     */
    public function updProveedor(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Proveedor::class);
        $params = array(
            'nombre' => $request->get('nombre'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_proveedor'))) {
            $obj_proveedor = $entity_repository->find($request->get('id_proveedor'));
            /**@var $obj_proveedor Proveedor**/
            $obj_proveedor
                ->setNombre($request->get('nombre'))
                ->setCodigo($request->get('codigo'))
                ->setActivo(true);
            try {
                $em->persist($obj_proveedor);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Proveedor actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El proveedor ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_visado_proveedor_delete")
     */
    public function deleteProveedor($id)
    {
        $em = $this->getDoctrine()->getManager();

        $proveedor_er = $em->getRepository(Proveedor::class);
        $proveedor_obj = $proveedor_er->find($id);
        $msg = 'No se pudo eliminar el proveedor seleccionado';
        $success = 'error';
        if ($proveedor_obj) {
            /**@var $proveedor_obj Proveedor** */
            $proveedor_obj->setActivo(false);
            try {
                $em->persist($proveedor_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Proveedor eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_visado_proveedor');
    }
}
