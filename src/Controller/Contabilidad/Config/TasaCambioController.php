<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Form\Contabilidad\Config\CuentaType;
use App\Form\Contabilidad\Config\TasaCambioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasaCambioController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/tasa-cambio", name="contabilidad_config_tasa_cambio")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TasaCambioType::class);

        $cuentas_arr = $em->getRepository(TasaCambio::class)->findByActivo(true);
        $row = [];
        foreach ($cuentas_arr as $item) {
            /**@var $item TasaCambio** */
            $row [] = array(
                'id' => $item->getId(),
                'anno' => $item->getAnno(),
                'mes' => $item->getMes(),
                'valor' => $item->getValor()
            );
        }
        return $this->render('contabilidad/config/tasa_cambio/index.html.twig',  [
            'controller_name' => 'TasaCambioController',
            'tasa_cambio' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/cuenta-add", name="contabilidad_config_cuenta_add")
     */
    public function addCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        if (!$this->isDuplicate($em, $request->get('nro_cuenta'), 'add')) {
            /**@var $obj_cuenta Cuenta** */

            $obj_cuenta = new Cuenta();
            $obj_cuenta
                ->setNroCuenta($request->get('nro_cuenta'))
                ->setDescripcion($request->get('descripcion'))
                ->setDeudora($request->get('deudora'))
                ->setPatrimonio($request->get('patrimonio'))
                ->setProduccion($request->get('produccion'))
                ->setElementoGasto($request->get('elemento_gasto'))
                ->setActivo(true);
            try {
                $em->persist($obj_cuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cuenta adicionada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El Nro de cuenta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/cuenta-upd", name="contabilidad_config_cuenta_upd")
     */
    public function updCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        if (!$this->isDuplicate($em, $request->get('nro_cuenta'), 'upd',$request->get('id_cuenta'))) {
            /**@var $obj_cuenta Cuenta** */
            $obj_cuenta = $em->getRepository(Cuenta::class)->find($request->get('id_cuenta'));
            if(!$obj_cuenta){
                $this->addFlash('error', "La cuenta solicitada no se encuentra en la base de datos");
                return new JsonResponse(['success' => true]);
            }
            $obj_cuenta
                ->setNroCuenta($request->get('nro_cuenta'))
                ->setDescripcion($request->get('descripcion'))
                ->setDeudora($request->get('deudora'))
                ->setPatrimonio($request->get('patrimonio'))
                ->setProduccion($request->get('produccion'))
                ->setElementoGasto($request->get('elemento_gasto'))
                ->setActivo(true);
            try {
                $em->persist($obj_cuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cuenta actualizada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El Nro de cuenta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/cuenta-delete/{id}", name="contabilidad_config_cuenta_delete")
     */
    public function Delete($id)
    {
        $em = $this->getDoctrine()->getManager();

        $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy(array(
            'id_cuenta' => $id,
            'activo' => true
        ));
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
        }
        else{
            $msg = "No se puede eliminar la cuenta seleccionada,porque tiene subcuentas asociadas";
            $success = "error";
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_cuenta');
    }


    /**************-Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar-****************/
    public function isDuplicate($em, $nro_cuenta, $action, $id = null)
    {
        $cuenta_er = $em->getRepository(Cuenta::class);

        $arr_obj = $cuenta_er->findBy(array(
            'nro_cuenta' => $nro_cuenta,
            'activo' => true
        ));

        if ($action == 'upd') {
            foreach ($arr_obj as $obj) {
                /**@var $obj Cuenta* */
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
