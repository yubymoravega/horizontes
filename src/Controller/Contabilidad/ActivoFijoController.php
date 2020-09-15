<?php

namespace App\Controller\Contabilidad;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ActivoFijoController extends AbstractController
{

    /**
     * @Route("/contabilidad/activo-fijo", name="activo_fijo")
     */
    public function index()
    {

        return $this->render('contabilidad/activo_fijo/index.html.twig', [
            'controller_name' => 'Dashboard'
        ]);
    }
}

