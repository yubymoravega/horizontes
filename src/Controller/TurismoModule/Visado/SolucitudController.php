<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Carrito;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Entity\TurismoModule\Utils\UserClientTmp;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Form\TurismoModule\Visado\ElementosVisaType;
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
        $elementos = $em->getRepository(ElementosVisa::class)->findBy(['activo'=>true]);
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
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $nombre = $obj_cliente->getNombre();
        return $this->render('turismo_module/visado/solucitud/index.html.twig', [
            'controller_name' => 'SolucitudController',
            'formulario'=>$form->createView(),
            'telefono'=>$obj_cliente->getTelefono(),
            'nombre'=>$nombre ,
            'apellidos'=>$obj_cliente->getApellidos(),
            'correo'=>$obj_cliente->getCorreo(),
            'direccion'=>$obj_cliente->getDireccion(),
            'id_cliente'=>$obj_cliente->getId(),
            'precio_total_text'=>number_format($precio_total,2),
            'precio_total'=>$precio_total
        ]);
    }


    /**
     * @Route("/add-carrito", name="turismo_module_visado_solucitud_add_carrito")
     */
    public function addCarrito(EntityManagerInterface $em, Request $request){
        $id_servicio = AuxFunctionsTurismo::IDENTIFICADOR_VISADO;
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());

        /** @var UserClientTmp $obj_trabajo_tmp */
        $obj_trabajo_tmp = $em->getRepository(UserClientTmp::class)->findOneBy([
            'id_usuario'=>$this->getUser()
        ]);

        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
        ]);

        $precio_total = 0;
        if ($configuraciones) {
            $precio_total = $configuraciones->getPrecioVentaTotal();
        }

        $data_solicitudes = json_decode($request->request->get('solicitudes'), true);

        //-- CONSTRUYO EL JSON PARA ADICIONAR AL CARRITO
        $json = array(
            'id_empleado'=>$obj_trabajo_tmp->getIdUsuario()->getId(),
            'id_cliente'=>$obj_trabajo_tmp->getIdCliente()->getId(),
            'id_servicio'=>$id_servicio,
            'precio_servicio'=> $precio_total,
            'total'=>$precio_total*count($data_solicitudes),
            'data'=>$data_solicitudes,
        );

        $new_element_carrito = new Carrito();
        $new_element_carrito
            ->setEmpleado($obj_trabajo_tmp->getIdUsuario()->getUsername())
            ->setJson(json_encode($json));

        $em->persist($new_element_carrito);
        $em->flush();

        $this->addFlash('success','Solicitud adicionada al carrito');

        return $this->redirectToRoute('turismo_module');
    }
}
