<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\SubcuentaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SubcuentaController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/subcuenta/{id}", name="contabilidad_config_subcuenta")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $form = $this->createForm(SubcuentaType::class);

        $subcuentas_arr = $em->getRepository(Subcuenta::class)->findBy(array(
            'id_cuenta' => $id,
            'activo' => true
        ));

        $row = [];

        if (!empty($subcuentas_arr)) {
            $descripcion = '(' . $subcuentas_arr[0]->getIdCuenta()->getNroCuenta() . ') ' . $subcuentas_arr[0]->getIdCuenta()->getDescripcion();
        } else {
            $obj_cuenta = $em->getRepository(Cuenta::class)->find($id);
            $descripcion = '(' . $obj_cuenta->getNroCuenta() . ') ' . $obj_cuenta->getDescripcion();
        }
        foreach ($subcuentas_arr as $item) {
            /**@var $item Subcuenta** */
            $row [] = array(
                'id' => $item->getId(),
                'nro_subcuenta' => $item->getNroSubcuenta(),
                'descripcion' => $item->getDescripcion(),
                'deudora' => $item->getDeudora() == true ? 'Deudora' : 'Acreedora',
            );
        }

        return $this->render('contabilidad/config/subcuenta/index.html.twig', [
            'controller_name' => 'SubcuentaController',
            'subcuentas' => $row,
            'form' => $form->createView(),
            'subtitle' => $descripcion,
            'id_cuenta' => $id
        ]);
    }

    /**
     * @Route("/contabilidad/config/subcuenta-add", name="contabilidad_config_subcuenta_add")
     */
    public function addSubcuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        if (!$this->isDuplicate($em, $request->get('nro_subcuenta'), 'add')) {
            /**@var $obj_subcuenta Subcuenta** */

            $obj_subcuenta = new Subcuenta();
            $obj_subcuenta
                ->setNroSubcuenta($request->get('nro_subcuenta'))
                ->setDescripcion($request->get('descripcion'))
                ->setDeudora($request->get('deudora'))
                ->setIdCuenta($em->getRepository(Cuenta::class)->find($request->get('id_cuenta')))
                ->setActivo(true);
            try {
                $em->persist($obj_subcuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Subcuenta adicionada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El Nro de subcuenta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/subcuenta-upd", name="contabilidad_config_subcuenta_upd")
     */
    public function updSubcuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        if (!$this->isDuplicate($em, $request->get('nro_subcuenta'), 'upd', $request->get('id_subcuenta'))) {
            /**@var $obj_subcuenta Subcuenta** */
            $obj_subcuenta = $em->getRepository(Subcuenta::class)->find($request->get('id_subcuenta'));
            if (!$obj_subcuenta) {
                $this->addFlash('error', "La subcuenta solicitada no se encuentra en la base de datos");
                return new JsonResponse(['success' => true]);
            }
            $obj_subcuenta
                ->setNroSubcuenta($request->get('nro_subcuenta'))
                ->setDescripcion($request->get('descripcion'))
                ->setDeudora($request->get('deudora'))
                ->setActivo(true);
            try {
                $em->persist($obj_subcuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Subcuenta actualizada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El Nro de subcuenta ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/subcuenta-delete/{id}", name="contabilidad_config_subcuenta_delete")
     */
    public function Delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $subcuenta_er = $em->getRepository(Subcuenta::class);
        $subcuenta_obj = $subcuenta_er->find($id);
        $msg = 'No se pudo eliminar la subcuenta seleccionada';
        $success = 'error';
        $id_cuenta = 0;
        if ($subcuenta_obj) {
            /**@var $subcuenta_obj Subcuenta** */
            $id_cuenta = $subcuenta_obj->getIdCuenta()->getId();
            $subcuenta_obj->setActivo(false);
            try {
                $em->persist($subcuenta_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Subcuenta eliminada satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id' => $id_cuenta]);
    }


    /**************-Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar-****************/
    public function isDuplicate($em, $nro_subcuenta, $action, $id = null)
    {
        $subcuenta_er = $em->getRepository(Subcuenta::class);

        $arr_obj = $subcuenta_er->findBy(array(
            'nro_subcuenta' => $nro_subcuenta,
            'activo' => true
        ));

        if ($action == 'upd') {
            foreach ($arr_obj as $obj) {
                /**@var $obj Subcuenta* */
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
