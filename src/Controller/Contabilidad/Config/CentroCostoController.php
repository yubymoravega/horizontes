<?php

namespace App\Controller\Contabilidad\Config;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CentroCostoController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/centro/costo", name="contabilidad_config_centro_costo")
     */
    public function index()
    {
        return $this->render('contabilidad/config/centro_costo/index.html.twig', [
            'controller_name' => 'CentroCostoController',
        ]);
    }
}
