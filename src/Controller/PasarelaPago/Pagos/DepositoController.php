<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DepositoController extends AbstractController
{
    /**
     * @Route("/pasarela/pago/pagos/deposito", name="pasarela_pago_pagos_deposito")
     */
    public function index()
    {
        return $this->render('pasarela_pago/pagos/deposito/index.html.twig', [
            'controller_name' => 'DepositoController',
        ]);
    }
}
