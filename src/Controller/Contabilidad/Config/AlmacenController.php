<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Almacen;
use App\Form\Contabilidad\Config\AlmacenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AlmacenController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/almacen")
 */
class AlmacenController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_almacen", methods={"GET","POST"})
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(AlmacenType::class);
        $almacen = $em->getRepository(Almacen::class)->findAll();
        $row = [];
        foreach ($almacen as $item) {
            /**@var $item Almacen** */
            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'id_unidad' => $item->getIdUnidad() ? $item->getIdUnidad()->getId() : '',
                'unidad' => $item->getIdUnidad() ? $item->getIdUnidad()->getNombre() : ''
            );
        }
        return $this->render('contabilidad/config/almacen/index.html.twig', [
            'controller_name' => 'AlmacenController',
            'almacenes' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_almacen_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(AlmacenType::class);
        $form->handleRequest($request);

        /** @var Almacen $alamcen */
        $alamcen = $form->getData();
        $errors = $validator->validate($alamcen);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $alamcen->setActivo(true);
                $em->persist($alamcen);
                $em->flush();
                $this->addFlash('success', "Alamacén adicionado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_almacen');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_almacen_edit", methods={"POST"})
     */
    public function Update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Almacen $almacen)
    {
        $form = $this->createForm(AlmacenType::class, $almacen);
        $form->handleRequest($request);
        $errors = $validator->validate($almacen);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($almacen);
                $em->flush();
                $this->addFlash('success', "Almacén actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_almacen');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_alamcen_delete", methods={"DELETE"})
     */
    public function Delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $_obj = $em->getRepository(Almacen::class)->find($id);
            if ($_obj) {
                /**@var $_obj Almacen** */
                $_obj->setActivo(false);
                try {
                    $em->persist($_obj);
                    $em->flush();
                    $this->addFlash('success', 'Almacén eliminado satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el centro de costo');

        }
        return $this->redirectToRoute('contabilidad_config_almacen');
    }
}
