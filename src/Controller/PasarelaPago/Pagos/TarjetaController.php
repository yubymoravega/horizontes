<?php

namespace App\Controller\PasarelaPago\Pagos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TarjetaController
 * @package App\Controller\PasarelaPago\Pagos
 * @Route("/pasarela-pago/tarjeta")
 */
class TarjetaController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos_tarjeta")
     */
    public function index($id_cotizacion)
    {
        return $this->render('pasarela_pago/pagos/tarjeta/index.html.twig', [
            'controller_name' => 'TarjetaController',
            'id_cotizacion'=>$id_cotizacion
        ]);
    }
}
