<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Form\Contabilidad\Config\ConfiguracionInicialType;
use App\Form\Contabilidad\Config\ConfiguracionInicialUpdateType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConfInicialController extends AbstractController
{
    /***************-CRUD DE CONFIGURACION INICIAL-*******************/
    /**
     * @Route("/contabilidad/config/conf-inicial", name="contabilidad_config_conf_inicial")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('contabilidad/config/conf_inicial/index.html.twig', [
            'controller_name' => 'ConfInicialController',
            'configuraciones' => $this->getDataConf($em),
        ]);
    }

    /**
     * @Route("/contabilidad/config/conf-inicial/form-add", name="contabilidad_config_conf_inicial_form")
     */
    public function addConfInicial(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {

        $conf_new_obj = new ConfiguracionInicial();
        $form = $this->createForm(ConfiguracionInicialType::class, $conf_new_obj);
        $error = null;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            /**@var $conf_inicial_form ConfiguracionInicial** */
            $conf_inicial_form = $form->getData();

            $error = $validator->validate($conf_inicial_form);

            if ($form->isValid()) {
                $deudora = $request->get('naturaleza') == '1' ? true : false;
                $subcuenta_id = $request->get('subcuenta_id');

                $arr_form = $request->get('configuracion_inicial');
                $arr_extra_form = ['deudora' => $deudora, 'id_subcuenta' => $subcuenta_id];
                $arr_result = array_merge($arr_form, $arr_extra_form);
                if (!$this->isDuplicate($em, $arr_result,'add')) {
                    if ($this->saveDataConf($em, $arr_result, null)) {
                        if (isset($arr_result['aplicar'])) {
                            $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aplicar).');
                            return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
                        } else {
                            $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aceptar).');
                            return $this->redirectToRoute('contabilidad_config_conf_inicial');
                        }
                    } else {
                        $this->addFlash('error', 'La acción solicitada ha presentado errores, por favor contacte a su proveedor de software.');
                        return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
                    }
                } else {
                    $this->addFlash('error', 'Ya existe una configuración con esos parámetros.');
                    return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
                }
            }
        }
        return $this->render('contabilidad/config/conf_inicial/form.html.twig', [
            'controller_name' => 'ConfInicialController',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("contabilidad/config/conf-inicial/form-edit/{id}", name="contabilidad_config_conf_inicial_form_edit")
     */
    public function UpdateConfInicial(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $obj_Conf = $em->getRepository(ConfiguracionInicial::class)->find($id);
        $form_Conf = $this->createForm(ConfiguracionInicialUpdateType::class, $obj_Conf);
        $error = null;

        $form_Conf->handleRequest($request);
        if ($form_Conf->isSubmitted()) {

            /**@var $conf_inicial_form ConfiguracionInicial** */
            $conf_inicial_form = $form_Conf->getData();

            $error = $validator->validate($conf_inicial_form);

            if ($form_Conf->isValid()) {
                $deudora = $request->get('naturaleza') == '1' ? true : false;
                $subcuenta_id = $request->get('subcuenta_id') ? $request->get('subcuenta_id') : null;

                $arr_form = $request->get('configuracion_inicial_update');
                $arr_extra_form = ['deudora' => $deudora, 'id_subcuenta' => $subcuenta_id];
                $arr_result = array_merge($arr_form, $arr_extra_form);
                if (!$this->isDuplicate($em, $arr_result, 'upd',$id)) {
                    if ($this->saveDataConf($em, $arr_result, $obj_Conf)) {
                        $this->addFlash('success', 'Configuración modificada satisfactoriamente.');
                        return $this->redirectToRoute('contabilidad_config_conf_inicial');

                    } else {
                        $this->addFlash('failed', 'La acción solicitada ha presentado errores, por favor contacte a su proveedor de software.');
                        return $this->redirectToRoute('contabilidad_config_conf_inicial_form_edit');
                    }
                } else {
                    $this->addFlash('failed', 'Ya existe una configuración con esos parámetros.');
                    return $this->redirectToRoute('contabilidad_config_conf_inicial_form_edit');
                }
            }
        }
        return $this->render('contabilidad/config/conf_inicial/form_update.html.twig', [
            'controller_name' => 'ConfInicialController',
            'formulario' => $form_Conf->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/conf-inicial-delete/{id}", name="contabilidad_config_conf_inicial_delete")
     */
    public function DeleteConfInicial($id)
    {
        $em = $this->getDoctrine()->getManager();
        $configuracion_er = $em->getRepository(ConfiguracionInicial::class);
        $configuracion_obj = $configuracion_er->find($id);
        $msg = 'No se pudo eliminar la configuración seleccionada';
        $success = 'error';
        if ($configuracion_obj) {

            /**@var $configuracion_obj ConfiguracionInicial** */
            $configuracion_obj->setActivo(false);
            try {
                $em->persist($configuracion_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Configuración eliminada satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_conf_inicial');
    }

    /*************-METODOS AUXILIARES EMPLEADOS TANTO EL EL FRONT COMO INTERNAMENTE EN EL CONTROLLER-***************/

    /*************-Salva los datos en la base de datos, tanto para adicionar como para modificar-**********/
    public function saveDataConf($em, $fiels, $obj)
    {
        if ($obj == null) {
            $obj = new ConfiguracionInicial();
        }
        /**@var $obj ConfiguracionInicial* */
        $obj
            ->setDeudora($fiels['deudora'] == 1 ? true : false)
            ->setIdCuenta($em->getRepository(Cuenta::class)->find($fiels['id_cuenta']))
            ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find($fiels['id_tipo_documento']))
            ->setIdModulo($em->getRepository(Modulo::class)->find($fiels['id_modulo']))
            ->setActivo(true);
        if ($fiels['id_subcuenta']) {
            $obj->setIdSubcuenta($em->getRepository(Subcuenta::class)->find($fiels['id_subcuenta']));
        } else {
            $obj->setIdSubcuenta(null);
        }
        try {
            $em->persist($obj);
            $em->flush();
        } catch (FileException $exception) {
            return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
        }
        return true;
    }

    /*****Obtener el listado de configuraciones iniciales del sistema******/
    public function getDataConf($em)
    {
        $confInicial_er = $em->getRepository(ConfiguracionInicial::class);
        $arr_obj_configuraciones = $confInicial_er->findByActivo(true);

        $row = [];
        foreach ($arr_obj_configuraciones as $obj) {
            /**@var $obj ConfiguracionInicial* */
            $row [] = array(
                'id' => $obj->getId(),
                'id_cuenta' => $obj->getIdCuenta(),
                'nro_cuenta' => $obj->getIdCuenta()->getNroCuenta(),
                'id_subcuenta' => $obj->getIdSubcuenta() ? $obj->getIdSubcuenta() : null,
                'nro_subcuenta' => $obj->getIdSubcuenta() ? $obj->getIdSubcuenta()->getNroSubcuenta() : "",
                'id_tipo_documento' => $obj->getIdTipoDocumento(),
                'nombre_tipo_docuemtno' => $obj->getIdTipoDocumento()->getNombre(),
                'naturaleza' => $obj->getDeudora() == 1 ? 'Deudora' : 'Acreedora',
                'id_modulo' => $obj->getIdModulo(),
                'nombre_modulo' => $obj->getIdModulo()->getNombre()
            );
        }
        return $row;
    }

    /**
     * @Route("/contabilidad/config/conf-inicial/form-getsubcuenta/{idcuenta}", name="contabilidad_config_conf_inicial_form_getsubcuenta")
     */
    public function getSubcuentas($idcuenta)
    {
        $subcuenta_er = $this->getDoctrine()->getManager()->getRepository(Subcuenta::class);
        $arr_subcuenta_obj = $subcuenta_er->findBy(array(
            'id_cuenta' => $idcuenta,
            'activo' => true
        ));
        $row = [];
        if (!empty($arr_subcuenta_obj)) {
            foreach ($arr_subcuenta_obj as $item) {
                /**@var $item Subcuenta** */
                $row[] = array(
                    'id' => $item->getId(),
                    'nro_subcuenta' => $item->getNroSubcuenta()
                );
            }
        }
        return new JsonResponse(['subcuentas' => $row]);
    }

    /**************-Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar-****************/
    public function isDuplicate($em, $fiels, $action,$id= null)
    {
        $conf_inicial_er = $em->getRepository(ConfiguracionInicial::class);

        $arr_obj = $conf_inicial_er->findBy(array(
            'id_modulo' => $fiels['id_modulo'],
            'id_tipo_documento' => $fiels['id_tipo_documento'],
            'id_cuenta' => $fiels['id_cuenta'],
            'activo'=>true
        ));

        if ($action == 'upd') {
            foreach ($arr_obj as $obj) {
                /**@var $obj ConfiguracionInicial* */
                if ($obj->getId() != $id)
                    return true;
            }
        } elseif ($action == 'add') {
            if (!empty($arr_obj))
                return true;
        }
        return false;
    }
}
