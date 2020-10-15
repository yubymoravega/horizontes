<?php

namespace App\Controller\Contabilidad\General;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovimientoCuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/movimiento-cuenta")
 */
class MovimientoCuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_movimiento_cuenta", methods={"POST","GET"})
     */
    public function index()
    {
        return $this->render('contabilidad/general/movimiento_cuenta/index.html.twig', [
            'controller_name' => 'MovimientoCuentaController',
        ]);
    }
}
