<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Entity\TurismoModule\Utils\UserClientTmp;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Form\TurismoModule\Visado\SolicitudType;
use ContainerT8tBbGS\getReporteEfectivoRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SolucitudController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/turismo/gestion-consular/solucitud")
 */
class SolucitudController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_solucitud")
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(SolicitudType::class);
        $elementos = $em->getRepository(ElementosVisa::class)->findBy(['activo' => true]);
        $costo_bisado = 0;

        $unidad = AuxFunctions::getUnidad($em, $this->getUser());

        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
        ]);

        $precio_total = 0;
        if ($configuraciones) {
            $precio_total = $configuraciones->getPrecioVentaTotal();
        }


        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em, $this->getUser());
        $nombre = $obj_cliente->getNombre();
        return $this->render('turismo_module/visado/solucitud/index.html.twig', [
            'controller_name' => 'SolucitudController',
            'formulario' => $form->createView(),
            'telefono' => $obj_cliente->getTelefono(),
            'nombre' => $nombre,
            'apellidos' => $obj_cliente->getApellidos(),
            'correo' => $obj_cliente->getCorreo(),
            'direccion' => $obj_cliente->getDireccion(),
            'id_cliente' => $obj_cliente->getId(),
            'precio_total_text' => number_format($precio_total, 2),
            'precio_total' => $precio_total
        ]);
    }


    /**
     * @Route("/add-carrito", name="turismo_module_visado_solucitud_add_carrito")
     */
    public function addCarrito(EntityManagerInterface $em, Request $request)
    {
        $id_servicio = AuxFunctionsTurismo::IDENTIFICADOR_VISADO;
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $moneda = $request->request->get('moneda');
        /** @var UserClientTmp $obj_trabajo_tmp */
        $obj_trabajo_tmp = $em->getRepository(UserClientTmp::class)->findOneBy([
            'id_usuario' => $this->getUser()
        ]);

        $empleado = $obj_trabajo_tmp->getIdUsuario()->getUsername();

        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
        ]);

        $precio_total = 0;
        if ($configuraciones) {
            $precio_total = $configuraciones->getPrecioVentaTotal();
        }

        $data_new_solicitudes = json_decode($request->request->get('solicitudes'), true);
        $data_solicitudes_existente = AuxFunctionsTurismo::getDataJsonCarrito($em, $empleado, $id_servicio);

        $data_solicitudes = array_merge($data_new_solicitudes, $data_solicitudes_existente);

        foreach ($data_solicitudes as $key=>$item){
            if(gettype($data_solicitudes[$key])=='array'){
                $data_solicitudes[$key]['idCarrito'] = $key;
                $data_solicitudes[$key]['nombreMostrar'] = $data_solicitudes[$key]['nombre'] .' '. $data_solicitudes[$key]['primer_apellido'];
                $data_solicitudes[$key]['montoMostrar'] = $precio_total;
            }
            else{
                $data_solicitudes[$key]->idCarrito = $key;
                $data_solicitudes[$key]->nombreMostrar = $data_solicitudes[$key]->nombre .' '. $data_solicitudes[$key]->primer_apellido;
                $data_solicitudes[$key]->montoMostrar = $precio_total;
            }
        }
        //-- CONSTRUYO EL JSON PARA ADICIONAR AL CARRITO
        $json = array(
            'id_empleado' => $obj_trabajo_tmp->getIdUsuario()->getId(),
            'id_cliente' => $obj_trabajo_tmp->getIdCliente()->getId(),
            'id_servicio' => $id_servicio,
            'nombre_servicio' => $em->getRepository(Servicios::class)->find($id_servicio)->getNombre(),
            'precio_servicio' => $precio_total,
            'id_moneda' => $moneda,
            'total' => $precio_total * count($data_solicitudes),
            'data' => $data_solicitudes,
        );

        if (!empty($data_solicitudes_existente)) {
            $new_element_carrito = $em->getRepository(Carrito::class)->find(AuxFunctionsTurismo::getIdCarritoServicio($em, $empleado, $id_servicio));
        } else {
            $new_element_carrito = new Carrito();
        }
        $new_element_carrito
            ->setEmpleado($empleado)
            ->setJson($json);

        $em->persist($new_element_carrito);
        $em->flush();

        $this->addFlash('success', 'Solicitud adicionada al carrito');

        return  $this->redirectToRoute('categorias/turismo',['tel'=>$obj_trabajo_tmp->getIdCliente()->getTelefono()] );
    }

    /**
     * @Route("/delete-carrito", name="turismo_module_visado_solucitud_delete_carrito")
     */
    public function deletCarrito(EntityManagerInterface $em, Request $request)
    {
        $ruta = $request->request->get('path');
        $id = $request->request->get('idCarrito');
        $id_servicio = $request->request->get('id_servicio');
        /** @var UserClientTmp $obj_trabajo_tmp */
        $obj_trabajo_tmp = $em->getRepository(UserClientTmp::class)->findOneBy([
            'id_usuario' => $this->getUser()
        ]);
        $empleado = $obj_trabajo_tmp->getIdUsuario()->getUsername();

        $array_result = [];
        $data_solicitudes_existente = AuxFunctionsTurismo::getDataJsonCarrito($em, $empleado, $id_servicio);

        $total_servicio = 0;
        foreach ($data_solicitudes_existente as $key => $item) {
            if ($id != $item['idCarrito']) {
                $array_result[] = $data_solicitudes_existente[$key];
//                $array_result[count($array_result)-1]->idCarito=count($array_result)-1;
                $total_servicio += floatval($item['montoMostrar']);
            }
        }
        foreach ($array_result as $key=>$elemt){
            $array_result[$key]['idCarrito'] = $key;
        }

        $id_carrito = AuxFunctionsTurismo::getIdCarritoServicio($em, $empleado, $id_servicio);
        $obj_carrito = $em->getRepository(Carrito::class)->find($id_carrito);
        $json = $obj_carrito->getJson();
        $precio_servicio = floatval($json['precio_servicio']);

        $json_updated = array(
            'id_empleado' => $obj_trabajo_tmp->getIdUsuario()->getId(),
            'id_cliente' => $obj_trabajo_tmp->getIdCliente()->getId(),
            'id_servicio' => $id_servicio,
            'nombre_servicio' => $em->getRepository(Servicios::class)->find($id_servicio)->getNombre(),
            'precio_servicio' => $precio_servicio,
            'total' => $total_servicio,
            'data' => $array_result,
        );

        if(!empty($array_result)){
            $obj_carrito->setJson($json_updated);
            $em->persist($obj_carrito);
        }
        else{
            $em->remove($obj_carrito);
        }
        $em->flush();
        return $this->redirect($ruta);
    }
}
