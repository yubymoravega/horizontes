<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ValeSalidaController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/vale_salida", name="contabilidad_inventario_vale_salida")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/vale_salida/index.html.twig', [
            'controller_name' => 'ValeSalidaController',
        ]);
    }
}
