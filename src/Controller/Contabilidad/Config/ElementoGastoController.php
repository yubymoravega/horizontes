<?php

namespace App\Controller\Contabilidad\Config;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ElementoGastoController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/elemento/gasto", name="contabilidad_config_elemento_gasto")
     */
    public function index()
    {
        return $this->render('contabilidad/config/elemento_gasto/index.html.twig', [
            'controller_name' => 'ElementoGastoController',
        ]);
    }
}
