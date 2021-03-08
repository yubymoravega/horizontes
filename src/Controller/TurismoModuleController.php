<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TurismoModuleController
 * @package App\Controller
 * @Route("/configuracion-turismo")
 */
class TurismoModuleController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_configuracion")
     */
    public function index()
    {
        return $this->render('turismo_module/index.html.twig', [
            'controller_name' => 'TurismoModuleController',
        ]);
    }
}
