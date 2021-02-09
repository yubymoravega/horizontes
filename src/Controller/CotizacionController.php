<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CotizacionController
 * @package App\Controller
 * @Route("/cotizacion")
 */
class CotizacionController extends AbstractController
{
    /**
     * @Route("/", name="cotizacion")
     */
    public function index()
    {
        return $this->render('cotizacion/index.html.twig', [
            'controller_name' => 'CotizacionController',
        ]);
    }
}
