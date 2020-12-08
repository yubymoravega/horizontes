<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Unidad;
use App\Form\Contabilidad\Config\UnidadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UnidadController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/unidad")
 */
class UnidadController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_unidad", methods={"GET"})
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(UnidadType::class);

        $unidad_arr = $em->getRepository(Unidad::class)->findByActivo(true);
        $row = [];
        foreach ($unidad_arr as $item) {
            /**@var $item Unidad** */
            $row [] = array(
                'id' => $item->getId(),
                'codigo' => $item->getCodigo(),
                'nombre' => $item->getNombre(),
                'correo' => $item->getCorreo(),
                'telefono' => $item->getTelefono(),
                'direccion' => $item->getDireccion(),
                'id_padre' => $item->getIdPadre() ? $item->getIdPadre()->getId() : '',
                'padre_nombre' => $item->getIdPadre() ? $item->getIdPadre()->getNombre() : '',
                'categoria' => $item->getIdCategoriaCliente()?$item->getIdCategoriaCliente()->getNombre():'',
                'id_categoria' => $item->getIdCategoriaCliente()?$item->getIdCategoriaCliente()->getId():'',
                'prefijo' => $item->getIdCategoriaCliente()?$item->getIdCategoriaCliente()->getPrefijo():'',
            );
        }
        return $this->render('contabilidad/config/unidad/index.html.twig', [
            'controller_name' => 'UnidadController',
            'unidades' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_unidad_add", methods={"POST"})
     */
    public function addUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(UnidadType::class);
        $form->handleRequest($request);
        /** @var Unidad $unidad */
        $unidad = $form->getData();
        $errors = $validator->validate($unidad);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $unidad->setActivo(true);
                $em->persist($unidad);
                $em->flush();
                $this->addFlash('success', "Unidad adicionada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_unidad');
    }


    /**
     * @Route("/upd/{id}", name="contabilidad_config_unidad_update")
     */
    public function updateUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Unidad $unidad)
    {

        $form = $this->createForm(UnidadType::class, $unidad);
        $form->handleRequest($request);
        $errors = $validator->validate($unidad);
        if ($unidad->getIdPadre() === $unidad) {
            $this->addFlash('error', 'La Unidad no puede ser padre de si misma');
            return $this->redirectToRoute('contabilidad_config_unidad');
        }
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($unidad);
                $em->flush();
                $this->addFlash('success', "Unidad actualizada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_unidad');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_unidad_delete", methods={"DELETE"})
     */
    public function deleteUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $unidad_er = $em->getRepository(Unidad::class);
            $success = '';
            $msg = '';
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
        }
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
            'activo' => true
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
