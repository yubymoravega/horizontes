<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TransferenciaController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/transferencia", name="contabilidad_inventario_transferencia")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/transferencia/index.html.twig', [
            'controller_name' => 'TransferenciaController',
        ]);
    }
}
