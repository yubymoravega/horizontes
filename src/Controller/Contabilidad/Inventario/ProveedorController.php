<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Form\Contabilidad\Inventario\ProveedorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProveedorController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/proveedor", name="contabilidad_inventario_proveedor")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ProveedorType::class);

        $proveedor_arr = $em->getRepository(Proveedor::class)->findByActivo(true);
        $row = [];
        foreach ($proveedor_arr as $item) {
            /**@var $item Proveedor** */
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo()
            );
        }
        return $this->render('contabilidad/inventario/proveedor/index.html.twig', [
            'controller_name' => 'ProveedorController',
            'proveedores' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/inventario/proveedor-add", name="contabilidad_inventario_proveedor_add")
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
     * @Route("/contabilidad/inventario/proveedor-upd", name="contabilidad_inventario_proveedor_upd")
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
     * @Route("/contabilidad/inventario/proveedor-delete/{id}", name="contabilidad_inventario_proveedor_delete")
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
        return $this->redirectToRoute('contabilidad_inventario_proveedor');
    }
}
