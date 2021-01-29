<?php

namespace App\Controller\TurismoModule;

use App\Entity\Cliente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VisadoController
 * @package App\Controller\TurismoModule
 * @Route("/turismo")
 */
class VisadoController extends AbstractController
{
//    /**
//     * @Route("/visado", name="turismo_module_visado")
//     */
//    public function index(Request $request)
//    {
//        $telefono = $request->request->get('telefono_cliente');
//        $nombre = $request->request->get('nombre_cliente');
//        $apellidos = $request->request->get('apellidos_cliente');
//        $correo = $request->request->get('correo_cliente');
//        $direccion = $request->request->get('direccion_cliente');
//        $id_cliente = $request->request->get('id_cliente_cliente');
//
//        return $this->render('turismo_module/visado/index.html.twig', [
//            'controller_name' => 'VisadoController',
//            'telefono'=>$telefono,
//            'nombre'=> $nombre,
//            'apellidos'=>$apellidos,
//            'correo'=>$correo,
//            'direccion'=>$direccion,
//            'id_cliente'=>$id_cliente
//        ]);
//    }
    /**
     * @Route("/gestion-consular", name="turismo_module")
     */
    public function indexDashboard(EntityManagerInterface $em,Request $request)
    {
        $telefono = $request->request->get('telefono');
        /** @var Cliente $cliente */
        $cliente = $em->getRepository(Cliente::class)->findOneBy([
            'telefono'=>$telefono,
        ]);
        return $this->render('turismo_module/visado/index.html.twig', [
            'controller_name' => 'TurismoController',
            'telefono'=>$telefono,
            'nombre'=> $cliente->getNombre(),
            'apellidos'=>$cliente->getApellidos(),
            'correo'=>$cliente->getCorreo(),
            'direccion'=>$cliente->getDireccion(),
            'id_cliente'=>$cliente->getId()
        ]);
    }
}
