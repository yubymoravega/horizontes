<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\SubcuentaType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SubcuentaController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/subcuenta")
 */
class SubcuentaController extends AbstractController
{
    /**
     * @Route("/{id}", name="contabilidad_config_subcuenta", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, $id)
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
     * @Route("/add", name="contabilidad_config_subcuenta_add", methods={"POST"})
     */
    public function addSubcuenta(EntityManagerInterface $em, Request $request)
    {
        $obj_request = $request->get('subcuenta');
        if (!AuxFunctions::isDuplicate($em->getRepository(Subcuenta::class),
            ['nro_subcuenta' => $obj_request['nro_subcuenta']], AuxFunctions::$ACTION_ADD)) {
            /**@var $obj_subcuenta Subcuenta** */

            $obj_subcuenta = new Subcuenta();
            $obj_subcuenta
                ->setNroSubcuenta($obj_request['nro_subcuenta'])
                ->setDescripcion($obj_request['descripcion'])
                ->setDeudora($obj_request['naturaleza'])
                ->setIdCuenta($em->getRepository(Cuenta::class)->find($obj_request['id_cuenta']))
                ->setActivo(true);
            try {
                $em->persist($obj_subcuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Subcuenta adicionada satisfactoriamente");
        } else
            $this->addFlash('error', "El Nro de subcuenta ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id' => $obj_request['id_cuenta']]);
    }

    /**
     * @Route("/upd", name="contabilidad_config_subcuenta_upd", methods={"POST"})
     */
    public function updSubcuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $obj_request = $request->get('subcuenta');
        if (!AuxFunctions::isDuplicate($em->getRepository(Subcuenta::class),
            ['nro_subcuenta' => $obj_request['nro_subcuenta']],
            AuxFunctions::$ACTION_UPD, $obj_request['id_subcuenta'])) {

            /**@var $obj_subcuenta Subcuenta** */
            $obj_subcuenta = $em->getRepository(Subcuenta::class)->find($obj_request['id_subcuenta']);
            if (!$obj_subcuenta) {
                $this->addFlash('error', "La subcuenta solicitada no se encuentra en la base de datos");
                return new JsonResponse(['success' => true]);
            }
            $obj_subcuenta
                ->setNroSubcuenta($obj_request['nro_subcuenta'])
                ->setDescripcion($obj_request['descripcion'])
                ->setDeudora($obj_request['naturaleza'])
                ->setActivo(true);
            try {
                $em->persist($obj_subcuenta);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Subcuenta actualizada satisfactoriamente");
        } else $this->addFlash('error', "El Nro de subcuenta ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id' => $obj_request['id_cuenta']]);
    }

    /**
     * @Route("/delete/{id}/{id_cuenta}", name="contabilidad_config_subcuenta_delete", methods={"DELETE"})
     */
    public function Delete(Request $request, $id, $id_cuenta)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $subcuenta_er = $em->getRepository(Subcuenta::class);
            $subcuenta_obj = $subcuenta_er->find($id);
            $msg = 'No se pudo eliminar la subcuenta seleccionada';
            $success = 'error';
            if ($subcuenta_obj) {
                /**@var $subcuenta_obj Subcuenta** */
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
        }
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id' => $id_cuenta]);
    }
}
