<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Cargo;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\User;
use App\Form\Contabilidad\CapitalHumano\EmpleadoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

class EmpleadoController extends AbstractController
{
    /**
     * @Route("/contabilidad/capital-humano/empleado", name="contabilidad_capital_humano_empleado")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Environment $env)
    {
        $form = $this->createForm(EmpleadoType::class);

        $empleado_arr = $em->getRepository(Empleado::class)->findByActivo(true);
        $row = [];
        foreach ($empleado_arr as $item) {
            /**@var $item Empleado** */
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'correo' => $item->getCorreo(),
                'cargo_nombre' => $item->getIdCargo() ? $item->getIdCargo()->getNombre() : '',
                'rol_nombre' => $item->getRol() ? $item->getRol() : '',
                'salario_x_hora' => $item->getSalarioXHora(),
                'telefono' => $item->getTelefono(),
                'id_cargo' => $item->getIdCargo() ? $item->getIdCargo()->getId() : '',
                'is_usuario' => $item->getIdUsuario() ? true : false,
                'id_unidad' => $item->getIdUnidad() ? $item->getIdUnidad()->getId() : '',
                'unidad_nombre' => $item->getIdUnidad() ? $item->getIdUnidad()->getNombre() : '',
                'direccion' => $item->getDireccionParticular(),
//                'fecha_alta' => $item->getFechaAlta()
                'fecha_alta' => '12-12-2020'
            );
        }
        $callback = 'contabilidad/capital_humano/empleado/index.html.twig';
//
        return $this->render($callback, [
            'controller_name' => 'EmpleadoController',
            'empleados' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/capital-humano/empleado-add", name="contabilidad_capital_humano_empleado_add")
     */
    public function addEmplpeado(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $passEncoder)
    {
//        dd('dsdsds');
        $entity_repository = $em->getRepository(Empleado::class);
        $params = array(
            'correo' => $request->get('correo'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_empleado = new Empleado();
            //---ADICIONO EL EMPLEADO
            $obj_empleado
                ->setNombre($request->get('nombre'))
                ->setCorreo($request->get('correo'))
                ->setTelefono($request->get('telefono'))
//                ->setFechaAlta($request->get('fecha_alta'))
                ->setSalarioXHora(floatval($request->get('salario_x_hora')))
                ->setIdUnidad($em->getRepository(Unidad::class)->find($request->get('id_unidad')))
                ->setIdCargo($em->getRepository(Cargo::class)->find($request->get('id_cargo')))
                ->setDireccionParticular($request->get('direccion'))
                ->setBaja(false)
                ->setAcumuladoTiempoVacaciones(0)
                ->setAcumuladoDineroVacaciones(0)
                ->setRol($request->get('rol'))
                ->setActivo(true);

            if ($request->get('is_usuario') && $request->get('is_usuario') == 1) {
                //-------ADICIONO EL USUARIO
                $obj_usuario = new User();
                $arr_role [0] = $request->get('rol');
                $obj_usuario
                    ->setUsername($request->get('correo'))
                    ->setRoles($arr_role)
                    ->setStatus(true);
            }
            try {
                if ($request->get('is_usuario') && $request->get('is_usuario') == 1) {
                    $em->persist($obj_usuario);
                    $password = AuxFunctions::generateRandomPassword();
                    $obj_usuario->setPassword($passEncoder->encodePassword($obj_usuario, $password));
                    $obj_empleado->setIdUsuario($obj_usuario);

                    $msg = "Felicitaciones es usted miembro de nuestro equipo de trabajo, use la siguiente dirección para acceder al sistema www.google.com, su usuario es: ".$request->get('correo')." y su contraseña: ".$password;
                    AuxFunctions::sendEmail('Credenciales del sistema',$request->get('correo'),$request->get('nombre'),$msg);
                }
                $em->persist($obj_empleado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Empleado adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El correo ya se encuentra registrado en el sistema");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/capital-humano/empleado-upd", name="contabilidad_capital_humano_empleado_upd")
     */
    public function updEmpleado(EntityManagerInterface $em, Request $request, ValidatorInterface $validator,UserPasswordEncoderInterface $passEncoder)
    {
        $entity_repository = $em->getRepository(Empleado::class);
        $params = array(
            'correo' => $request->get('correo'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_empleado'))) {
            /**@var $obj_empleado Empleado** */
            $obj_empleado = $em->getRepository(Empleado::class)->find($request->get('id_empleado'));
            if (!$obj_empleado) {
                $this->addFlash('error', "El empleado no se encuentra en la base de datos");
                return new JsonResponse(['success' => true]);
            }
            $old_email = $obj_empleado->getCorreo();
            $obj_empleado
                ->setNombre($request->get('nombre'))
                ->setCorreo($request->get('correo'))
                ->setTelefono($request->get('telefono'))
//                ->setFechaAlta($request->get('fecha_alta'))
                ->setSalarioXHora(floatval($request->get('salario_x_hora')))
                ->setIdUnidad($em->getRepository(Unidad::class)->find($request->get('id_unidad')))
                ->setIdCargo($em->getRepository(Cargo::class)->find($request->get('id_cargo')))
                ->setDireccionParticular($request->get('direccion'))
                ->setBaja(false)
                ->setAcumuladoTiempoVacaciones(0)
                ->setAcumuladoDineroVacaciones(0)
                ->setRol($request->get('rol'))
                ->setActivo(true);

            //obtengo el usuario en caso de que exista
            $obj_usuario = $em->getRepository(User::class)->findOneByUsername($old_email);

            if ($request->get('is_usuario') && $request->get('is_usuario') == 1) {
                $arr_role [0] = $request->get('rol');
                if (!$obj_usuario) {
                    $obj_usuario = new User();
                    $obj_usuario->setPassword($passEncoder->encodePassword($obj_usuario, 'prueba'));
                }
                /**@var $obj_usuario User* */
                $obj_usuario
                    ->setUsername($request->get('correo'))
                    ->setRoles($arr_role)
                    ->setStatus(true);

            } else {
                if ($obj_usuario)
                    $obj_usuario
                        ->setStatus(false);
                $obj_empleado->setRol(null);
            }
            try {

                if ($request->get('is_usuario') && $request->get('is_usuario') == 1) {
                    $em->persist($obj_usuario);
                    $obj_empleado->setIdUsuario($obj_usuario);
                }
                $em->persist($obj_empleado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Empleado actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El correo ya se encuentra registrado en el sistema");
        return new JsonResponse(['success' => false]);
    }


    /**
     * @Route("/contabilidad/capital-humano/empleado-delete/{id}", name="contabilidad_capital_humano_empleado_delete")
     */
    public function deleteEmpleado($id)
    {
        $em = $this->getDoctrine()->getManager();
        $empleado_er = $em->getRepository(Empleado::class);
        $empleado_obj = $empleado_er->find($id);
        $msg = 'No se pudo dar baja al empleado seleccionado';
        $success = 'error';
        if ($empleado_obj) {
            /**@var $empleado_obj Empleado** */
            $empleado_obj->setActivo(false);
            if ($empleado_obj->getIdUsuario())
                $obj_user = $empleado_obj->getIdUsuario()->setStatus(false);
            try {
                $em->persist($empleado_obj);
                if ($empleado_obj->getIdUsuario())
                    $em->persist($obj_user);
                $em->flush();
                $success = 'success';
                $msg = 'Empleado dado de baja satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_capital_humano_empleado');
    }

}
