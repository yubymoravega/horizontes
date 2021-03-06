<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\CuentaCriterioAnalisis;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\CuentaType;
use App\Form\Contabilidad\Config\CuentaTypeFirst;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CuentaController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/cuenta")
 */
class CuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_cuenta", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $form = $this->createForm(CuentaType::class);
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array('activo' => true), array('nro_cuenta' => 'ASC'));
        $row = [];
        $cuenta_criterio_er = $em->getRepository(CuentaCriterioAnalisis::class);
        foreach ($cuentas_arr as $item) {
            //creo el str con las abreviaturas de los criterios de analisis asociados a la cuenta
            $str_criterios = '';
            $arr_criterios_asociados = $cuenta_criterio_er->findBy(array(
                'id_cuenta' => $item
            ));
            $str_a1 = 0;
            $str_a2 = 0;
            $str_a3 = 0;
            $str_a4 = 0;
            if (!empty($arr_criterios_asociados)) {
                /**@var CuentaCriterioAnalisis $criterios_asociados */
                foreach ($arr_criterios_asociados as $key => $criterios_asociados) {
                    if ($key == 0) {
                        $str_a1 = $criterios_asociados->getIdCriterioAnalisis()->getId();
                    }
                    if ($key == 1) {
                        $str_a2 = $criterios_asociados->getIdCriterioAnalisis()->getId();
                    }
                    if ($key == 2) {
                        $str_a3 = $criterios_asociados->getIdCriterioAnalisis()->getId();
                    }
                    if ($key == 3) {
                        $str_a4 = $criterios_asociados->getIdCriterioAnalisis()->getId();
                    }
                    $abreviatura = $criterios_asociados->getIdCriterioAnalisis()->getAbreviatura();
                    $str_criterios = $str_criterios . $abreviatura . ' - ';
                }
            }

            if ($item->getMixta() == true)
                $naturaleza = 'Mixta';
            elseif ($item->getDeudora() == true)
                $naturaleza = 'Deudora';
            else
                $naturaleza = 'Acreedora';

            $row [] = array(
                'id' => $item->getId(),
                'nro_cuenta' => $item->getNroCuenta(),
                'nombre' => $item->getNombre(),
                'deudora' => $naturaleza,
                'produccion' => $item->getProduccion() == true ? 'SI' : '',
                'obligacion_aceedora' => $item->getObligacionAcreedora() == true ? 'SI' : '',
                'obligacion_deudora' => $item->getObligacionDeudora() == true ? 'SI' : '',
//                'elemento_gasto' => $item->getElementoGasto() == true ? 'SI' : 'NO',
                'id_tipo_cuenta' => intval($item->getIdTipoCuenta()->getId()),
                'id_criterio_uno' => intval($str_a1),
                'id_criterio_dos' => intval($str_a2),
                'id_criterio_tres' => intval($str_a3),
                'id_criterio_cuatro' => intval($str_a4),
                'nombre_tipo_cuenta' => $item->getIdTipoCuenta()->getNombre(),
                'criterios' => $str_criterios == '' ? '' : substr($str_criterios, 0, -2)
            );
        }
//        dd($row);
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            15, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/config/cuenta/index.html.twig', [
            'controller_name' => 'CuentaController',
            'cuentas' => $paginator,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/print", name="contabilidad_config_cuenta_print", methods={"GET"})
     */
    public function print(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array('activo' => true), array('nro_cuenta' => 'ASC'));
        $row = [];
        $cuenta_criterio_er = $em->getRepository(CuentaCriterioAnalisis::class);
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $valor_maximo_criterios = 0;
        foreach ($cuentas_arr as $item) {
            $arr_criterios_asociados = $cuenta_criterio_er->findBy(array(
                'id_cuenta' => $item
            ));
            $arr_subcuentas = $subcuenta_er->findBy(array(
                'id_cuenta' => $item
            ));
            $arr_abreviaturas = [];
            if (!empty($arr_criterios_asociados)) {
                if ($valor_maximo_criterios < count($arr_criterios_asociados)) {
                    $valor_maximo_criterios = count($arr_criterios_asociados);
                }
                foreach ($arr_criterios_asociados as $criterios_asociados) {
                    $abreviatura = $criterios_asociados->getIdCriterioAnalisis()->getAbreviatura();
                    $arr_abreviaturas[] = array(
                        'abreviatura' => $abreviatura
                    );
                }
            }
            $subcuentas = [];
            if (!empty($arr_subcuentas)) {
                foreach ($arr_subcuentas as $subcuenta) {
                    /**@var $subcuenta Subcuenta* */
                    $subcuentas[] = array(
                        'nro_subcuenta' => $subcuenta->getNroSubcuenta(),
                        'nombre' => $subcuenta->getDescripcion(),
                        'naturaleza' => $subcuenta->getDeudora() == true ? 'D' : 'A',
                        'elemento_gasto' => $subcuenta->getElementoGasto() == true ? 'SI' : 'NO',
                    );
                }
            }
            if ($item->getMixta() == true)
                $naturaleza = 'M';
            elseif ($item->getDeudora() == true)
                $naturaleza = 'D';
            else
                $naturaleza = 'A';
            $row [] = array(
                'id' => $item->getId(),
                'nro_cuenta' => $item->getNroCuenta(),
                'nombre' => $item->getNombre(),
                'naturaleza' => $naturaleza,
                'obligacion' => ($item->getObligacionAcreedora() == true || $item->getObligacionDeudora() == true) ? 'SI' : '',
//                'obligacion_deudora' => $item->getObligacionDeudora() == true ? 'SI' : 'NO',
//                'elemento_gasto' => $item->getElementoGasto() == true ? 'SI' : 'NO',
                'tipo_cuenta' => $item->getIdTipoCuenta()->getId(),
                'nombre_tipo_cuenta' => $item->getIdTipoCuenta()->getNombre(),
                'abreviaturas' => $arr_abreviaturas,
                'subcuentas' => $subcuentas
            );
        }
        return $this->render('contabilidad/config/cuenta/print.html.twig', [
            'controller_name' => 'CuentaControllerPrint',
            'cuentas' => $row,
            'maximo_criterios' => $valor_maximo_criterios
        ]);
    }

    /**
     * @Route("/getCuentas/{cuentas}", name="contabilidad_config_cuenta_get_cuentas", methods={"POST"})
     */
    public function getCuentas(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $cuentas)
    {
        $cuentas_arr = $em->getRepository(Cuenta::class)->findByActivo(true);
        $row = [];
        foreach ($cuentas_arr as $item) {
            if (strpos($cuentas . ' ', $item->getNroCuenta() . ' ') === false) {
                /**@var $item Cuenta** */
                $row [] = array(
                    'id' => $item->getId(),
                    'nro_cuenta' => $item->getNroCuenta(),
                    'descripcion' => $item->getDescripcion()
                );
            }
        }
        return new JsonResponse(['cuentas' => $row]);
    }

    /**
     * @Route("/add", name="contabilidad_config_cuenta_add", methods={"POST"})
     */
    public function addCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(CuentaType::class);
        $form->handleRequest($request);

        /** @var Cuenta $cuenta */
        $cuenta = $form->getData();
        $errors = $validator->validate($cuenta);
//        if ($form->isValid() && $form->isSubmitted()) {
        if ($form->isSubmitted()) {
            try {
                $naturaleza = $request->get('cuenta')['deudora'];
                $field_deudora = true;
                $field_mixta = false;
                if ($naturaleza == 0) {
                    $field_deudora = false;
                } elseif ($naturaleza == 2) {
                    $field_deudora = false;
                    $field_mixta = true;
                }
                $cuenta
                    ->setActivo(true)
                    ->setDeudora($field_deudora)
                    ->setMixta($field_mixta);
                $em->persist($cuenta);

                $id_criterio_uno = isset($request->get('cuenta')['id_criterio_uno']) ? $request->get('cuenta')['id_criterio_uno'] : '';
                $id_criterio_dos = isset($request->get('cuenta')['id_criterio_dos']) ? $request->get('cuenta')['id_criterio_dos'] : '';
                $id_criterio_tres = isset($request->get('cuenta')['id_criterio_tres']) ? $request->get('cuenta')['id_criterio_tres'] : '';
                $id_criterio_cuatro = isset($request->get('cuenta')['id_criterio_cuatro']) ? $request->get('cuenta')['id_criterio_cuatro'] : '';
                $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);
                if ($id_criterio_uno !== '') {
                    $obj_criterio = $criterio_analisis_er->find($id_criterio_uno);
                    if ($obj_criterio) {
                        $cuenta_criterio = new CuentaCriterioAnalisis();
                        $cuenta_criterio
                            ->setIdCuenta($cuenta)
                            ->setOrden(1)
                            ->setIdCriterioAnalisis($obj_criterio);
                        $em->persist($cuenta_criterio);
                    }
                }
                if ($id_criterio_dos !== '') {
                    $obj_criterio = $criterio_analisis_er->find($id_criterio_dos);
                    if ($obj_criterio) {
                        $cuenta_criterio = new CuentaCriterioAnalisis();
                        $cuenta_criterio
                            ->setIdCuenta($cuenta)
                            ->setOrden(2)
                            ->setIdCriterioAnalisis($obj_criterio);
                        $em->persist($cuenta_criterio);
                    }
                }
                if ($id_criterio_tres !== '') {
                    $obj_criterio = $criterio_analisis_er->find($id_criterio_tres);
                    if ($obj_criterio) {
                        $cuenta_criterio = new CuentaCriterioAnalisis();
                        $cuenta_criterio
                            ->setIdCuenta($cuenta)
                            ->setOrden(3)
                            ->setIdCriterioAnalisis($obj_criterio);
                        $em->persist($cuenta_criterio);
                    }
                }
                if ($id_criterio_cuatro !== '') {
                    $obj_criterio = $criterio_analisis_er->find($id_criterio_cuatro);
                    if ($obj_criterio) {
                        $cuenta_criterio = new CuentaCriterioAnalisis();
                        $cuenta_criterio
                            ->setIdCuenta($cuenta)
                            ->setOrden(4)
                            ->setIdCriterioAnalisis($obj_criterio);
                        $em->persist($cuenta_criterio);
                    }
                }
                $em->flush();
                $this->addFlash('success', "Cuenta adicionada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());

        return $this->redirectToRoute('contabilidad_config_cuenta', ['page' => $request->get("page")]);
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_cuenta_upd", methods={"POST"})
     */
    public function updCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $cuenta = $em->getRepository(Cuenta::class)->find($id);
        $cuenta
            ->setNroCuenta($request->get('cuenta')['nro_cuenta'])
            ->setNombre($request->get('cuenta')['nombre'])
            ->setDeudora($request->get('cuenta')['deudora']);

        $form = $this->createForm(CuentaType::class, $cuenta);
        $form->handleRequest($request);
        $errors = $validator->validate($cuenta);
//        if ($form->isValid() && $form->isSubmitted()) {
        try {
            $naturaleza = $request->get('cuenta')['deudora'];
            $field_deudora = true;
            $field_mixta = false;
            if ($naturaleza == 0) {
                $field_deudora = false;
            } elseif ($naturaleza == 2) {
                $field_deudora = false;
                $field_mixta = true;
            }
            $cuenta
                ->setActivo(true)
                ->setDeudora($field_deudora)
                ->setMixta($field_mixta);
            $em->persist($cuenta);
            $cuenta_criterio_analisis_er = $em->getRepository(CuentaCriterioAnalisis::class);
            //elimino los registros de criterios y cuentas de la tabla CuentaCriterioAnalisis
            $arr_criterios_cuenta = $cuenta_criterio_analisis_er->findBy(array(
                'id_cuenta' => $cuenta
            ));
            if (!empty($arr_criterios_cuenta)) {
                foreach ($arr_criterios_cuenta as $obj_cuenta_criterio) {
                    $em->remove($obj_cuenta_criterio);
                }
            }
            //adiciono los nuevos criterios asociados a las cuentas

            $id_criterio_uno = isset($request->get('cuenta')['id_criterio_uno']) ? $request->get('cuenta')['id_criterio_uno'] : '';
            $id_criterio_dos = isset($request->get('cuenta')['id_criterio_dos']) ? $request->get('cuenta')['id_criterio_dos'] : '';
            $id_criterio_tres = isset($request->get('cuenta')['id_criterio_tres']) ? $request->get('cuenta')['id_criterio_tres'] : '';
            $id_criterio_cuatro = isset($request->get('cuenta')['id_criterio_cuatro']) ? $request->get('cuenta')['id_criterio_cuatro'] : '';
            $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);
            if ($id_criterio_uno !== '') {
                $obj_criterio = $criterio_analisis_er->find($id_criterio_uno);
                if ($obj_criterio) {
                    $cuenta_criterio = new CuentaCriterioAnalisis();
                    $cuenta_criterio
                        ->setIdCuenta($cuenta)
                        ->setOrden(1)
                        ->setIdCriterioAnalisis($obj_criterio);
                    $em->persist($cuenta_criterio);
                }
            }
            if ($id_criterio_dos !== '') {
                $obj_criterio = $criterio_analisis_er->find($id_criterio_dos);
                if ($obj_criterio) {
                    $cuenta_criterio = new CuentaCriterioAnalisis();
                    $cuenta_criterio
                        ->setIdCuenta($cuenta)
                        ->setOrden(2)
                        ->setIdCriterioAnalisis($obj_criterio);
                    $em->persist($cuenta_criterio);
                }
            }
            if ($id_criterio_tres !== '') {
                $obj_criterio = $criterio_analisis_er->find($id_criterio_tres);
                if ($obj_criterio) {
                    $cuenta_criterio = new CuentaCriterioAnalisis();
                    $cuenta_criterio
                        ->setIdCuenta($cuenta)
                        ->setOrden(3)
                        ->setIdCriterioAnalisis($obj_criterio);
                    $em->persist($cuenta_criterio);
                }
            }
            if ($id_criterio_cuatro !== '') {
                $obj_criterio = $criterio_analisis_er->find($id_criterio_cuatro);
                if ($obj_criterio) {
                    $cuenta_criterio = new CuentaCriterioAnalisis();
                    $cuenta_criterio
                        ->setIdCuenta($cuenta)
                        ->setOrden(4)
                        ->setIdCriterioAnalisis($obj_criterio);
                    $em->persist($cuenta_criterio);
                }
            }

            $em->flush();
            $this->addFlash('success', "Cuenta actualizada satisfactoriamente");
        } catch (FileException $exception) {
            return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
        }
//        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_cuenta', ['page' => $request->get("page")]);
    }

    /**
     * @Route("/upd-relations", name="contabilidad_config_cuenta_upd_relations", methods={"GET", "POST"})
     */
    public function updRelations(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $cuenta_arr = $em->getRepository(Cuenta::class)->findAll();
        $cuenta_criterio_er = $em->getRepository(CuentaCriterioAnalisis::class);
        /** @var Cuenta $cuenta_obj */
        foreach ($cuenta_arr as $cuenta_obj) {
            $arr_cuentas_criterios = $cuenta_criterio_er->findBy(['id_cuenta' => $cuenta_obj]);
            if (!empty($arr_cuentas_criterios)) {
                /** @var CuentaCriterioAnalisis $cuenta_criterio */
                foreach ($arr_cuentas_criterios as $key => $cuenta_criterio) {
                    $cuenta_criterio
                        ->setOrden($key + 1);
                    $em->persist($cuenta_criterio);
                }
            }
        }
        $em->flush();
        $this->addFlash('success', 'Relaciones actualizadas satisfactoriamente');
        return $this->redirectToRoute('contabilidad_config_cuenta', ['page' => $request->get("page")]);
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_cuenta_delete")
     */
    public function Delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy(['id_cuenta' => $id]);
            if (empty($arr_subcuentas)) {
                $cuenta_er = $em->getRepository(Cuenta::class);
                $cuenta_obj = $cuenta_er->find($id);
                $msg = 'No se pudo eliminar la cuenta seleccionada';
                $success = 'error';
                if ($cuenta_obj) {
                    /**@var $cuenta_obj Cuenta** */
                    $cuenta_obj->setActivo(false);
                    try {
                        $em->persist($cuenta_obj);
                        $em->flush();
                        $success = 'success';
                        $msg = 'Cuenta eliminada satisfactoriamente';

                    } catch
                    (FileException $exception) {
                        return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
                    }
                }
            } else {
                $msg = "No se puede eliminar la cuenta seleccionada,porque tiene subcuentas asociadas";
                $success = "error";
            }
            $this->addFlash($success, $msg);
        }
//        dd($request->get('page'));
        return $this->redirectToRoute('contabilidad_config_cuenta', ['page' => $request->get("page")]);
    }

    /**
     * @Route("/get-subcuentas/{id_cuenta}", name="contabilidad_config_cuenta_get_subcuentas", methods={"POST"})
     */
    public function getSubcuentas(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination, $id_cuenta)
    {
        $subcuentas_arr = $em->getRepository(Subcuenta::class)->findBy(array(
            'id_cuenta' => $id_cuenta,
            'activo' => true
        ));

        $row = [];
        foreach ($subcuentas_arr as $item) {
            /**@var $item Subcuenta** */
            $row [] = array(
                'id' => $item->getId(),
                'nro_subcuenta' => $item->getNroSubcuenta(),
                'descripcion' => $item->getDescripcion(),
                'deudora' => $item->getDeudora() == true ? 'Deudora' : 'Acreedora',
            );
        }
        return new JsonResponse(['subcuentas' => $row]);
    }

    /**
     * $nro - numero de la cuenta
     * {Array} - Criterios de analicis de la cuenta
     * @Route("/get-criterios/{nro}", name="contabilidad_config_get_criterios" ,methods={"POST"})
     */
    public function getCriterios(EntityManagerInterface $em, $nro)
    {
        $no_cuenta = AuxFunctions::getNro($nro);
        $respuesta = AuxFunctions::getCriterioByCuenta($no_cuenta, $em);

        $id_cuenta = $em->getRepository(Cuenta::class)->findOneBy(['nro_cuenta' => $no_cuenta, 'activo' => true])->getId();
        $subcuentas = $em->getRepository(Subcuenta::class)->findBy(['id_cuenta' => $id_cuenta, 'activo' => true]);
        $row = [];
        foreach ($subcuentas as $item) {
            /**@var $item Subcuenta** */
            $row [] = array(
                'id' => $item->getId(),
                'nro' => $item->getNroSubcuenta(),
                'descripcion' => $item->getNroSubcuenta() . ' - ' . $item->getDescripcion(),
            );
        }
        return new JsonResponse(['data' => $respuesta, 'success' => true, 'subcuentas' => $row]);
    }

    /**
     * $nro - numero de la cuenta
     * {Array} - Criterios de analicis de la cuenta
     * @Route("/get-criterios-subcuentas/{id}", name="contabilidad_config_get_criterios_subcuentas" ,methods={"POST"})
     */
    public function getCriteriosSubcuentas(EntityManagerInterface $em, $id)
    {
        $cuenta = $em->getRepository(Cuenta::class)->find($id);
        $respuesta = AuxFunctions::getCriterioByCuenta($cuenta->getNroCuenta(), $em);

        $subcuentas = $em->getRepository(Subcuenta::class)->findBy(['id_cuenta' => $id, 'activo' => true]);
        $row = [];
        foreach ($subcuentas as $item) {
            /**@var $item Subcuenta** */
            $row [] = array(
                'id' => $item->getId(),
                'nro' => $item->getNroSubcuenta(),
                'descripcion' => $item->getNroSubcuenta() . ' - ' . $item->getDescripcion(),
            );
        }
        return new JsonResponse(['data' => $respuesta, 'success' => true, 'subcuentas' => $row]);
    }

}
