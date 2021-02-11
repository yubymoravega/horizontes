<?php

namespace App\Controller\TurismoModule\Traslado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TipoVehiculoController
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/configuracion-turismo/traslado/tipo-vehiculo")
 */
class TipoVehiculoController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_tipo_vehiculo")
     */
    public function index()
    {
        return $this->render('turismo_module/traslado/tipo_vehiculo/index.html.twig', [
            'controller_name' => 'TipoVehiculoController',
        ]);
    }
}
