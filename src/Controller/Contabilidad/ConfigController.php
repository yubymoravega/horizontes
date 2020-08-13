<?php

namespace App\Controller\Contabilidad;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ConfigController extends AbstractController
{

    /**
     * @Route("/contabilidad/config", name="config")
     */
    public function index()
    {

        return $this->render('contabilidad/config/index.html.twig', [
            'controller_name' => 'Dashboard',
            'config' => array(
                ['title' => 'Config inicial', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Almacén', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Centro Costo', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Cuenta', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Elemento de Gasto', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Grupo Activo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Instrumento Cobro', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Modulo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Moneda', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Subcuenta', 'descrip' => 'Descripcion de prueba....'],
                //['title' => 'Tasa Cambio', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento Activo Fijo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Movimiento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad Medida', 'descrip' => 'Descripcion de prueba....'])

        ]);
    }

    /**
     * @Route("/register-dev-rootuser",name="register-dev-rootuser")
     */
    public function UserRoot(EntityManagerInterface $em, UserPasswordEncoderInterface $passEncoder)
    {
        try {
            $user = new User();
            $user->setRoles(['ROLE_ADMIN'])
                ->setUsername('root')
                ->setPassword($passEncoder->encodePassword($user, '123'));
            $em->persist($user);
            $em->flush();
        } catch (\Exception $err) {
            return $err;
        }

    }
}

