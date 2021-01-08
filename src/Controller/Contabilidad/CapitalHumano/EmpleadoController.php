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
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

/**
 * Class EmpleadoController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/empleado")
 */
class EmpleadoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_empleado")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Environment $env)
    {
        $form = $this->createForm(EmpleadoType::class);

        $callback = 'contabilidad/capital_humano/empleado/index.html.twig';
        $roles = self::getRoles();
        return $this->render($callback, [
            'controller_name' => 'EmpleadoController',
            'form' => $form->createView(),
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/getEmpleadoByNombre/{nombre}", name="contabilidad_capital_humano_empleado_by_nombre")
     */
    public function getEmpleadoByNombre(EntityManagerInterface $em, $nombre)
    {
        $obj_unidad= AuxFunctions::getUnidad($em,$this->getUser());
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy([
           'nombre'=>$nombre,
           'id_unidad'=>$obj_unidad
        ]);

        return new JsonResponse([
            'id' => $empleado?$empleado->getId():'',
            'nombre' => $empleado?$empleado->getNombre():'',
            'correo' => $empleado?$empleado->getCorreo():'',
            'telefono' => $empleado?$empleado->getTelefono():'',
            'fecha_alta' => $empleado?$empleado->getFechaAlta()->format('d/m/Y'):'',
            'identificacion' => $empleado?$empleado->getIdentificacion():'',
            'id_unidad' => $empleado?$empleado->getIdUnidad()->getId():'',
            'direccion' => $empleado?$empleado->getDireccionParticular():'',
            'rol' => $empleado?$empleado->getRol():'',
            'is_user' => $empleado&&$empleado->getRol()?true:false,
            'success' => true
        ]);
    }
    /**
     * @Route("/getEmpleadoByIdentificacion/{identificacion}", name="contabilidad_capital_humano_empleado_by_identificacion")
     */
    public function getEmpleadoByIdentificacion(EntityManagerInterface $em, $identificacion)
    {
        $obj_unidad= AuxFunctions::getUnidad($em,$this->getUser());
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy([
           'identificacion'=>$identificacion,
           'id_unidad'=>$obj_unidad
        ]);

        return new JsonResponse([
            'id' => $empleado?$empleado->getId():'',
            'nombre' => $empleado?$empleado->getNombre():'',
            'correo' => $empleado?$empleado->getCorreo():'',
            'telefono' => $empleado?$empleado->getTelefono():'',
            'fecha_alta' => $empleado?$empleado->getFechaAlta()->format('d/m/Y'):'',
            'identificacion' => $empleado?$empleado->getIdentificacion():'',
            'id_unidad' => $empleado?$empleado->getIdUnidad()->getId():'',
            'direccion' => $empleado?$empleado->getDireccionParticular():'',
            'rol' => $empleado?$empleado->getRol():'',
            'is_user' => $empleado&&$empleado->getRol()?true:false,
            'success' => true
        ]);
    }

    /**
     * @Route("/empleado-add", name="contabilidad_capital_humano_empleado_add")
     */
    public function addEmplpeado(EntityManagerInterface $em, Request $request,
                                 ValidatorInterface $validator, UserPasswordEncoderInterface $passEncoder)
    {
        $form = $this->createForm(EmpleadoType::class);
        $form->handleRequest($request);

        /** @var Empleado $empleado */
        $obj_empleado = $form->getData();
        $errors = $validator->validate($obj_empleado);
        if ($form->isSubmitted() && $form->isValid()) {
            //---ADICIONO EL EMPLEADO
//            dd($request->get('is_usuario'));
            $obj_empleado
                ->setBaja(false)
                ->setAcumuladoTiempoVacaciones(0)
                ->setAcumuladoDineroVacaciones(0)
                ->setActivo(true);

            if ($request->get('is_usuario') == "on") {
                //-------ADICIONO EL USUARIO
                $obj_usuario = new User();
                $arr_role[0] = $obj_empleado->getRol();
                $obj_usuario
                    ->setUsername($obj_empleado->getCorreo())
                    ->setRoles($arr_role)
                    ->setStatus(true);
            }
            try {
                if ($request->get('is_usuario') == "on") {
                    $em->persist($obj_usuario);
                    $password = AuxFunctions::generateRandomPassword();
                    $obj_usuario->setPassword($passEncoder->encodePassword($obj_usuario, $password));
                    $obj_empleado->setIdUsuario($obj_usuario);

                    $msg = "Felicitaciones es usted miembro de nuestro equipo de trabajo, use la siguiente dirección para acceder al sistema www.google.com, su usuario es: " . $request->get('correo') . " y su contraseña: " . $password;
//                    AuxFunctions::sendEmail('Credenciales del sistema', $request->get('correo'), $request->get('nombre'), $msg);
                }
                $em->persist($obj_empleado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Empleado adicionado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_capital_humano_empleado');
    }

    /**
     * @Route("/empleado-upd/{id}", name="contabilidad_capital_humano_empleado_upd")
     */
    public function updEmpleado(EntityManagerInterface $em, Request $request, Empleado $empleado,
                                ValidatorInterface $validator, UserPasswordEncoderInterface $passEncoder)
    {
        $old_email = $em->getRepository(Empleado::class)->find($empleado->getId())->getCorreo();
        $form = $this->createForm(EmpleadoType::class, $empleado);
        $form->handleRequest($request);
        $errors = $validator->validate($empleado);

        if ($form->isSubmitted() && $form->isValid()) {
            $empleado
                ->setBaja(false)
                ->setActivo(true);

            //obtengo el usuario en caso de que exista
            $obj_usuario = $em->getRepository(User::class)->findOneByUsername($old_email);

            if ($request->get('is_usuario') == "on") {
                $arr_role[0] = $empleado->getRol();
                if (!$obj_usuario) {
                    $obj_usuario = new User();
                    $password = AuxFunctions::generateRandomPassword();
                    $obj_usuario->setPassword($passEncoder->encodePassword($obj_usuario, $password));
                    $empleado->setIdUsuario($obj_usuario);
                    $msg = "Felicitaciones es usted miembro de nuestro equipo de trabajo, use la siguiente dirección para acceder al sistema www.google.com, su usuario es: " . $request->get('correo') . " y su contraseña: " . $password;
//                    AuxFunctions::sendEmail('Credenciales del sistema', $request->get('correo'), $request->get('nombre'), $msg);
                }
                /**@var $obj_usuario User* */
                $obj_usuario
                    ->setUsername($empleado->getCorreo())
                    ->setRoles($arr_role)
                    ->setStatus(true);

            } else {
                if ($obj_usuario)
                    $obj_usuario->setStatus(false);
                $empleado->setIdUsuario(null);
                $empleado->setRol(null);
            }
            try {
                if ($obj_usuario) $em->persist($obj_usuario);
                $em->persist($empleado);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Empleado actualizado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_capital_humano_empleado');
    }


    /**
     * @Route("/empleado-delete/{id}", name="contabilidad_capital_humano_empleado_delete")
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

    public static function getRoles()
    {
        $roles_list = [];
        $config = Yaml::parse(file_get_contents('../config/packages/security.yaml'));
        $access_control = $config['security']['access_control'];
        foreach ($access_control as $ac) {
            foreach ($ac['roles'] as $item) {
                if (in_array($item, $roles_list) == false)
                    $roles_list[$item] = $item;
            }
        }
        return $roles_list;
    }


}
