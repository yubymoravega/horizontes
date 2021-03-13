<?php

namespace App\Controller\TurismoModule\hotel;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\TurismoModule\hotel\Hotel;
use App\Entity\TurismoModule\hotel\PlanHotel;
use App\Form\TurismoModule\hotel\HotelType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @package App\Controller\TurismoModule\hotel
 * @Route("/configuracion-turismo/Hotel")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_hotel")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {

        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class,$hotel);
        $plan_er = $em->getRepository(PlanHotel::class)->findBy(['activo'=>true]);
        $hotel_er = $em->getRepository(Hotel::class)->findBy(['activo'=>true]);
        $row = [];

        /**@var $item Hotel** */
        foreach ($hotel_er as $item){
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'categoria' => $item->getCategoria(),
                'plan' => $item->getPlanHotel()->getNombre(),
                'id_plan'=> $item->getPlanHotel()->getId()
            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );


        return $this->render('turismo_module/hotel/hotel/index.html.twig', [
            'controller_name' => 'HotelController',
            'form'=>$form->createView(),
            'hoteles'=>$paginator,
            'planes' => $plan_er,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_hotel_add")
     */
    public function addLugares(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Hotel::class);
        $nombre = $request->get('nombre');
        $categoria = $request->get('categoria');
        $plan = $em->getRepository(PlanHotel::class)->find($request->get('plan'));


        $params = array(
            'nombre' => $nombre,
            'categoria'=> $categoria,
            'planHotel'=>$plan,
            'activo' => true

        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_hotel = new Hotel();

            $obj_hotel
                ->setNombre($nombre)
                ->setCategoria($categoria)
                ->setPlanHotel($plan)
                ->setActivo(true);
            try {
                $em->persist($obj_hotel);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Hotel adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Este hotel ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_hotel_upd")
     */
    public function UpdateLugar(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Hotel::class);
        $nombre = $request->get('nombre');
        $plan = $em->getRepository(PlanHotel::class)->find($request->get('plan'));
        $categoria =  $request->get('categoria');
        $id = $request->get('id');

        $params = array(
            'nombre' => $nombre,
            'categoria' => $categoria,
            'planHotel' => $plan,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id'))) {
            $obj_hotel = $entity_repository->find($id);
            /**@var $obj_hotel Hotel**/
            $obj_hotel
                ->setNombre($nombre)
                ->setCategoria($categoria)
                ->setPlanHotel($plan);
            try {
                $em->persist($obj_hotel);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Hotel actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El hotel ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_hotel_delete")
     */
    public function DeleteLugar($id){
        $em = $this->getDoctrine()->getManager();

        $hotel_er = $em->getRepository(Hotel::class);
        $hotel_obj = $hotel_er->find($id);
        $msg = 'No se pudo eliminar el hotel seleccionado';
        $success = 'error';
        if ($hotel_obj) {
            /**@var $hotel_obj Hotel** */
            $hotel_obj->setActivo(false);
            try {
                $em->persist($hotel_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Hotel eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_hotel');
    }
}
