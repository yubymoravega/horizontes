<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Form\Contabilidad\Config\AreaResponsabilidadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AreaResponsabilidadController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/area-responsabilidad")
 */
class AreaResponsabilidadController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_area_responsabilidad")
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(AreaResponsabilidadType::class);
        $id_usuario = $this->getUser();
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $id_usuario
        ));
        $repository_arr = $em->getRepository(AreaResponsabilidad::class)->findBy([
            'activo'=>true,
            'id_unidad'=>$empleado->getIdUnidad()
        ]);
        $row = [];
        foreach ($repository_arr as $item) {
            /**@var $item AreaResponsabilidad** */
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo(),
                'id_unidad'=>$item->getIdUnidad()->getId(),
                'unidad'=>$item->getIdUnidad()->getNombre()
            );
        }
        return $this->render('contabilidad/config/area_responsabilidad/index.html.twig', [
            'controller_name' => '| Area de Responsabilidad',
            'area_responsabilidad' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_area_responsabilidad_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(AreaResponsabilidadType::class);
        $form->handleRequest($request);
        /** @var AreaResponsabilidad $area_responsabillidad */
        $area_responsabillidad = $form->getData();
        $errors = $validator->validate($area_responsabillidad);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $id_usuario = $this->getUser();
                $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario
                ));
                if ($empleado) {
                    $area_responsabillidad
                        ->setIdUnidad($empleado->getIdUnidad())
                        ->setActivo(true);

                    $duplicate = $em->getRepository(AreaResponsabilidad::class)->findOneBy([
                        'codigo'=>$area_responsabillidad->getCodigo(),
                        'id_unidad'=>$empleado->getIdUnidad()
                    ]);
                    if($duplicate){
                        $this->addFlash('error', "Ya existe un area de responsabilidad con el código ".$area_responsabillidad->getCodigo());
                        return $this->redirectToRoute('contabilidad_config_area_responsabilidad');
                    }


                    $em->persist($area_responsabillidad);
                    $em->flush();
                    $this->addFlash('success', "Area de responsabilidad adicionada satisfactoriamente");
                } else {
                    $this->addFlash('error', "Usted no es empleado de la empresa");
                }
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_area_responsabilidad');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_area_responsabilidad_upd", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, AreaResponsabilidad $areaResponsabilidad)
    {
        $form = $this->createForm(AreaResponsabilidadType::class, $areaResponsabilidad);
        $form->handleRequest($request);
        $errors = $validator->validate($areaResponsabilidad);
        if ($form->isValid() && $form->isSubmitted()) {
            try {

                /** @var AreaResponsabilidad $duplicate */
                $duplicate = $em->getRepository(AreaResponsabilidad::class)->findOneBy([
                    'codigo'=>$areaResponsabilidad->getCodigo(),
                    'id_unidad'=>$areaResponsabilidad->getIdUnidad()
                ]);
                if($duplicate && $duplicate->getId() != $areaResponsabilidad->getId()){
                    $this->addFlash('error', "Ya existe un area de responsabilidad con el código ".$areaResponsabilidad->getCodigo());
                    return $this->redirectToRoute('contabilidad_config_area_responsabilidad');
                }

                $em->persist($areaResponsabilidad);
                $em->flush();
                $this->addFlash('success', "Area de responsabilidad actualizada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_area_responsabilidad');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_area_responsabilidad_delete",methods={"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $_obj = $em->getRepository(AreaResponsabilidad::class)->find($id);
            if ($_obj) {
                /**@var $_obj AreaResponsabilidad** */
                $_obj->setActivo(false);
                try {
                    $em->persist($_obj);
                    $em->flush();
                    $this->addFlash('success', 'Area de responsabilidad eliminada satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el área de responsabilidad');
        }
        return $this->redirectToRoute('contabilidad_config_area_responsabilidad');
    }
}
