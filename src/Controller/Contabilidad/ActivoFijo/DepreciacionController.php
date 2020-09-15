<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DepreciacionController extends AbstractController
{
    /**
     * @Route("/contabilidad/activo-fijo-depreciacion", name="contabilidad_activo_fijo_depreciacion")
     */
    public function index()
    {
        return $this->render('contabilidad/activo_fijo/depreciacion/index.html.twig', [
            'controller_name' => 'DepreciacionController',
        ]);
    }
}
