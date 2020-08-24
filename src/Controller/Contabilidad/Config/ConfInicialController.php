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
                $id_modulo = $request->get('configuracion_inicial')['id_modulo'];
                $id_tipo_documento = $request->get('configuracion_inicial')['id_tipo_documento'];
                $configuracion_inicial_id_cuenta = $request->get('configuracion_inicial_id_cuenta');
                $configuracion_inicial_id_subcuenta = $request->get('configuracion_inicial_id_subcuenta');
                $configuracion_inicial_id_cuenta_contrapartida = $request->get('configuracion_inicial_id_cuenta_contrapartida');
                $configuracion_inicial_id_subcuenta_contrapartida = $request->get('configuracion_inicial_id_subcuenta_contrapartida');
                $deudora = $request->get('naturaleza') == '1' ? true : false;

                if (!$this->isDuplicate($em, $id_modulo, $id_tipo_documento, 'add')) {
                    $obj = new ConfiguracionInicial();
                    $obj
                        ->setDeudora($deudora)
                        ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find($id_tipo_documento))
                        ->setIdModulo($em->getRepository(Modulo::class)->find($id_modulo))
                        ->setStrCuentas($configuracion_inicial_id_cuenta)
                        ->setStrSubcuentas($configuracion_inicial_id_subcuenta)
                        ->setStrCuentasContrapartida($configuracion_inicial_id_cuenta_contrapartida)
                        ->setStrSubcuentasContrapartida($configuracion_inicial_id_subcuenta_contrapartida)
                        ->setActivo(true);
                    try {
                        $em->persist($obj);
                        $em->flush();
                    } catch (FileException $exception) {
                        return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                    }
                    if (isset($arr_result['aplicar'])) {
                        $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aplicar).');
                        return $this->redirectToRoute('contabilidad_config_conf_inicial_form');
                    } else {
                        $this->addFlash('success', 'Configuración adicionada satisfactoriamente(Aceptar).');
                        return $this->redirectToRoute('contabilidad_config_conf_inicial');
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
            ->setIdTipoDocumento($em->getRepository(TipoDocumento::class)->find($fiels['id_tipo_documento']))
            ->setIdModulo($em->getRepository(Modulo::class)->find($fiels['id_modulo']))
            ->setActivo(true);
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
                'str_cuentas'=>$obj->getStrCuentas(),
                'str_subcuentas'=>$obj->getStrSubcuentas(),
                'str_cuentas_contrapartidas'=>$obj->getStrCuentasContrapartida(),
                'str_subcuentas_contrapartidas'=>$obj->getStrSubcuentasContrapartida(),
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
     * @Route("/form-getsubcuenta/{idcuentas}", name="contabilidad_config_conf_inicial_form_getsubcuenta")
     */
    public function getSubcuentas($idcuentas)
    {
        $cuentas_str = explode(" ", $idcuentas);
        $em = $this->getDoctrine()->getManager();
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $cuenta_er = $em->getRepository(Cuenta::class);
        $row = [];
        foreach ($cuentas_str as $nro_cuenta) {
            if (strlen($nro_cuenta) > 2) {
                $idcuenta = $cuenta_er->findOneBy(array(
                    'nro_cuenta' => $nro_cuenta,
                    'activo' => true
                ));
                if ($idcuenta) {
                    $arr_subcuenta_obj = $subcuenta_er->findBy(array(
                        'id_cuenta' => $idcuenta,
                        'activo' => true
                    ));
                    if (!empty($arr_subcuenta_obj)) {
                        foreach ($arr_subcuenta_obj as $item) {
                            /**@var $item Subcuenta** */
                            $row[] = array(
                                'id' => $item->getId(),
                                'nro_subcuenta' => $item->getNroSubcuenta(),
                                'descripcion' => $item->getDescripcion()
                            );
                        }
                    }
                }
            }
        }
        return new JsonResponse(['subcuentas' => $row]);
    }

    /**
     * Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar
     */
    public function isDuplicate($em, $id_modulo, $id_tipo_documento, $action, $id = null)
    {
        $conf_inicial_er = $em->getRepository(ConfiguracionInicial::class);

        $arr_obj = $conf_inicial_er->findBy(array(
            'id_modulo' => $id_modulo,
            'id_tipo_documento' => $id_tipo_documento,
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
