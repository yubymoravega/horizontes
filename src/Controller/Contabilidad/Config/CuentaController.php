<?php

namespace App\Controller\Contabilidad\Config;

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
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array('activo'=>true),array('nro_cuenta'=>'ASC'));
        $row = [];
        $cuenta_criterio_er = $em->getRepository(CuentaCriterioAnalisis::class);
        foreach ($cuentas_arr as $item) {
            //creo el str con las abreviaturas de los criterios de analisis asociados a la cuenta
            $str_criterios = '';
            $arr_criterios_asociados = $cuenta_criterio_er->findBy(array(
                'id_cuenta' => $item
            ));
            if (!empty($arr_criterios_asociados)) {
                foreach ($arr_criterios_asociados as $criterios_asociados) {
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
                'tipo_cuenta' => $item->getIdTipoCuenta()->getId(),
                'nombre_tipo_cuenta' => $item->getIdTipoCuenta()->getNombre(),
                'criterios' => $str_criterios == '' ? '' : substr($str_criterios, 0, -2)
            );
        }
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', 1), /*page number*/
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
        $cuentas_arr = $em->getRepository(Cuenta::class)->findBy(array('activo'=>true),array('nro_cuenta'=>'ASC'));
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
        if ($form->isValid() && $form->isSubmitted()) {
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
                $abreviaturas = $request->get('criterio_analisis')['abreviatura'];
                if (!empty($abreviaturas)) {
                    $arr_abreviaturas = explode(' - ', $abreviaturas);
                    $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);
                    foreach ($arr_abreviaturas as $abreviatura_) {
                        $obj_criterio = $criterio_analisis_er->findOneBy(array(
                            'abreviatura' => $abreviatura_,
                            'activo' => true
                        ));
                        if ($obj_criterio) {
                            $cuenta_criterio = new CuentaCriterioAnalisis();
                            $cuenta_criterio
                                ->setIdCuenta($cuenta)
                                ->setIdCriterioAnalisis($obj_criterio);
                            $em->persist($cuenta_criterio);
                        }
                    }
                }
                $em->flush();
                $this->addFlash('success', "Cuenta adicionada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());

        return $this->redirectToRoute('contabilidad_config_cuenta');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_cuenta_upd", methods={"POST"})
     */
    public function updCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Cuenta $cuenta)
    {
        $form = $this->createForm(CuentaType::class, $cuenta);
        $form->handleRequest($request);
        $errors = $validator->validate($cuenta);
        if ($form->isValid() && $form->isSubmitted()) {
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

                $abreviaturas = $request->get('criterio_analisis')['abreviatura'];
                if (!empty($abreviaturas)) {
                    $arr_abreviaturas = explode(' - ', $abreviaturas);
                    $criterio_analisis_er = $em->getRepository(CriterioAnalisis::class);
                    foreach ($arr_abreviaturas as $abreviatura_) {
                        $obj_criterio = $criterio_analisis_er->findOneBy(array(
                            'abreviatura' => $abreviatura_,
                            'activo' => true
                        ));
                        if ($obj_criterio) {
                            $cuenta_criterio = new CuentaCriterioAnalisis();
                            $cuenta_criterio
                                ->setIdCuenta($cuenta)
                                ->setIdCriterioAnalisis($obj_criterio);
                            $em->persist($cuenta_criterio);
                        }
                    }
                }
                $em->flush();
                $this->addFlash('success', "Cuenta actualizada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_cuenta');
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
                        return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                    }
                }
            } else {
                $msg = "No se puede eliminar la cuenta seleccionada,porque tiene subcuentas asociadas";
                $success = "error";
            }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('contabilidad_config_cuenta');
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

}
