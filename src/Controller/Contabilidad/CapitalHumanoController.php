<?php

namespace App\Controller\Contabilidad;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CapitalHumanoController extends AbstractController
{

    /**
     * @Route("/contabilidad/capital-humano", name="capital_humano")
     */
    public function index()
    {

        return $this->render('contabilidad/capital_humano/index.html.twig', [
            'controller_name' => 'Dashboard',
            'config' => array(
                ['title' => 'Empleado', 'descrip' => 'Descripcion de prueba....'],)
        ]);
    }
}

