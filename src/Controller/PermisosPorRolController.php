<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

/**
 * Class PermisosPorRolController
 * @package App\Controller
 * @Route("/permisos-por-rol")
 */
class PermisosPorRolController extends AbstractController
{
    /**
     * @Route("/{rol}", name="permisos_por_rol")
     */
    public function index($rol = '')
    {

        $config = Yaml::parse(file_get_contents('../config/packages/security.yaml'));
        $access_control = $config['security']['access_control'];
        $rows = [];
        foreach ($access_control as $ac) {
            if ($rol !== '') {
                if (in_array($rol, $ac['roles']))
                    $rows[] = array(
                        'path' => $ac['path'],
                        'roles' => $this->getStrRoles($ac['roles'])
                    );
            } else {
                $rows[] = array(
                    'path' => $ac['path'],
                    'roles' => $this->getStrRoles($ac['roles'])
                );
            }

        }
        $roles = $this->getRoles();
        return $this->render('permisos_por_rol/index.html.twig', [
            'controller_name' => 'PermisosPorRolController',
            'permisos' => $rows,
            'roles' => $roles
        ]);
    }

    public function getStrRoles($arr)
    {
        $str = "[";
        foreach ($arr as $item) {
            $str = $str . $item . " - ";
        }
        $str = substr($str, 0, -3);
        return $str . "]";
    }

    public function getRoles()
    {
        $str = "";
        $config = Yaml::parse(file_get_contents('../config/packages/security.yaml'));
        $access_control = $config['security']['access_control'];
        foreach ($access_control as $ac) {
            foreach ($ac['roles'] as $item) {
                $str = $str . $item . ",";
            }
        }
        $str = substr($str, 0, -1);
        $array = explode(",", $str);
        $array = array_unique($array);

        $roles = [];
        foreach ($array as $item){
            $roles[] = array(
                'rol'=>$item
            );
        }
        return $roles;
    }


}
