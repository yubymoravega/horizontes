<?php

namespace App\Controller\TurismoModule\Visado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegistroSolicitudesController extends AbstractController
{
    /**
     * @Route("/turismo/module/visado/registro/solicitudes", name="turismo_module_visado_registro_solicitudes")
     */
    public function index()
    {
        return $this->render('turismo_module/visado/registro_solicitudes/index.html.twig', [
            'controller_name' => 'RegistroSolicitudesController',
        ]);
    }
}
