<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Form\TurismoModule\Visado\ElementosVisaType;
use App\Form\TurismoModule\Visado\SolicitudType;
use ContainerT8tBbGS\getReporteEfectivoRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        //$

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
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }
}
