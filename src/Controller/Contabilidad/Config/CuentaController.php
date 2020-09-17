<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
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
     * @Route("/", name="contabilidad_config_cuenta")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $form = $this->createForm(CuentaType::class);
        $cuentas_arr = $em->getRepository(Cuenta::class)->findByActivo(true);
        $row = [];
        foreach ($cuentas_arr as $item) {

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
        $form = $this->createForm(CuentaTypeFirst::class);
        $form->handleRequest($request);

        /** @var Cuenta $cuenta */
        $cuenta = $form->getData();
        $errors = $validator->validate($cuenta);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $cuenta->setActivo(true);
                $em->persist($cuenta);
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
        $form = $this->createForm(CuentaTypeFirst::class, $cuenta);
        $form->handleRequest($request);
        $errors = $validator->validate($cuenta);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($cuenta);
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
}
