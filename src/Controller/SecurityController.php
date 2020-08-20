<?php

namespace App\Controller;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\User;
use App\Form\Contabilidad\Config\CentroCostoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            if ($this->getUser()->isStatus())
                return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/home/change-password", name="change_password")
     */
    public function changePassword(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passEncoder)
    {
        $new_password = $request->get('new_password');
        $user = $this->getUser();

        /**@var $user User*** */
        $user->setPassword($passEncoder->encodePassword($user, $new_password));

        $em->persist($user);
        $em->flush();
        $this->addFlash('success', "Contraseña cambiada satisfactoriamente");
        return new JsonResponse(['success' => true]);
    }

    public function getStrRoles($array_roles)
    {
        $str = "";
        foreach ($array_roles as $rol) {
            $str = $str . $rol . ' | ';
        }
        return substr($str, 0, -3);
    }

    /**
     * @Route("/nuevo-password/{correo}", name="nuevo_password")
     */
    public function resetearMiPassword(Request $request, UserPasswordEncoderInterface $passEncoder,$correo)
    {
        $new_password = AuxFunctions::generateRandomPassword();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(array(
            'username' => $correo,
            'status' => true
        ));
        $asunto = 'Alerta de seguridad';
        $nombre = 'Usuario desconocido';
        $msg = 'Usted no es un usuario del sistema.';
        if ($user) {
            /**@var $user User** */
            $asunto = 'Cambio de contraseña';
            $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                'activo' => true,
                'correo' => $correo
            ));
            $nombre = $empleado->getNombre();
            $msg = 'Usted a restablecido la contraseña correctamente. Su nueva contraseña es: ' . $new_password;

            $user->setPassword($passEncoder->encodePassword($user, $new_password));
            $em->persist($user);
            $em->flush();
        }
        else{
            $config = Yaml::parse(file_get_contents( '../config/email_config.yaml'));
            $user = $config['config']['user'];
            $alias = $config['config']['alias'];

            AuxFunctions::sendEmail('Intento Violacion de seguridad', $user, $alias, 'Intento de acceso al sitio por: '.$correo);
        }
        AuxFunctions::sendEmail($asunto, $correo, $nombre, $msg);

        return new JsonResponse(['success' => true]);
    }
}
