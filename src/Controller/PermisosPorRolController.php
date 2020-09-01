<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Dumper;
use Symfony\Component\Yaml\Yaml;

/**
 * Class PermisosPorRolController
 * @package App\Controller
 * @Route("/permisos-por-rol")
 */
class PermisosPorRolController extends AbstractController
{
    /**
     * @Route("/{rol}", name="permisos_por_rol", methods={"GET"})
     */
    public function index($rol = '')
    {
        $config = Yaml::parse(file_get_contents('../config/packages/security.yaml'));

        $rows = [];
        foreach ($config['security']['access_control'] as $ac) {
            $arr_path = explode('/', $ac['path']);
            if (count($arr_path) == 4) {
                $subsistema = $arr_path[1];
                $modulo = $arr_path[2];
                $accion = $arr_path[3];
            }
            if (count($arr_path) == 3) {
                $subsistema = '-';
                $modulo = $arr_path[1];
                $accion = $arr_path[2];
            }
            if (count($arr_path) == 2) {
                $subsistema = '-';
                $modulo = '-';
                $accion = $arr_path[1];
            }

            if ($rol !== '') {
                if (in_array($rol, $ac['roles']))
                    $rows[] = array(
                        'path' => $ac['path'],
                        'subsistema' => $subsistema,
                        'modulo' => $modulo,
                        'accion' => $accion,
                        'roles' => $this->getStrRoles($ac['roles'])
                    );
            } else {
                $rows[] = array(
                    'path' => $ac['path'],
                    'subsistema' => $subsistema,
                    'modulo' => $modulo,
                    'accion' => $accion,
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

    /**
     * @Route("/add", name="permisos_por_rol_add", methods={"POST"})
     */
    public function add(Request $request)
    {
        //'^/contabilidad/RRHH/lolo'
        //$roles = array('ROL3','ROL4');
//dd($request);
        $str_roles = $request->get('roles');
        $roles = explode(',',$str_roles);


        $config = Yaml::parse(file_get_contents('../config/packages/security.yaml'));
        foreach ($config as $item) {
            if (!empty($item['access_control'])) {
                $config['security']['access_control'][count($item['access_control'])] = array('path' => $request->get('path'), 'roles' =>$roles);
            }
        }
        $dumper = new Dumper();
        $yaml = $dumper->dump($config, 5);

        file_put_contents('../config/packages/security.yaml', $yaml);
        $this->addFlash('success', 'Permiso agregado satisfactoriamente.');
        return $this->redirectToRoute('permisos_por_rol');
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
        foreach ($array as $item) {
            $roles[] = array(
                'rol' => $item
            );
        }
        return $roles;
    }


}
