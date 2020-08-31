<?php

namespace App\Controller\Contabilidad;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GeneralController extends AbstractController
{

    /**
     * @Route("/contabilidad/general", name="general")
     */
    public function index()
    {

        return $this->render('contabilidad/general/index.html.twig', [
            'controller_name' => 'Dashboard',
            'obligaciones'=>array()
        ]);
    }
}

