<?php

namespace App\Controller\Contabilidad;

use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                ['title' => 'Centro Costo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Cuenta', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Elemento de Gasto', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Grupo Activo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Instrumento Cobro', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Modulo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Moneda', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tasa Cambio', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Documento Activo Fijo', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Tipo Movimiento', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad', 'descrip' => 'Descripcion de prueba....'],
                ['title' => 'Unidad Medida', 'descrip' => 'Descripcion de prueba....'])

        ]);
    }

    /**
     * @Route("/rootuser",name="register-dev-rootuser")
     */
    public function UserRoot(EntityManagerInterface $em, UserPasswordEncoderInterface $passEncoder)
    {
        try {
            $user = new User();
            $user->setRoles(['ROLE_ADMIN'])
                ->setUsername('root')
                ->setStatus(true)
                ->setPassword($passEncoder->encodePassword($user, '123'));
            $em->persist($user);
            $cargo = new Cargo();
            $cargo
                ->setNombre('Administrador del Sistema')
                ->setSalarioBase(1000)
                ->setActivo(true);
            $em->persist($cargo);
            $unidad = new Unidad();
            $unidad
                ->setNombre('Grupo Horizontes Admin')
                ->setActivo(true);
            $em->persist($unidad);
            $empleado = new Empleado();
            $empleado
                ->setNombre($user->getUsername())
                ->setIdUnidad($unidad)
                ->setIdUsuario($user)
                ->setActivo(true)
                ->setRol('ROLE_ADMIN')
                ->setDireccionParticular('Calle A')
                ->setIdCargo($cargo)
                ->setSalarioXHora(100)
                ->setCorreo('admin@solyag.com')
                ->setTelefono('555555555')
                ->setBaja(false)
                ->setFechaAlta(\DateTime::createFromFormat('Y-m-d', '2020-10-28'));
            $em->persist($empleado);
            $em->flush();
        } catch (\Exception $err) {
            return new JsonResponse(['msg'=>$err->getMessage()]);
        }
        return new JsonResponse(['success'=>true]);
    }
}

