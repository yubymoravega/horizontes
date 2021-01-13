<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SubmayorVacacionesController extends AbstractController
{
    /**
     * @Route("/contabilidad/capital/humano/submayor/vacaciones", name="contabilidad_capital_humano_submayor_vacaciones")
     */
    public function index()
    {
        return $this->render('contabilidad/capital_humano/submayor_vacaciones/index.html.twig', [
            'controller_name' => 'SubmayorVacacionesController',
        ]);
    }
}
