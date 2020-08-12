<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\ConfiguracionInicial;
use App\Entity\Contabilidad\Config\Unidad;
use App\Form\Contabilidad\Config\UnidadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UnidadController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/unidad", name="contabilidad_config_unidad")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(UnidadType::class);

        $unidad_arr = $em->getRepository(Unidad::class)->findByActivo(true);
        $row = [];
        foreach ($unidad_arr as $item) {
            /**@var $item Unidad** */
            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'id_padre' => $item->getIdPadre() ? $item->getIdPadre()->getId() : '',
                'padre_nombre' => $item->getIdPadre() ? $item->getIdPadre()->getNombre() : ''
            );
        }
        return $this->render('contabilidad/config/unidad/index.html.twig', [
            'controller_name' => 'UnidadController',
            'unidades' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/unidad-add", name="contabilidad_config_unidad_add")
     */
    public function addUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        if (!$this->isDuplicate($em, $request->get('nombre'), 'add')) {
            /**@var $obj_unidad Unidad** */

            $obj_unidad = new Unidad();

            $obj_unidad->setNombre($request->get('nombre'));
            $obj_unidad->setActivo(true);
            if ($request->get('id_padre') && $request->get('id_padre') > 0) {
                $id_padre = $request->get('id_padre');
                $obj_unidad->setIdPadre($em->getRepository(Unidad::class)->find($id_padre));
            } else {
                $obj_unidad->setIdPadre(null);
            }
            try {
                $em->persist($obj_unidad);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Unidad adicionada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "La unidad ya se encuentra registrada");
        return new JsonResponse(['success' => false]);
    }


    /**
     * @Route("/contabilidad/config/unidad-upd", name="contabilidad_config_unidad_update")
     */
    public function updateUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        //dd($request);
        $id = $request->get('id');
        if (!$this->isDuplicate($em, $request->get('nombre'), 'upd', $id)) {
            /**@var $obj_unidad Unidad** */
            $obj_unidad = $em->getRepository(Unidad::class)->find($id);
            $obj_unidad->setNombre($request->get('nombre'));

            if ($request->get('id_padre')) {
                $id_padre = $request->get('id_padre');
                $obj_unidad->setIdPadre($em->getRepository(Unidad::class)->find($id_padre));
            } else {
                $obj_unidad->setIdPadre(null);
            }
            try {
                $em->persist($obj_unidad);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', 'Unidad actualizada satisfactoriamente');
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', 'La unidad ya se encuentra registrada');
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/unidad-delete/{id}", name="contabilidad_config_unidad_delete")
     */
    public function deleteUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $unidad_er = $em->getRepository(Unidad::class);

        if ($this->isPadre($unidad_er, $id)) {
            $success = 'error';
            $msg = 'La unidad a borrar tiene 1 o varias unidades subordinadas, antes de borrarla debe reubicar estas unidades';
        } else {
            $unidad_obj = $unidad_er->find($id);
            $msg = 'No se pudo eliminar el almacén';
            $success = 'error';
            if ($unidad_obj) {
                /**@var $unidad_obj Unidad** */
                $unidad_obj->setActivo(false);
                try {
                    $em->persist($unidad_obj);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Unidad eliminada satisfactoriamente';
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_unidad');
    }

    /****************--METODOS AUXILIARES*************************/

    /******Si es padre no puede eliminarse sin reuvicar las undades hijas, retorna true/false en el caso que se cumpla********/
    public function isPadre($unidad_er, $id)
    {
        $arr_unidades_hijas = $unidad_er->findBy(array(
            'id_padre' => $id,
            'activo' => true
        ));
        if (empty($arr_unidades_hijas))
            return false;
        return true;
    }

    /**************-Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar-****************/
    public function isDuplicate($em, $nombre, $action, $id = null)
    {
        $unidad_er = $em->getRepository(Unidad::class);

        $arr_obj = $unidad_er->findBy(array(
            'nombre' => $nombre,
            'activo'=>true
        ));

        if ($action == 'upd') {
            foreach ($arr_obj as $obj) {
                /**@var $obj Unidad* */
                if ($obj->getId() != $id)
                    return true;
            }
        } elseif ($action == 'add') {
            if (!empty($arr_obj))
                return true;
        }
        return false;
    }
}
