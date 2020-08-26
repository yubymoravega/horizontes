<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\Unidad;
use App\Form\Contabilidad\Config\CuentaType;
use App\Form\Contabilidad\Config\UnidadType;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/", name="contabilidad_config_cuenta")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(CuentaType::class);

        $cuentas_arr = $em->getRepository(Cuenta::class)->findByActivo(true);
        $row = [];
        foreach ($cuentas_arr as $item) {
            /**@var $item Cuenta** */
            $row [] = array(
                'id' => $item->getId(),
                'nro_cuenta' => $item->getNroCuenta(),
                'descripcion' => $item->getDescripcion(),
                'deudora' => $item->getDeudora() == true ? 'Deudora' : 'Acreedora',
                'patrimonio' => $item->getPatrimonio() == true ? 'SI' : 'NO',
                'produccion' => $item->getProduccion() == true ? 'SI' : 'NO',
                'elemento_gasto' => $item->getElementoGasto() == true ? 'SI' : 'NO',
            );
        }
        return $this->render('contabilidad/config/cuenta/index.html.twig', [
            'controller_name' => 'CuentaController',
            'cuentas' => $row,
            'form' => $form->createView()
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
        $request_cuenta = $request->get('cuenta');
        if (!AuxFunctions::isDuplicate($em->getRepository(Cuenta::class),
            ['nro_cuenta' => $request_cuenta['nro_cuenta']],
            AuxFunctions::$ACTION_ADD)) {
            /**@var $obj_cuenta Cuenta** */

            $obj_cuenta = new Cuenta();
            $obj_cuenta
                ->setNroCuenta(strtoupper($request_cuenta['nro_cuenta']))
                ->setDescripcion(strtoupper($request_cuenta['descripcion']))
                ->setDeudora(strtoupper($request_cuenta['naturaleza']))
                ->setPatrimonio(array_key_exists('patrimonio', $request_cuenta))
                ->setProduccion(array_key_exists('produccion', $request_cuenta))
                ->setElementoGasto(array_key_exists('elemento_gasto', $request_cuenta))
                ->setActivo(true);
            try {
                $em->persist($obj_cuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cuenta adicionada satisfactoriamente");
        } else
            $this->addFlash('error', "El Nro de cuenta ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_cuenta');
    }

    /**
     * @Route("/upd", name="contabilidad_config_cuenta_upd", methods={"POST"})
     */
    public function updCuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $request_cuenta = $request->get('cuenta');
        if (!AuxFunctions::isDuplicate($em->getRepository(Cuenta::class),
            ['nro_cuenta' => $request_cuenta['nro_cuenta']],
            AuxFunctions::$ACTION_UPD, $request_cuenta['id_cuenta'])) {

            /**@var $obj_cuenta Cuenta** */
            $obj_cuenta = $em->getRepository(Cuenta::class)->find($request_cuenta['id_cuenta']);
            if (!$obj_cuenta) {
                $this->addFlash('error', "La cuenta solicitada no se encuentra en la base de datos");
            }
            $obj_cuenta
                ->setNroCuenta(strtoupper($request_cuenta['nro_cuenta']))
                ->setDescripcion(strtoupper($request_cuenta['descripcion']))
                ->setDeudora(strtoupper($request_cuenta['naturaleza']))
                ->setPatrimonio(array_key_exists('patrimonio', $request_cuenta))
                ->setProduccion(array_key_exists('produccion', $request_cuenta))
                ->setElementoGasto(array_key_exists('elemento_gasto', $request_cuenta))
                ->setActivo(true);
            try {
                $em->persist($obj_cuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Cuenta actualizada satisfactoriamente");
        } else
            $this->addFlash('error', "El Nro de cuenta ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_cuenta');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_cuenta_delete")
     */
    public function Delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->find($id);
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
}
