<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\CentroCostoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CentroCostoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/centro-costo")
 */
class CentroCostoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_centro_costo", methods={"GET"})
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(CentroCostoType::class);

        $repository_arr = $em->getRepository(CentroCosto::class)->findByActivo(true);
        $row = [];
        foreach ($repository_arr as $item) {
            /**@var $item CentroCosto** */

            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo(),
                'id_cuenta' => $item->getIdCuenta() ? $item->getIdCuenta()->getId() : '',
                'nro_cuenta' => $item->getIdCuenta() ? $item->getIdCuenta()->getNroCuenta() : '',
                'id_sub_cuenta' => $item->getIdSubcuenta() ? $item->getIdSubcuenta()->getId() : '',
                'cuenta' => $item->getIdCuenta()->getDescripcion(),
                'sub_cuenta' => $item->getIdSubcuenta()->getDescripcion()
            );
        }
        return $this->render('contabilidad/config/centro_costo/index.html.twig', [
            'controller_name' => '| Centro de Costo',
            'centro_costo' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_centro_costo_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(CentroCostoType::class);
        $form->handleRequest($request);
        /** @var CentroCosto $centro_costo */
        $centro_costo = $form->getData();
        $errors = $validator->validate($centro_costo);
        dd($centro_costo, $form, $request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $centro_costo->setActivo(true);
                $em->persist($centro_costo);
                $em->flush();
                $this->addFlash('success', "Centro de Costo adicionado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_centro_costo');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_centro_costo_upd", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, CentroCosto $centroCosto)
    {
        $form = $this->createForm(CentroCostoType::class, $centroCosto);
        $form->handleRequest($request);
        $errors = $validator->validate($centroCosto);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($centroCosto);
                $em->flush();
                $this->addFlash('success', "Centro de Costo actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_centro_costo');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_centro_costo_delete",methods={"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $_obj = $em->getRepository(CentroCosto::class)->find($id);
            if ($_obj) {
                /**@var $_obj CentroCosto** */
                $_obj->setActivo(false);
                try {
                    $em->persist($_obj);
                    $em->flush();
                    $this->addFlash('success', 'Centro de costo eliminado satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el centro de costo');

        }
        return $this->redirectToRoute('contabilidad_config_centro_costo');
    }

    /**
     * @Route("/getsubcuenta/{idcuenta}", name="contabilidad_config_centro_costo_getsubcuenta", methods={"POST"})
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
}
