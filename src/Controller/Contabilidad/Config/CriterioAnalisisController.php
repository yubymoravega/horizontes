<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CriterioAnalisis;
use App\Form\Contabilidad\Config\CriterioAnalisisType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CriterioAnalisisController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/criterio-analisis")
 */
class CriterioAnalisisController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_criterio_analisis")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {

        $form = $this->createForm(CriterioAnalisisType::class);

        $criterios_arr = $em->getRepository(CriterioAnalisis::class)->findByActivo(true);
        $row = [];
        foreach ($criterios_arr as $item) {
            /**@var $item CriterioAnalisis** */

            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'abreviatura' => $item->getAbreviatura()
            );
        }
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', 1), /*page number*/
            15, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/config/criterio_analisis/index.html.twig', [
            'controller_name' => '| Critero de Análisis',
            'criterios' => $paginator,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/getAllActive/", name="contabilidad_config_criterio_analisis_getAll",methods={"POST"})
     */
    public function getAllActive(EntityManagerInterface $em, Request $request)
    {
        $criterios_arr = $em->getRepository(CriterioAnalisis::class)->findByActivo(true);
        $row = [];
        foreach ($criterios_arr as $item) {
            /**@var $item CriterioAnalisis** */
            $row [] = array(
//                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'abreviatura' => $item->getAbreviatura()
            );
        }
        return new JsonResponse(['data' => $row, 'success' => true]);
    }


    /**
     * @Route("/add", name="contabilidad_config_criterio_analisis_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(CriterioAnalisisType::class);
        $form->handleRequest($request);

        /** @var CriterioAnalisis $criterio */
        $criterio = $form->getData();
        $errors = $validator->validate($criterio);

        if ($form->isValid() && $form->isSubmitted()) {
            $criterio_uper = new CriterioAnalisis();
            $criterio_uper->setNombre(strtoupper($criterio->getNombre()));
            $criterio_uper->setAbreviatura(strtoupper($criterio->getAbreviatura()));
            $criterio_uper->setActivo(true);
            try {
                $em->persist($criterio_uper);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Criterio de análisis adicionado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_criterio_analisis');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_criterio_analisis_update", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, CriterioAnalisis $criterio)
    {
        $form = $this->createForm(CriterioAnalisisType::class, $criterio);
        $form->handleRequest($request);
        $errors = $validator->validate($criterio);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $criterio_uper = new CriterioAnalisis();
                $criterio_uper->setNombre(strtoupper($criterio->getNombre()));
                $criterio_uper->setAbreviatura(strtoupper($criterio->getAbreviatura()));
                $em->persist($criterio);
                $em->flush();
                $this->addFlash('success', 'Criterio de análisis actualizado satisfactoriamente');
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_criterio_analisis');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_criterio_analisis_delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $em, Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $elgasto_obj = $em->getRepository(CriterioAnalisis::class)->find($id);
            $msg = 'No se pudo eliminar el criterio de análisis';
            $success = 'error';
            if ($elgasto_obj) {
                /**@var $elgasto_obj CriterioAnalisis** */
                $elgasto_obj->setActivo(false);
                try {
                    $em->persist($elgasto_obj);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Criterio de análisis eliminado satisfactoriamente';
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('contabilidad_config_criterio_analisis');
    }
}
