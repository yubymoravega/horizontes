<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Traslado\TipoTraslado;
use App\Form\TurismoModule\Traslado\TipoTrasladoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/tipo-traslado")
 */
class TipoTrasladoController extends AbstractController
{

    /**
     * @Route("/", name="turismo_module_traslado_tipo_traslado")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $tipoTraslado = new TipoTraslado();
        $form= $this->createForm(TipoTrasladoType::class,$tipoTraslado);

        $data = $em->getRepository(TipoTraslado::class)->findBy(['activo'=>true]);
        $row = [];

        /**@var $item TipoTraslado** */
        foreach ($data as $item){
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre()
            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('turismo_module/traslado/tipo_traslado/index.html.twig', [
            'controller_name' => 'TipoTrasladoController',
            'form'=>$form->createView(),
            'traslados'=>$paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_tipo_traslado_add")
     */
    public function addTipoTraslado(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(TipoTraslado::class);
        $nombre = $request->get('nombre');
        $params = array(
            'nombre' => $nombre,
            'activo' => true

        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_TiTraslado = new TipoTraslado();

            $obj_TiTraslado
                ->setNombre($nombre)
                ->setActivo(true);
            try {
                $em->persist($obj_TiTraslado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Tipo de traslado adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El tipo de traslado ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_tipo_traslado_upd")
     */
    public function UpdateTipoTraslado(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(TipoTraslado::class);
        $nombre = $request->get('nombre');
        $id = $request->get('id_TipoTraslado');
        $params = array(
            'nombre' => $nombre,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_TipoTraslado'))) {
            $obj_tipoTraslado = $entity_repository->find($id);
            /**@var $obj_tipoTraslado TipoTraslado**/
            $obj_tipoTraslado
                ->setNombre($nombre);
            try {
                $em->persist($obj_tipoTraslado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Tipo de traslado actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El tipo de traslado ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_tipo_traslado_delete")
     */
    public function DeleteTipoTraslado($id){
        $em = $this->getDoctrine()->getManager();

        $tipoTraslado_er = $em->getRepository(TipoTraslado::class);
        $tipoTraslado_obj = $tipoTraslado_er->find($id);
        $msg = 'No se pudo eliminar el tipo de traslado seleccionado';
        $success = 'error';
        if ($tipoTraslado_obj) {
            /**@var $tipoTraslado_obj TipoTraslado** */
            $tipoTraslado_obj->setActivo(false);
            try {
                $em->persist($tipoTraslado_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Tipo de traslado eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_tipo_traslado');
    }
}
