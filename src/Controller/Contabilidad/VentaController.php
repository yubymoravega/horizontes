<?php

namespace App\Controller\Contabilidad;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VentaController
 * @package App\Controller\Contabilidad
 * @Route("/contabilidad/venta")
 */
class VentaController extends AbstractController
{

    /**
     * @Route("/", name="venta")
     */
    public function index()
    {

        return $this->render('contabilidad/venta/index.html.twig', [
            'controller_name' => 'Dashboard'
        ]);
    }
}

