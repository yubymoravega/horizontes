<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\Zona;
use App\Form\TurismoModule\Traslado\LugaresType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/lugares")
 */
class LugaresController extends AbstractController
{
    /**
    * @Route("/", name="turismo_module_traslado_lugares")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $lugares = new Lugares();
        $form = $this->createForm(LugaresType::class,$lugares);
        $data = $em->getRepository(Lugares::class)->findBy(['activo'=>true]);
        $row = [];

        /**@var $item Lugares** */
        foreach ($data as $item){
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'estado' => $item->getHabilitado(),
                'zona'=>$item->getZona(),
                'zona_nom'=>$item->getZona()->getNombre()
            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('turismo_module/traslado/lugares/index.html.twig', [
            'controller_name' => 'LugaresController',
            'form'=>$form->createView(),
            'lugares'=>$paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_lugares_add")
     */
    public function addLugares(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Lugares::class);
        $nombre = $request->get('nombre');
        //$estado = false;
        $zona = $em->getRepository(Zona::class)->find($request->get('zona'));
       /* if ($request->get('est') == 'false')
        {
            $estado = false;
        }
        elseif($request->get('est') == 'true'){
            $estado = true;
        }*/
        $params = array(
            'nombre' => $nombre,
            //'habilitado' => $estado,
            'zona'=>$zona,
            'activo' => true

        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_lugar = new Lugares();

            $obj_lugar
                ->setNombre($nombre)
                ->setHabilitado(true)
                ->setActivo(true)
                ->setZona($zona);
            try {
                $em->persist($obj_lugar);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Lugar adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Este lugar ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_lugares_upd")
     */
    public function UpdateLugar(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Lugares::class);
        $nombre = $request->get('nombre');
        $zona = $em->getRepository(Zona::class)->find($request->get('zona'));
        $estado = false;
        $id = $request->get('id_OrigenDestino');

        if ($request->get('estado') == 'false')
        {
            $estado = false;
        }
        elseif ($request->get('estado') == 'true')
        {
            $estado = true;
        }

        $params = array(
            'nombre' => $nombre,
            'habilitado' => $estado,
            'activo' => true,
            'zona'=>$zona
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_OrigenDestino'))) {
            $obj_lugar = $entity_repository->find($id);
            /**@var $obj_lugar Lugares**/
            $obj_lugar
                ->setNombre($nombre)
                //->setHabilitado($estado)
                ->setZona($zona);
            try {
                $em->persist($obj_lugar);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Lugar actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El lugar ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_lugares_delete")
     */
    public function DeleteLugar($id){
        $em = $this->getDoctrine()->getManager();

        $lugar_er = $em->getRepository(Lugares::class);
        $lugar_obj = $lugar_er->find($id);
        $msg = 'No se pudo eliminar el lugar seleccionado';
        $success = 'error';
        if ($lugar_obj) {
            /**@var $lugar_obj Lugares** */
            $lugar_obj->setActivo(false);
            try {
                $em->persist($lugar_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Lugar eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_lugares');
    }

    /**
     * @Route("/change", name="turismo_module_traslado_lugares_change")
     */
    public function CambiarEstado(EntityManagerInterface $em, Request $request){
        $repo = $em->getRepository(Lugares::class);
        $id = $request->get('id');
        $obj = $repo->find($id);
        $msg = 'No se pudo cambiar el estado del lugar seleccionado';
        $success = 'error';
        if ($obj->getHabilitado()){
            $obj->setHabilitado(false);
            try {
                $em->persist($obj);
                $em->flush();
                $success = 'success';
                $msg = 'Estado cambiado satisfactoriamente';
            }catch (FileException $exception){
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
                $this->addFlash($success, $msg);
                return new JsonResponse(['success' => false]);
            }
        }
        else{
            $obj->setHabilitado(true);
            try {
                $em->persist($obj);
                $em->flush();
                $success = 'success';
                $msg = 'Estado cambiado satisfactoriamente';
            }catch (FileException $exception){
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
                $this->addFlash($success, $msg);
                return new JsonResponse(['success' => false]);
            }
        }
        $this->addFlash($success, $msg);
        return new JsonResponse(['success' => true]);
    }
}
