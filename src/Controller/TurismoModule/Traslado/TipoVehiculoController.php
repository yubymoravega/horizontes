<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Form\TurismoModule\Traslado\TipoVehiculoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TipoVehiculoController
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/tipo-vehiculo")
 */
class TipoVehiculoController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_tipo_vehiculo")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $tipoVehiculo = new TipoVehiculo();
        $form = $this->createForm(TipoVehiculoType::class,$tipoVehiculo);
        $data = $em->getRepository(TipoVehiculo::class)->findBy(['activo'=>true]);
        $row = [];

        /**@var $item TipoVehiculo** */
        foreach ($data as $item){
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'cant_ini' => $item->getCantidadIniPersona(),
                'cant_fin' => $item->getCantidadFinPersona()
            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );


        return $this->render('turismo_module/traslado/tipo_vehiculo/index.html.twig', [
            'controller_name' => 'TipoVehiculoController',
            'form' => $form->createView(),
            'vehiculos'=> $paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_tipo_vehiculo_add")
     */
    public function addTipoVehiculo(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(TipoVehiculo::class);
        $nombre = $request->get('nombre');
        $cant_ini = $request->get('cantidad_ini_persona');
        $cant_fin = $request->get('cantidad_fin_persona');
        $params = array(
            'nombre' => $nombre,
            'cantidad_ini_persona' => $cant_ini,
            'cantidad_fin_persona' => $cant_fin,
            'activo' => true

        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_TiVehiculo = new TipoVehiculo();

            $obj_TiVehiculo
                ->setNombre($nombre)
                ->setCantidadIniPersona($cant_ini)
                ->setCantidadFinPersona($cant_fin)
                ->setActivo(true);
            try {
                $em->persist($obj_TiVehiculo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Vehículo adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El vehículo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_tipo_vehiculo_upd")
     */
    public function UpdateTipoVehiculo(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(TipoVehiculo::class);
        $nombre = $request->get('nombre');
        $id = $request->get('id_TipoVehiculo');

        $params = array(
            'nombre' => $nombre,
            'cantidad_ini_persona' => $request->get('cantidad_ini_persona'),
            'cantidad_fin_persona' => $request->get('cantidad_fin_persona'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_TipoVehiculo'))) {
            $obj_tipoVehiculo = $entity_repository->find($id);
            /**@var $obj_tipoVehiculo TipoVehiculo**/
            $obj_tipoVehiculo
                ->setNombre($nombre)
                ->setCantidadIniPersona($request->get('cantidad_ini_persona'))
                ->setCantidadFinPersona($request->get('cantidad_fin_persona'));
            try {
                $em->persist($obj_tipoVehiculo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Tipo de vehículo actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El vehículo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_tipo_vehiculo_delete")
     */
    public function DeleteTipoVehiculo($id){
        $em = $this->getDoctrine()->getManager();

        $tipoVehiculo_er = $em->getRepository(TipoVehiculo::class);
        $tipoVehiculo_obj = $tipoVehiculo_er->find($id);
        $msg = 'No se pudo eliminar el vehículo seleccionado';
        $success = 'error';
        if ($tipoVehiculo_obj) {
            /**@var $tipoVehiculo_obj TipoVehiculo** */
            $tipoVehiculo_obj->setActivo(false);
            try {
                $em->persist($tipoVehiculo_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Vehículo eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_tipo_vehiculo');
    }
}
