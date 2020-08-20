<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Form\Contabilidad\Config\ElementoGastoType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ElementoGastoController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/elemento-gasto", name="contabilidad_config_elemento_gasto")
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(ElementoGastoType::class);

        $elementos_gastos_arr = $em->getRepository(ElementoGasto::class)->findByActivo(true);
        $row = [];
        foreach ($elementos_gastos_arr as $item) {
            /**@var $item ElementoGasto** */

            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'codigo' => $item->getCodigo(),
                'id_cuenta' => $item->getIdCuenta() ? $item->getIdCuenta()->getId() : '',
                'cuenta' => $item->getIdCuenta()->getDescripcion()
            );
        }
        return $this->render('contabilidad/config/elemento_gasto/index.html.twig', [
            'controller_name' => '| Elemento de Gasto',
            'elemento_gasto' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/elemento-gasto-add", name="contabilidad_config_elemento_gasto_add")
     */
    public function addElementoGasto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {

        //dd($request->get('elemento_gasto')['id_cuenta']);
        //$form = $this->createForm(ElementoGastoType::class);
        //dd($form->handleRequest($request)->getData());
        $arr_request = $request->get('elemento_gasto');
        if (!$this->isDuplicate($em, $arr_request['descripcion'], 'add')) {
            /**@var $obj ElementoGasto** */

            $obj = new ElementoGasto();

            $obj->setDescripcion($arr_request['descripcion']);
            $obj->setCodigo($arr_request['codigo']);
            $obj->setActivo(true);
            $id_cuenta = $arr_request['id_cuenta'];
            $obj->setIdCuenta($em->getRepository(Cuenta::class)->find($id_cuenta));

            try {
                $em->persist($obj);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Elemento de Gasto adicionado satisfactoriamente");
        } else
            $this->addFlash('error', "Elemento de Gasto ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }

    /**
     * @Route("/contabilidad/config/elemento-gasto-upd/{id}", name="contabilidad_config_elemento_gasto_update")
     */
    public function updateElementoGasto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        $arr_request = $request->get('elemento_gasto');

        if (!$this->isDuplicate($em, $arr_request['descripcion'], 'upd', $id)) {
            /**@var ElementoGasto $elemto_gasto ** */
            $elemto_gasto = $em->getRepository(ElementoGasto::class)->find($id);
            $elemto_gasto->setDescripcion($arr_request['descripcion']);
            $elemto_gasto->setCodigo($arr_request['codigo']);
            $elemto_gasto->setIdCuenta($em->getRepository(Cuenta::class)
                ->find($arr_request['id_cuenta']));

            try {
                $em->persist($elemto_gasto);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', 'Elemento de gasto actualizado satisfactoriamente');
        } else
            $this->addFlash('error', 'Elemento de gasto ya se encuentra registrado');
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }

    /**
     * @Route("/contabilidad/config/elemento-gasto-delete/{id}", name="contabilidad_config_elemento_gasto_delete")
     */
    public function delete(EntityManagerInterface $em, $id)
    {
        $elgasto_obj = $em->getRepository(ElementoGasto::class)->find($id);
        $msg = 'No se pudo eliminar el Elemento de gasto';
        $success = 'error';
        if ($elgasto_obj) {
            /**@var $elgasto_obj ElementoGasto** */
            $elgasto_obj->setActivo(false);
            try {
                $em->persist($elgasto_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Elemento de gasto eliminado satisfactoriamente';
            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_elemento_gasto');
    }

    /**************-Indica si un objeto esta duplicado en BD,ya sea para adicionar como modificar-****************/
    public function isDuplicate($em, $nombre, $action, $id = null)
    {
        $er = $em->getRepository(ElementoGasto::class);

        $arr_obj = $er->findBy(array(
            'descripcion' => $nombre
        ));

        if ($action == 'upd') {
            foreach ($arr_obj as $obj) {
                /**@var $obj ElementoGasto* */
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
