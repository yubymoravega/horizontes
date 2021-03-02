<?php

namespace App\Controller\TurismoModule\Traslado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Contabilidad\Inventario\Proveedor;
use App\Entity\TurismoModule\Traslado\Lugares;
use App\Entity\TurismoModule\Traslado\PrecioVenta;
use App\Entity\TurismoModule\Traslado\TipoTraslado;
use App\Entity\TurismoModule\Traslado\TipoVehiculo;
use App\Entity\TurismoModule\Traslado\Tramo;
use App\Form\TurismoModule\Traslado\PrecioVentaType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/precio-venta")
 */
class PrecioVentaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_precio_venta")
     */
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $pagination)
    {
        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $precioVenta = new PrecioVenta();
        $form = $this->createForm(PrecioVentaType::class,$precioVenta);
        $origen_er = $em->getRepository(Lugares::class);
        $tipo_vehiculo_er = $em->getRepository(TipoVehiculo::class);
        $proveedor_er=$em->getRepository(Proveedor::class);
        $tipo_traslado_er=$em->getRepository(TipoTraslado::class);
        $repo = $this->getDoctrine()->getRepository(Tramo::class);
        $tramo_er = $em->getRepository(Tramo::class);
        $data = $em->getRepository(TipoTraslado::class)->findBy(['activo'=>true]);
        $precio_venta = $em->getRepository(PrecioVenta::class)->findBy(['activo'=>true]);
        $query = $repo->createQueryBuilder('p')
            ->where('p.activo = true')
            //->groupBy('p.origen')
            ->orderBy('p.precio', 'ASC')
            ->getQuery();
        $tramosOrenados = $query->getResult();
        $tramosNombres = [];
        $row = [];
        $info = [];

        $arrayProovedores = [];
        $listaProveedores = $proveedor_er->findBy(['activo'=>true]);

        /**@var $item Precio** */
        foreach ($listaProveedores as $item){
            $arrays = [];
            for ($i=0;$i < count($tramosOrenados);$i++){
                if ($tramosOrenados[$i]->getProveedor() == $item->getId()){
                    $arrays[count($arrays)] = array(
                        'tramos'=>$origen_er->find($tramosOrenados[$i]->getOrigen())->getNombre().'-'.$origen_er->find($tramosOrenados[$i]->getDestino())->getNombre(),
                        'tramo_id'=>$tramosOrenados[$i]->getId(),
                        'precio'=>$tramosOrenados[$i]->getPrecio(),
                        'tipo_vehiculo'=>$tipo_vehiculo_er->find($tramosOrenados[$i]->getVehiculo())->getNombre() ,
                        'tipo_traslado'=>$tipo_traslado_er->find($tramosOrenados[$i]->getTraslado())->getNombre(),
                        'id_vuelta'=>$tramosOrenados[$i]->getIdaVuelta()
                    );
                }
            }
            if (count($arrays) >= 1){
                $arrayProovedores[count($arrayProovedores)] = [
                    'tramo'=>$arrays,
                    'proveedor_nom'=>$item->getNombre(),
                    'proveedor_id'=>$item->getId()
                ];
            }

        }

        /**@var $item PrecioVenta** */
        foreach ($precio_venta as $item){
            $ida_vuelta = null;
            $tramo = $tramo_er->find($item->getTramo());
            if ($tramo->getIdaVuelta() == true){
                $ida_vuelta = 'Ida/Retorno';
            }
            else{
                $ida_vuelta = 'Ida';
            }
            $precioV = floatval($tramo->getPrecio());
            if ($item->getFijo() > 0){
                $precioV += floatval($item->getFijo());
            }
            elseif ($item->getPoerciento() > 0){
                $precioV += ($item->getPoerciento()/100)*$precioV;
            }

            $row [] = array(
                'id' => $item->getId(),
                'proveedor'=>$proveedor_er->find($tramo->getProveedor())->getNombre(),
                'proveedor_id'=>$tramo->getProveedor(),
                'tramo' => $origen_er->find($tramo->getOrigen())->getNombre().' - '.$origen_er->find($tramo->getDestino())->getNombre(),
                'tramo_id'=>$tramo->getId(),
                'ida_vuelta'=>$ida_vuelta,
                'vehiculo'=>$tipo_vehiculo_er->find($tramo->getVehiculo())->getNombre(),
                'traslado'=>$tipo_traslado_er->find($tramo->getTraslado())->getNombre(),
                'precio_venta'=>$precioV,
                'precio_costo'=>$tramo->getPrecio(),
                'porciento'=>$item->getPoerciento(),
                'fijo'=>$item->getFijo()

            );
        }

        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            9, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );



        return $this->render('turismo_module/traslado/precio_venta/index.html.twig', [
            'controller_name' => 'PrecioVentaController',
            'form' => $form->createView(),
            'precio_venta'=> $paginator,
            'data'=>$arrayProovedores,
            'jdata'=>json_encode($arrayProovedores),
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/tramo", name="turismo_module_traslado_precio_venta_tramo")
     */
    public function infoTramo(EntityManagerInterface $em,Request $request){
        $origen_er = $em->getRepository(Lugares::class);
        $tipo_vehiculo_er = $em->getRepository(TipoVehiculo::class);
        $tipo_traslado_er=$em->getRepository(TipoTraslado::class);
        $repo = $this->getDoctrine()->getRepository(Tramo::class);
        $query = $repo->createQueryBuilder('p')
            ->where('p.activo = true')
            //->groupBy('p.origen')
            ->orderBy('p.precio', 'ASC')
            ->getQuery();
        $tramosOrenados = $query->getResult();
        $id_pro = $request->get('id');
        $info = [];
        /**@var $item Tramo** */
        foreach ($tramosOrenados as $item){
            $arreglo =[];
            if ($item->getProveedor() == $id_pro){
                $ida_vuelta = null;
                if ($item->getIdaVuelta() == false){
                    $ida_vuelta = 'Ida';
                    }
                else{
                    $ida_vuelta = 'Ida y Retorno';
                }

                $arreglo[count($arreglo)] = [
                  'id_tramo'=>$item->getId(),
                  'tramos'=>$origen_er->find($item->getOrigen())->getNombre().' - '.$origen_er->find($item->getDestino())->getNombre(),
                  'precio'=>$item->getPrecio(),
                  'tVehiculo'=>$tipo_vehiculo_er->find($item->getVehiculo())->getNombre(),
                    'ida_vuelta'=>$ida_vuelta,
                  'tTraslado'=>$tipo_traslado_er->find($item->getTraslado())->getNombre(),

                ];
                $info[count($info)] = ['tramo'=>$arreglo];
            }
        }
        return new JsonResponse(['success' => true,'data'=>$info]);
    }

    /**
     * @Route("/add", name="turismo_module_traslado_precio_venta_add")
     */
    public function AddPrecioVenta(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(PrecioVenta::class);
        $tramo = $request->get('tramo');
        $porciento = floatval($request->get('porciento'));
        $fijo = floatval($request->get('fijo'));

        $params = array(
            'tramo'=>$tramo,
            'porciento'=>$porciento,
            'fijo'=>$fijo,
            'activo' => true
        );
        //return dd($params);
        //if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_PV = new PrecioVenta();

            $obj_PV
                ->setTramo($tramo)
                ->setPoerciento($porciento)
                ->setFijo($fijo)
                ->setActivo(true);
            try {
                $em->persist($obj_PV);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            $this->addFlash('success', "Precio de venta adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        /*}
        $this->addFlash('error', "El precio de venta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);*/
    }

    /**
     * @Route("/upd", name="turismo_module_traslado_precio_venta_upd")
     */
    public function Update(EntityManagerInterface $em, Request $request){
        $entity_repository = $em->getRepository(PrecioVenta::class);
        $tramo = $request->get('tramo');
        $porciento = floatval($request->get('porciento'));
        $fijo = floatval($request->get('fijo'));
        $id = $request->get('id');

        $params = array(
            'tramo'=>$tramo,
            'porciento'=>$porciento,
            'fijo'=>$fijo,
            'activo' => true
        );
        //if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id'))) {
            $obj_precioVenta = $entity_repository->find($id);
            /**@var $obj_precioVenta PrecioVenta**/
            $obj_precioVenta
                ->setTramo($tramo)
                ->setFijo($fijo)
                ->setPoerciento($porciento)
            ;
            try {
                $em->persist($obj_precioVenta);
                $em->flush();
                $this->addFlash('success', "Precio de venta actualizado satisfactoriamente");
                return new JsonResponse(['success' => true]);
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
            //$this->addFlash('success', "Precio de venta actualizado satisfactoriamente");
            //return new JsonResponse(['success' => true]);
        /*}
        $this->addFlash('error', "El precio de venta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);*/
    }

    /**
     * @Route("/delete/{id}", name="turismo_module_traslado_precio_venta_delete")
     */
    public function BorrarPV($id){
        $em = $this->getDoctrine()->getManager();
        $precioVenta_er = $em->getRepository(PrecioVenta::class);
        $precioVenta_obj = $precioVenta_er->find($id);
        $msg = 'No se pudo eliminar el precio de venta seleccionado';
        $success = 'error';
        if ($precioVenta_obj) {
            /**@var $precioVenta_obj PrecioVenta** */
            $precioVenta_obj->setActivo(false);
            try {
                $em->persist($precioVenta_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Precio de venta eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedor de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('turismo_module_traslado_precio_venta');
    }
}
