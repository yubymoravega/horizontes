<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Form\Contabilidad\Config\GrupoActivosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class GrupoActivosController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/grupo-activos")
 */
class GrupoActivosController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_grupo_activos", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(GrupoActivosType::class);

        $grupo_activos_arr = $em->getRepository(GrupoActivos::class)->findByActivo(true);
        $row = [];
        foreach ($grupo_activos_arr as $item) {
            /**@var $item GrupoActivos** */
            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'codigo' => $item->getCodigo(),
                'por_ciento_deprecia_anno' => $item->getPorcientoDepreciaAnno()
            );
        }
        return $this->render('contabilidad/config/grupo_activos/index.html.twig', [
            'controller_name' => 'GrupoActivosController',
            'grupo_activos' => $row,
            'form' => $form->createView()
        ]);
    }



    /**
     * @Route("/add", name="contabilidad_config_grupo_activos_add", methods={"POST"})
     */
    public function addGrupo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(GrupoActivosType::class);
        $form->handleRequest($request);
        /** @var GrupoActivos $grupo_activos */
        $grupo_activos = $form->getData();
        $errors = $validator->validate($grupo_activos);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $grupo_activos->setActivo(true);
                $em->persist($grupo_activos);
                $em->flush();
                $this->addFlash('success', "Grupo de activos adicionado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_grupo_activos');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_grupo_activos_upd",methods={"POST"})
     */
    public function updGrupo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, GrupoActivos $activos)
    {
        $form = $this->createForm(GrupoActivosType::class, $activos);
        $form->handleRequest($request);
        $errors = $validator->validate($activos);

        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($activos);
                $em->flush();
                $this->addFlash('success', "Grupo de activos actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_grupo_activos');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_grupo_activos_delete", methods={"DELETE"})
     */
    public function Delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $grupo_activos_obj = $em->getRepository(GrupoActivos::class)->find($id);
            if ($grupo_activos_obj) {
                /**@var $grupo_activos_obj GrupoActivos** */
                $grupo_activos_obj->setActivo(false);
                try {
                    $em->persist($grupo_activos_obj);
                    $em->flush();
                    $this->addFlash('success', 'Grupo de activos eliminado satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el grupo de activos seleccionado');
        }
        return $this->redirectToRoute('contabilidad_config_grupo_activos');
    }
}
