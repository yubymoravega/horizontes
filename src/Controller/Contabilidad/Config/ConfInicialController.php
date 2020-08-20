<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Modulo;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Form\Contabilidad\Config\ConfiguracionInicialType;
use App\Form\Contabilidad\Config\ConfiguracionInicialUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ConfInicialController
 * CRUD DE CONFIGURACION INICIAL
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/conf-inicial")
 */
class ConfInicialController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_conf_inicial",methods={"GET"})
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
     * @Route("/form-add", name="contabilidad_config_conf_inicial_form", methods={"GET","POST"})
     */
    public function addConfInicial(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $conf_new_obj = new ConfiguracionInicial();
        $form = $this->createForm(ConfiguracionInicialType::class, $conf_new_obj);
        $error = null;

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $deudora = $request->get('naturaleza') == '1' ? true : false;
                $subcuenta_id = $request->get('subcuenta_id');

                $arr_form = $request->get('configuracion_inicial');
                $arr_extra_form = ['deudora' => $deudora, 'id_subcuenta' => $subcuenta_id];
                $arr_result = array_merge($arr_form, $arr_extra_form);
                if (!$this->isDuplicate($em, $arr_result, 'add')) {
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
     * @Route("/{id}", name="contabilidad_config_conf_inicial_delete", methods={"DELETE"})
     */
    public function DeleteConfInicial(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
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
        }
        return $this->redirectToRoute('contabilidad_config_conf_inicial');
    }

    /**
     * Salva los datos en la base de datos, tanto para adicionar como para modificar
     */
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

    /**
     * Obtener el listado de configuraciones iniciales del sistema
     */
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
     * @Route("/form-getsubcuenta/{idcuenta}", name="contabilidad_config_conf_inicial_form_getsubcuenta")
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
                    'nro_subcuenta' => $item->getNroSubcuenta(),
                    'subcuenta' => $item->getDescripcion()
                );
            }
        }
        return new JsonResponse(['subcuentas' => $row]);
    }

    /**
     * Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar
     */
    public function isDuplicate($em, $fiels, $action, $id = null)
    {
        $conf_inicial_er = $em->getRepository(ConfiguracionInicial::class);

        $arr_obj = $conf_inicial_er->findBy(array(
            'id_modulo' => $fiels['id_modulo'],
            'id_tipo_documento' => $fiels['id_tipo_documento'],
            'id_cuenta' => $fiels['id_cuenta'],
            'activo' => true
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
