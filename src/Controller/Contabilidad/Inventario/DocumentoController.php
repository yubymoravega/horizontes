<?php

namespace App\Controller\Contabilidad\Inventario;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentoController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/documento", name="contabilidad_inventario_documento")
     */
    public function index()
    {
        return $this->render('contabilidad/inventario/documento/index.html.twig', [
            'controller_name' => 'DocumentoController',
        ]);
    }
}
