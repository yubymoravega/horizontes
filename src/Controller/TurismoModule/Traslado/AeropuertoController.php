<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\CoreTurismo\CrudController;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Traslado\Aeropuerto;
use App\Form\TurismoModule\Traslado\AeropuertoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/aeropuerto")
 */
class AeropuertoController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_aeropuerto")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $aeropuerto = new Aeropuerto();
        $form = $this->createForm(AeropuertoType::class,$aeropuerto);
        $data = $em->getRepository(Aeropuerto::class)->findBy(['activo'=>true]);
        $row = [];

        /**@var $item Aeropuerto** */
        foreach ($data as $item){
            $row[] = array(
                'id'=> $item->getId(),
                'nombre'=>$item->getNombre()
            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );


        return $this->render('turismo_module/traslado/aeropuerto/index.html.twig', [
            'controller_name' => 'AeropuertoController',
            'form'=> $form->createView(),
            'aeropuertos'=>$paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }


    /**
     * @Route("/add", name="turismo_module_traslado_aeropuerto_add")
     */
    public function AddAeropuerto(EntityManagerInterface $em,Request $request){
    $entityRepository = $em->getRepository(Aeropuerto::class);
    $nombre = $request->get('nombre');

        $params = array(
            'nombre' => $nombre,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entityRepository, $params, 'add')) {
            $obj_aeropuerto = new Aeropuerto();

            $obj_aeropuerto
                ->setNombre($nombre)
                ->setActivo(true);
            try {
                $em->persist($obj_aeropuerto);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Aeropuerto adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Este aeropuerto ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_aeropuerto_upd")
     */
    public function UpdateAeropuerto(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Aeropuerto::class);
        $nombre = $request->get('nombre');
        $id = $request->get('id');
        $params = array(
            'nombre' => $nombre,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id'))) {
            $obj_aeropuerto = $entity_repository->find($id);
            /**@var $obj_aeropuerto Aeropuerto**/
            $obj_aeropuerto
                ->setNombre($nombre);
            try {
                $em->persist($obj_aeropuerto);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Aeropuerto actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El aeropuerto ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_aeropuerto_delete")
     */
    public function BorrarAeropuerto($id){
        $em = $this->getDoctrine()->getManager();

        $Aeropuerto_er = $em->getRepository(Aeropuerto::class);
        $Aeropuerto_obj = $Aeropuerto_er->find($id);
        $msg = 'No se pudo eliminar el aeropuerto seleccionado';
        $success = 'error';
        if ($Aeropuerto_obj) {
            /**@var $Aeropuerto_obj Aeropuerto** */
            $Aeropuerto_obj->setActivo(false);
            try {
                $em->persist($Aeropuerto_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Aeropuerto eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_aeropuerto');
    }
}
