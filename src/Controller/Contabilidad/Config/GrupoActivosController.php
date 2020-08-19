<?php

namespace App\Controller\Contabilidad\Config;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GrupoActivosController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/grupo-activos", name="contabilidad_config_grupo_activos")
     */
    public function index()
    {
        return $this->render('contabilidad/config/grupo_activos/index.html.twig', [
            'controller_name' => 'GrupoActivosController',
        ]);
    }
}
