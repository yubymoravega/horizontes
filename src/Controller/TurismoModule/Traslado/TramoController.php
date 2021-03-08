<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\TipoTraslado;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Entity\TurismoModule\Traslado\Tramo;
use App\Form\TurismoModule\Traslado\TramoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/tramo")
 */
class TramoController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_tramo")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
         /** @var Cliente $obj_cliente */
         $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
         $tramo = new Tramo();

         $origen_er = $em->getRepository(Lugares::class);
         $tipo_vehiculo_er = $em->getRepository(TipoVehiculo::class);
         $proveedor_er=$em->getRepository(Proveedor::class);
         $tipo_traslado_er=$em->getRepository(TipoTraslado::class);

         $form = $this->createForm(TramoType::class,$tramo);
         //$data = $em->getRepository(Tramo::class)->findBy(['activo'=>true]);
        $repo = $this->getDoctrine()->getRepository(Tramo::class);
        $query = $repo->createQueryBuilder('p')
            ->where('p.activo = true')
            //->groupBy('p.origen')
            ->orderBy('p.precio', 'ASC')
            ->getQuery();
        $tramosOrenados = $query->getResult();
        $row = [];
        $data = [];
        $rows_repeat = [];

         /**@var $item Tramo** */
        foreach ($tramosOrenados as $item){
            $str_tramo = $item->getOrigen().'-'.$item->getDestino();
            if(!in_array($str_tramo,$rows_repeat)){
                $rows_repeat[count($rows_repeat)]=$str_tramo;
            }
        }
        foreach ($rows_repeat as $element){
            $row = [];
            foreach ($tramosOrenados as $item){
                $str_tramo = $item->getOrigen().'-'.$item->getDestino();
                if($str_tramo == $element)
                $row [] = array(
                    'id' => $item->getId(),
                    'proveedor' => $item->getProveedor(),
                    'proveedor_nomb' => $proveedor_er->findBy(['id'=> $item->getProveedor()])[0]->getNombre(),
                    'origen' => $item->getOrigen(),
                    'origen_nomb'=> $origen_er->findBy(['id'=> $item->getOrigen()])[0]->getNombre(),
                    'destino' => $item->getDestino(),
                    'destino_nomb'=> $origen_er->findBy(['id'=> $item->getDestino()])[0]->getNombre(),
                    'ida_vuelta' => $item->getIdaVuelta(),
                    'vehiculo' => $item->getVehiculo(),
                    'vehiculo_nomb'=> $tipo_vehiculo_er->findBy(['id'=> $item->getVehiculo()])[0]->getNombre(),
                    'traslado' => $item->getTraslado(),
                    'traslado_nomb'=> $tipo_traslado_er->findBy(['id'=> $item->getTraslado()])[0]->getNombre(),
                    'precio' => $item->getPrecio(),
                    'precio_tabla' => number_format($item->getPrecio(),2)
                );
            }
            $values = explode('-',$element);
            $data[] = [
                'tramo'=>$origen_er->find(intval($values[0]))->getNombre().' - '.$origen_er->find(intval($values[1]))->getNombre(),
                'data'=>$row
            ];
        }

        $paginator = $pagination->paginate(
            $data,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('turismo_module/traslado/tramo/index.html.twig', [
            'controller_name' => 'TramoController',
            'form'=> $form->createView(),
            'tramo'=> $paginator,
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_tramo_add")
     */
    public function addTramo(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Tramo::class);
        $proveedor = $request->get('proveedor');
        $origen = $request->get('origen');
        $destino = $request->get('destino');
        $ida_vuelta = false;
        if($request->get('ida_vuelta') == 1){
            $ida_vuelta = true;
        }
        elseif($request->get('ida_vuelta') == 0){
            $ida_vuelta = false;
        }
        $vehiculo = $request->get('vehiculo');
        $traslado = $request->get('traslado');
        $precio = floatval($request->get('precio'));
        $params = array(
            'proveedor' => $proveedor,
            'origen' => $origen,
            'destino' => $destino,
            'ida_vuelta' => $ida_vuelta,
            'vehiculo' => $vehiculo,
            'traslado'=> $traslado,
            'precio' => $precio,
            'activo' => true

        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_Tramo = new Tramo();

            $obj_Tramo
                ->setProveedor($proveedor)
                ->setOrigen($origen)
                ->setDestino($destino)
                ->setIdaVuelta($ida_vuelta)
                ->setVehiculo($vehiculo)
                ->setTraslado($traslado)
                ->setPrecio($precio)
                ->setActivo(true);
            try {
                $em->persist($obj_Tramo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Tramo adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El tramo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_tramo_upd")
     */
    public function UpdateTramo(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(Tramo::class);
        $proveedor = $request->get('proveedor');
        $origen = $request->get('origen');
        $destino = $request->get('destino');
        $sentido = false;
        $id = $request->get('id');

        if ($request->get('ida_vuelta') == 0)
        {
            $sentido = false;
        }
        elseif ($request->get('ida_vuelta') == 1)
        {
            $sentido = true;
        }
        $vehiculo = $request->get('vehiculo');
        $traslado = $request->get('traslado');
        $precio = $request->get('precio');


        $params = array(
            'proveedor' => $proveedor,
            'origen' => $origen,
            'destino' => $destino,
            'ida_vuelta' => $sentido,
            'vehiculo' => $vehiculo,
            'traslado'=>$traslado,
            'precio' => $precio,
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id'))) {
            $obj_tramo = $entity_repository->find($id);
            /**@var $obj_tramo Tramo**/
            $obj_tramo
            ->setProveedor($proveedor)
            ->setOrigen($origen)
            ->setDestino($destino)
            ->setIdaVuelta($sentido)
            ->setVehiculo($vehiculo)
            ->setTraslado($traslado)
            ->setPrecio($precio);
            try {
                $em->persist($obj_tramo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Tramo actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El tramo ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_tramo_delete")
     */
    public function DeleteTramo($id){
        $em = $this->getDoctrine()->getManager();

        $tramo_er = $em->getRepository(Tramo::class);
        $tramo_obj = $tramo_er->find($id);
        $msg = 'No se pudo eliminar el tramo seleccionado';
        $success = 'error';
        if ($tramo_obj) {
            /**@var $tramo_obj Tramo** */
            $tramo_obj->setActivo(false);
            try {
                $em->persist($tramo_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Tramo eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_tramo');
    }
}
