<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovimientoController extends AbstractController
{
    /**
     * @Route("/contabilidad/activo-fijo-movimiento", name="contabilidad_activo_fijo_movimiento")
     */
    public function index()
    {
        return $this->render('contabilidad/activo_fijo/movimiento/index.html.twig', [
            'controller_name' => 'MovimientoController',
        ]);
    }
}
