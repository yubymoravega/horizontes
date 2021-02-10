<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EfectivoController extends AbstractController
{
    /**
     * @Route("/pasarela/pago/pagos/efectivo", name="pasarela_pago_pagos_efectivo")
     */
    public function index()
    {
        return $this->render('pasarela_pago/pagos/efectivo/index.html.twig', [
            'controller_name' => 'EfectivoController',
        ]);
    }
}
