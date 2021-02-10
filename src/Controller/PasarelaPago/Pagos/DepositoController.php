<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DepositoController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/deposito")
 */
class DepositoController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_deposito")
     */
    public function index($id_cotizacion)
    {
        return $this->render('pasarela_pago/pagos/deposito/index.html.twig', [
            'controller_name' => 'DepositoController',
            'id_cotizacion'=>$id_cotizacion
        ]);
    }
}
