<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Traslado\Zona;
use App\Form\TurismoModule\Traslado\ZonaType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/zona")
 */
class ZonaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_zona")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $zona = new Zona();
        $form = $this->createForm(ZonaType::class,$zona);
        $row = [];
        $data = $em->getRepository(Zona::class)->findBy(['activo'=>true]);

        /**@var $item Zona** */
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

        return $this->render('turismo_module/traslado/zona/index.html.twig', [
            'controller_name' => 'ZonaController',
            'form'=> $form->createView(),
            'zona'=>$paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_zona_add")
     */
    public function AddAeropuerto(EntityManagerInterface $em,Request $request){
        $entityRepository = $em->getRepository(Zona::class);
        $nombre = $request->get('nombre');

        $params = array(
            'nombre' => $nombre,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entityRepository, $params, 'add')) {
            $obj_zona = new Zona();

            $obj_zona
                ->setNombre($nombre)
                ->setActivo(true);
            try {
                $em->persist($obj_zona);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Zona adicionada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Esta zona ya se encuentra registrada");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_zona_upd")
     */
    public function UpdateZona(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Zona::class);
        $nombre = $request->get('nombre');
        $id = $request->get('id');
        $params = array(
            'nombre' => $nombre,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id'))) {
            $obj_zona = $entity_repository->find($id);
            /**@var $obj_zona Zona**/
            $obj_zona
                ->setNombre($nombre);
            try {
                $em->persist($obj_zona);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Zona actualizada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "La zona ya se encuentra registrada");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_zona_delete")
     */
    public function BorrarZona($id){
        $em = $this->getDoctrine()->getManager();

        $zona_er = $em->getRepository(Zona::class);
        $zona_obj = $zona_er->find($id);
        $msg = 'No se pudo eliminar la zona seleccionada';
        $success = 'error';
        if ($zona_obj) {
            /**@var $zona_obj Zona** */
            $zona_obj->setActivo(false);
            try {
                $em->persist($zona_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Zona eliminada satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_zona');
    }
}
