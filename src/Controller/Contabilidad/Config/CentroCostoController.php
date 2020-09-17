<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
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
                'id_unidad'=>$item->getIdUnidad()->getId(),
                'unidad'=>$item->getIdUnidad()->getNombre()
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
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $id_usuario = $this->getUser();
                $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario
                ));
                if ($empleado) {
                    $centro_costo
                        ->setIdUnidad($empleado->getIdUnidad())
                        ->setActivo(true);
                    $em->persist($centro_costo);
                    $em->flush();
                    $this->addFlash('success', "Centro de Costo adicionado satisfactoriamente");
                } else {
                    $this->addFlash('error', "Usted no es empleado de la empresa");
                }
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
}
