<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AjusteController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/ajuste", name="contabilidad_inventario_ajuste")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/ajuste/index.html.twig', [
            'controller_name' => 'AjusteController',
        ]);
    }
}
