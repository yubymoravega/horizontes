<?php

namespace App\Controller\TurismoModule;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrasladoController extends AbstractController
{
    /**
     * @Route("/turismo/module/traslado", name="turismo_module_traslado")
     */
    public function index()
    {
        return $this->render('turismo_module/traslado/index.html.twig', [
            'controller_name' => 'TrasladoController',
        ]);
    }
}
