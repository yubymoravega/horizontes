<?php

namespace App\Controller\Reportes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FacturasStripeController extends AbstractController
{
    /**
     * @Route("/reportes/facturas/stripe", name="reportes_facturas_stripe")
     */
    public function index()
    {
        return $this->render('reportes/facturas_stripe/index.html.twig', [
            'controller_name' => 'FacturasStripeController',
        ]);
    }
}
