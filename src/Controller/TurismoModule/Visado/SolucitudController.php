<?php

namespace App\Controller\TurismoModule\Visado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SolucitudController extends AbstractController
{
    /**
     * @Route("/turismo/module/visado/solucitud", name="turismo_module_visado_solucitud")
     */
    public function index()
    {
        return $this->render('turismo_module/visado/solucitud/index.html.twig', [
            'controller_name' => 'SolucitudController',
        ]);
    }
}
