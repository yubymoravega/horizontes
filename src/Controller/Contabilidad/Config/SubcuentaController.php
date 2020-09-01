<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\SubcuentaType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
 * @Route("/contabilidad/config/subcuenta/{id_cuenta}")
 */
class SubcuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_subcuenta", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, $id_cuenta,Request $request, PaginatorInterface $pagination)
    {
        $form = $this->createForm(SubcuentaType::class);

        $subcuentas_arr = $em->getRepository(Subcuenta::class)->findBy(array(
            'id_cuenta' => $id_cuenta,
            'activo' => true
        ));

        $row = [];

        if (!empty($subcuentas_arr)) {
            $descripcion = '(' . $subcuentas_arr[0]->getIdCuenta()->getNroCuenta() . ') ' . $subcuentas_arr[0]->getIdCuenta()->getDescripcion();
        } else {
            $obj_cuenta = $em->getRepository(Cuenta::class)->find($id_cuenta);
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
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', 1), /*page number*/
            15, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        return $this->render('contabilidad/config/subcuenta/index.html.twig', [
            'controller_name' => 'SubcuentaController',
            'subcuentas' => $paginator,
            'form' => $form->createView(),
            'subtitle' => $descripcion,
            'id_cuenta' => $id_cuenta
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_subcuenta_add", methods={"POST"})
     */
    public function addSubcuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Cuenta $id_cuenta)
    {
        $form = $this->createForm(SubcuentaType::class);
        $form->handleRequest($request);
        /** @var Subcuenta $subcuenta */
        $subcuenta = $form->getData();
        $errors = $validator->validate($subcuenta);
//        dd($subcuenta);

        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $subcuenta->setActivo(true);
                $subcuenta->setIdCuenta($id_cuenta);
                $em->persist($subcuenta);
                $em->flush();
                $this->addFlash('success', "Subcuenta adicionada satisfactoriamente");

            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id_cuenta' => $id_cuenta->getId()]);
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_subcuenta_upd", methods={"POST"})
     */
    public function updSubcuenta(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Cuenta $id_cuenta, Subcuenta $subcuenta)
    {
        $form = $this->createForm(SubcuentaType::class, $subcuenta);
        $form->handleRequest($request);
        $errors = $validator->validate($subcuenta);

        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($subcuenta);
                $em->flush();
                $this->addFlash('success', "Subcuenta actualizada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id_cuenta' => $id_cuenta->getId()]);
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_subcuenta_delete", methods={"DELETE"})
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
        return $this->redirectToRoute('contabilidad_config_subcuenta', ['id_cuenta' => $id_cuenta]);
    }
}
