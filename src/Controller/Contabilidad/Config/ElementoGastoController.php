<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Form\Contabilidad\Config\ElementoGastoType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ElementoGastoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/elemento-gasto")
 */
class ElementoGastoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_elemento_gasto", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $form = $this->createForm(ElementoGastoType::class);

        $elementos_gastos_arr = $em->getRepository(ElementoGasto::class)->findByActivo(true);
        $row = [];
        foreach ($elementos_gastos_arr as $item) {
            /**@var $item ElementoGasto** */

            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'codigo' => $item->getCodigo(),
                'id_cuenta' => $item->getIdCuenta() ? $item->getIdCuenta()->getId() : '',
                'cuenta' => $item->getIdCuenta()->getDescripcion()
            );
        }
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', 1), /*page number*/
            15, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/config/elemento_gasto/index.html.twig', [
            'controller_name' => '| Elemento de Gasto',
            'elemento_gasto' => $paginator,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_elemento_gasto_add",methods={"POST"})
     */
    public function addElementoGasto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ElementoGastoType::class);
        $form->handleRequest($request);

        /** @var ElementoGasto $elemento */
        $elemento = $form->getData();
        $errors = $validator->validate($elemento);

        if ($form->isValid() && $form->isSubmitted()) {
            $elemento->setActivo(true);
            try {
                $em->persist($elemento);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Elemento de Gasto adicionado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_elemento_gasto_update", methods={"POST"})
     */
    public function updateElementoGasto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, ElementoGasto $elementoGasto)
    {
        $form = $this->createForm(ElementoGastoType::class, $elementoGasto);
        $form->handleRequest($request);
        $errors = $validator->validate($elementoGasto);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($elementoGasto);
                $em->flush();
                $this->addFlash('success', 'Elemento de gasto actualizado satisfactoriamente');
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_elemento_gasto_delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $em, Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $elgasto_obj = $em->getRepository(ElementoGasto::class)->find($id);
            $msg = 'No se pudo eliminar el Elemento de gasto';
            $success = 'error';
            if ($elgasto_obj) {
                /**@var $elgasto_obj ElementoGasto** */
                $elgasto_obj->setActivo(false);
                try {
                    $em->persist($elgasto_obj);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Elemento de gasto eliminado satisfactoriamente';
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }
}
