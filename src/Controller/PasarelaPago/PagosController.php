<?php

namespace App\Controller\PasarelaPago;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PagosController extends AbstractController
{
    /**
     * @Route("/pasarela/pago/pagos", name="pasarela_pago_pagos")
     */
    public function index()
    {
        return $this->render('pasarela_pago/pagos/index.html.twig', []);
    }
}
