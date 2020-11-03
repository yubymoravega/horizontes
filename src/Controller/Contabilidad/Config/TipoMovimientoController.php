<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\CrudController;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\Config\ElementoGastoType;
use App\Form\Contabilidad\Config\TipoMovimientoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TipoMovimientoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tipo-movimiento")
 */
class TipoMovimientoController extends AbstractController
{

    /**
     * @Route("/", name="contabilidad_config_tipo_movimiento", methods={"GET", "POST"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TipoMovimientoType::class);

        $tipo_movimiento_arr = $em->getRepository(TipoMovimiento::class)->findBy(['activo'=>true]);
        $row = [];
        foreach ($tipo_movimiento_arr as $item) {
            /**@var $item TipoMovimiento** */
            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'codigo' => $item->getCodigo()
            );
        }
        return $this->render('contabilidad/config/tipo_movimiento/index.html.twig', [
            'controller_name' => '| Tipo de Movimiento',
            'tipo_movimiento' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_tipo_movimiento_add",methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TipoMovimientoType::class);
        $form->handleRequest($request);

        /** @var TipoMovimiento $tm */
        $tm = $form->getData();
        $errors = $validator->validate($tm);

        if ($form->isValid() && $form->isSubmitted()) {
            $tm->setActivo(true);
            try {
                $em->persist($tm);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Tipo de movimiento adicionado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_tipo_movimiento');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_tipo_movimiento_update", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, TipoMovimiento $tm)
    {
        $form = $this->createForm(TipoMovimientoType::class, $tm);
        $form->handleRequest($request);
        $errors = $validator->validate($tm);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($tm);
                $em->flush();
                $this->addFlash('success', 'Tipo de movimiento actualizado satisfactoriamente');
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_tipo_movimiento');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_tipo_movimiento_delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $em, Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $tm = $em->getRepository(TipoMovimiento::class)->find($id);
            $msg = 'No se pudo eliminar el tipo de movimiento';
            $success = 'error';
            if ($tm) {
                /**@var $tm TipoMovimiento** */
                $tm->setActivo(false);
                try {
                    $em->persist($tm);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Tipo de movimiento eliminado satisfactoriamente';
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('contabilidad_config_tipo_movimiento');
    }
}