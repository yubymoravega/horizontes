<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Almacen;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Contabilidad\Config\AlmacenType;
use App\Form\Contabilidad\Config\AlmacenEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AlmacenController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/almacen", name="contabilidad_config_almacen")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(AlmacenType::class);
        $form->handleRequest($request);
        $errors = null;

        if ($form->isSubmitted()) {
            /** @var Almacen $almacen */
            $almacen = $form->getData();
            $errors = $validator->validate($almacen);

            if ($form->isValid()) {
                $almacen->setActivo(true);
                $em->persist($almacen);
                $em->flush();
                $this->addFlash('success', 'Almacén creado satisfactoriamente');
                $form = $this->createForm(AlmacenType::class);
            }
        }
        //dd($request->request);
        if ($errors) {
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $this->addFlash('error', $error->getMessage());
            }
        }
        //list de almacenes
        $arr_almacen = $em->getRepository(Almacen::class)->findByActivo(true);
        return $this->render('contabilidad/config/almacen/index.html.twig', [
            'almacenes' => $arr_almacen,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("contabilidad/config/almacen-edit/{id}", name="contabilidad_config_almacen_edit")
     */
    public function UpdateAlmacen(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        /** @var Almacen $almacen_current */
        $almacen_current = $em->getRepository(Almacen::class)->find($id);
        if (!$almacen_current) {
            $this->addFlash('error', 'El Almacén no pudo ser editado, no existe');
            return $this->redirectToRoute('contabilidad_config_almacen');
        }

        if ($request->isMethod(Request::METHOD_GET))
            $form = $this->createForm(AlmacenEditType::class, $almacen_current);
        else
            $form = $this->createForm(AlmacenEditType::class);

        $form->handleRequest($request);
        $errors = null;

        if ($form->isSubmitted()) {
            /** @var Almacen $almacen */
            $almacen = $form->getData();
            $errors = $validator->validate($almacen);

            if ($form->isValid()) {
                $almacen_current->setDescripcion($almacen->getDescripcion());
                $em->flush();
                $this->addFlash('success', 'Almacén actualizado satisfactoriamente');
                return $this->redirectToRoute('contabilidad_config_almacen');
            }
        }

        if ($errors) {
            foreach ($errors as $error) {
                /** @var ConstraintViolation $error */
                $this->addFlash('error', $error->getMessage());
            }
        }

        //list de almacenes
        $arr_almacen = $em->getRepository(Almacen::class)->findByActivo(true);
        return $this->render('contabilidad/config/almacen/almacen_update.html.twig', [
            'descrip' => $almacen_current->getDescripcion(),
            'almacenes' => $arr_almacen,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("contabilidad/config/almacen-delete/{id}", name="contabilidad_config_almacen_delete")
     */
    public function DeleteAlmacen(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $almacen = $em->getRepository(Almacen::class)->find($id);
        if ($almacen) {
            $almacen->setActivo(false);
            $em->persist($almacen);
            $em->flush();
            $this->addFlash('success', 'Almacén eliminado satisfactoriamente');
            //return $this->redirectToRoute('contabilidad_config_almacen');
        }
        $this->addFlash('error', 'El Almacén no pudo ser eliminado');
        return $this->redirectToRoute('contabilidad_config_almacen');
    }
}
