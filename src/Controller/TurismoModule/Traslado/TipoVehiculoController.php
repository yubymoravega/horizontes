<?php

namespace App\Controller\TurismoModule\Traslado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TipoVehiculoController extends AbstractController
{
    /**
     * @Route("/turismo/module/traslado/tipo/vehiculo", name="turismo_module_traslado_tipo_vehiculo")
     */
    public function index()
    {
        return $this->render('turismo_module/traslado/tipo_vehiculo/index.html.twig', [
            'controller_name' => 'TipoVehiculoController',
        ]);
    }
}
