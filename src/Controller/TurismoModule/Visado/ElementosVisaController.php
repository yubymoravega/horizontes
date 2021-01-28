<?php

namespace App\Controller\TurismoModule\Visado;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ElementosVisaController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/turismo/visado/elementos-visa")
 */
class ElementosVisaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_elementos_visa")
     */
    public function index()
    {
        return $this->render('turismo_module/visado/elementos_visa/index.html.twig', [
            'controller_name' => 'ElementosVisaController',
        ]);
    }
}
