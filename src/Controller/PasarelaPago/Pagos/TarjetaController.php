<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TarjetaController extends AbstractController
{
    /**
     * @Route("/pasarela/pago/pagos/tarjeta", name="pasarela_pago_pagos_tarjeta")
     */
    public function index()
    {
        return $this->render('pasarela_pago/pagos/tarjeta/index.html.twig', [
            'controller_name' => 'TarjetaController',
        ]);
    }
}
