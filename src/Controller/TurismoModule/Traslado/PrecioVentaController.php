<?php

namespace App\Controller\TurismoModule\Traslado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller\TurismoModule\Traslado
 * @Route("/turismo/module/traslado/precio-venta")
 */
class PrecioVentaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_traslado_precio_venta")
     */
    public function index()
    {

        return $this->render('turismo_module/traslado/precio_venta/index.html.twig', [
            'controller_name' => 'PrecioVentaController',
        ]);
    }
}
