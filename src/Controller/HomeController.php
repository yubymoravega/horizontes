<?php

namespace App\Controller;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('home/index.html.twig');
  
    }
}
