<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovimientoActivoFijoController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo/fijo/movimiento/activo/fijo")
 */
class MovimientoActivoFijoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_movimiento_activo_fijo")
     */
    public function index()
    {
        return $this->render('contabilidad/activo_fijo/movimiento_activo_fijo/index.html.twig', [
            'controller_name' => 'MovimientoActivoFijoController',
        ]);
    }
}
