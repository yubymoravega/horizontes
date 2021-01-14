<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Form\Contabilidad\CapitalHumano\CargoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CargoController extends AbstractController
{
    /**
     * @Route("/contabilidad/capital-humano/cargo", name="contabilidad_capital_humano_cargo")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(CargoType::class);

        $cargo_arr = $em->getRepository(Cargo::class)->findByActivo(true);
        $row = [];
        foreach ($cargo_arr as $item) {
            /**@var $item Cargo** */
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
//                'salario_base' => $item->getSalarioBase()
            );
        }
        return $this->render('contabilidad/capital_humano/cargo/index.html.twig', [
            'controller_name' => 'CargoController',
            'cargos' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/capital-humano/cargo-add", name="contabilidad_capital_humano_cargo_add")
     */
    public function addCargo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Cargo::class);
        $params = array(
            'nombre' => $request->get('nombre'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_cargo = new Cargo();

            $obj_cargo
                ->setNombre($request->get('nombre'))
//                ->setSalarioBase($request->get('salario_base'))
                ->setActivo(true);
            try {
                $em->persist($obj_cargo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cargo adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El cargo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/capital-humano/cargo-upd", name="contabilidad_capital_humano_cargo_upd")
     */
    public function updCargo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Cargo::class);
        $params = array(
            'nombre' => $request->get('nombre'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_cargo'))) {
            $obj_cargo = $entity_repository->find($request->get('id_cargo'));
            $obj_cargo
                ->setNombre($request->get('nombre'))
//                ->setSalarioBase($request->get('salario_base'))
                ->setActivo(true);
            try {
                $em->persist($obj_cargo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cargo actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El cargo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/capital-humano/cargo-delete/{id}", name="contabilidad_capital_humano_cargo_delete")
     */
    public function deleteCargo($id)
    {
        $em = $this->getDoctrine()->getManager();

        $tasa_cambio_er = $em->getRepository(Cargo::class);
        $cargo_obj = $tasa_cambio_er->find($id);
        $msg = 'No se pudo eliminar el cargo seleccionado';
        $success = 'error';
        if ($cargo_obj) {
            /**@var $cargo_obj Cargo** */
            $cargo_obj->setActivo(false);
            try {
                $em->persist($cargo_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Cargo eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_capital_humano_cargo');
    }
}
