<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Entity\Contabilidad\Config\Unidad;
use App\Form\Contabilidad\Config\GrupoActivosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GrupoActivosController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/grupo-activos", name="contabilidad_config_grupo_activos")
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
                'por_ciento_deprecia_anno' => $item->getPorcientoDepreciaAnno(),
                'id_cuenta' => $item->getIdCuenta()->getId(),
                'nro_cuenta' => $item->getIdCuenta()->getNroCuenta(),
                'id_subcuenta' => $item->getIdSubcuenta()->getId(),
                'nro_subcuenta' => $item->getIdSubcuenta()->getNroSubcuenta(),
            );
        }
        return $this->render('contabilidad/config/grupo_activos/index.html.twig', [
            'controller_name' => 'GrupoActivosController',
            'grupo_activos' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/grupo-activos-add", name="contabilidad_config_grupo_activos_add")
     */
    public function addGrupo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(GrupoActivos::class);
        $params = array(
            'descripcion' => $request->get('descripcion'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_grupo_activos = new GrupoActivos();
            $obj_grupo_activos
                ->setDescripcion($request->get('descripcion'))
                ->setPorcientoDepreciaAnno(floatval($request->get('por_ciento_deprecia_anno')))
                ->setActivo(true);

            if ($request->get('id_cuenta') && $request->get('id_cuenta') > 0) {
                $obj_grupo_activos->setIdCuenta($em->getRepository(Cuenta::class)->find($request->get('id_subcuenta')));
            } else {
                $obj_grupo_activos->setIdCuenta(null);
            }

            if ($request->get('id_subcuenta') && $request->get('id_subcuenta') > 0) {
                $obj_grupo_activos->setIdSubcuenta($em->getRepository(Subcuenta::class)->find($request->get('id_subcuenta')));
            } else {
                $obj_grupo_activos->setIdSubcuenta(null);
            }

            try {
                $em->persist($obj_grupo_activos);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Grupo de activos adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Ya se encuentra registrado un grupo con esa descripción");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/grupo-activos-upd", name="contabilidad_config_grupo_activos_upd")
     */
    public function updGrupo(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(GrupoActivos::class);
        $params = array(
            'descripcion' => $request->get('descripcion'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_grupo_activos'))) {
            $obj_grupo_activos = $entity_repository->find($request->get('id_grupo_activos'));
            $obj_grupo_activos
                ->setDescripcion($request->get('descripcion'))
                ->setPorcientoDepreciaAnno(floatval($request->get('por_ciento_deprecia_anno')))
                ->setActivo(true);

            if ($request->get('id_cuenta') && $request->get('id_cuenta') > 0) {
                $obj_grupo_activos->setIdCuenta($em->getRepository(Cuenta::class)->find($request->get('id_subcuenta')));
            } else {
                $obj_grupo_activos->setIdCuenta(null);
            }

            if ($request->get('id_subcuenta') && $request->get('id_subcuenta') > 0) {
                $obj_grupo_activos->setIdSubcuenta($em->getRepository(Subcuenta::class)->find($request->get('id_subcuenta')));
            } else {
                $obj_grupo_activos->setIdSubcuenta(null);
            }

            try {
                $em->persist($obj_grupo_activos);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Grupo de activos actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "Ya se encuentra registrado un grupo con esa descripción");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/grupo-activos/{id}", name="contabilidad_config_grupo_activos_delete")
     */
    public function Delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $grupo_activos_er = $em->getRepository(GrupoActivos::class);
        $grupo_activos_obj = $grupo_activos_er->find($id);
        $msg = 'No se pudo eliminar el grupo de activos seleccionado';
        $success = 'error';
        if ($grupo_activos_obj) {
            /**@var $grupo_activos_obj GrupoActivos** */
            $grupo_activos_obj->setActivo(false);
            try {
                $em->persist($grupo_activos_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Grupo de activos eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_grupo_activos');
    }
}
