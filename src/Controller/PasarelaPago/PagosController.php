<?php

namespace App\Controller\PasarelaPago;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PagosController
 * @package App\Controller\PasarelaPago
 * @Route("/pasarela-pago")
 */
class PagosController extends AbstractController
{
    /**
     * @Route("/{id_cotizacion}", name="pasarela_pago_pagos")
     */
    public function index($id_cotizacion)
    {
        return $this->render('pasarela_pago/pagos/index.html.twig', [
        'id_cotizacion'=>$id_cotizacion
        ]);
    }
}
