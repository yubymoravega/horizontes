<?php

namespace App\Controller\Contabilidad;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InventarioController extends AbstractController
{

    /**
     * @Route("/contabilidad/inventario", name="inventario")
     */
    public function index()
    {

        return $this->render('contabilidad/inventario/index.html.twig', [
            'controller_name' => 'Dashboard',
            'config' => array(
                ['title' => 'Ejemplo', 'descrip' => 'Descripcion de prueba....'],)
        ]);
    }
}

