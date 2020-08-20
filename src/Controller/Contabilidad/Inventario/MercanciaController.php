<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MercanciaController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/mercancia", name="contabilidad_inventario_mercancia")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/mercancia/index.html.twig', [
            'controller_name' => 'MercanciaController',
        ]);
    }
}
