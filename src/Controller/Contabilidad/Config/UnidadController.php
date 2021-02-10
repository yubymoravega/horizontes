<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Banco;
use App\Entity\Contabilidad\Config\CuentasUnidad;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\CuentasCliente;
use App\Form\Contabilidad\Config\UnidadType;
use App\Form\Contabilidad\Venta\CuentasClienteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $form_cuentas = $this->createForm(CuentasClienteType::class);

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
            );
        }
        return $this->render('contabilidad/config/unidad/index.html.twig', [
            'controller_name' => 'UnidadController',
            'unidades' => $row,
            'form_cuentas' => $form_cuentas->createView(),
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

    /**
     * @Route("/add-cuentas", name="contabilidad_config_unidad_add_cuentas", methods={"POST"})
     */
    public function addCuentas(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $lista = $request->get('lista');
        $unidad = $request->get('id_unidad');
        $moneda_er = $em->getRepository(Moneda::class);
        $banco_er = $em->getRepository(Banco::class);
        $unidad_er = $em->getRepository(Unidad::class);
        $cuenta_unidad_er = $em->getRepository(CuentasUnidad::class);

        /** @var ClienteContabilidad $cliente */
        $cuentas_unidad_arr = $cuenta_unidad_er->findBy(array(
            'id_unidad' => $unidad
        ));
        if (empty($cuentas_unidad_arr)) {
            foreach ($lista as $item) {
                $new_cuenta_unidad = new CuentasUnidad();
                $new_cuenta_unidad
                    ->setNroCuenta($item['nro_cuenta'])
                    ->setIdMoneda($moneda_er->find($item['moneda']))
                    ->setIdBanco($banco_er->find(($item['banco'])))
                    ->setIdUnidad($unidad_er->find($unidad))
                    ->setActivo(true);
                $em->persist($new_cuenta_unidad);
            }
        } else {
            foreach ($lista as $item) {
                $moneda = $moneda_er->find($item['moneda']);
                $nro = $item['nro_cuenta'];
                /**@var $obj CuentasUnidad**/
                $flag = false;
                foreach ($cuentas_unidad_arr as $obj){
                    if($obj->getIdMoneda() == $moneda && $obj->getNroCuenta() == $nro)
                        $flag = true;
                }
                if(!$flag){
                    $new_cuenta_unidad = new CuentasUnidad();
                    $new_cuenta_unidad
                        ->setNroCuenta($item['nro_cuenta'])
                        ->setIdMoneda($moneda_er->find($item['moneda']))
                        ->setIdUnidad($unidad_er->find($unidad))
                        ->setActivo(true);
                    $em->persist($new_cuenta_unidad);
                }
            }

            //Elimino las cuentas que el usuario quito
            foreach ($cuentas_unidad_arr as $obj){
                $delete_flag = true;
                foreach ($lista as $item){
                    $moneda = $moneda_er->find($item['moneda']);
                    $nro = $item['nro_cuenta'];
                    if($obj->getIdMoneda() == $moneda && $obj->getNroCuenta() == $nro){
                        $delete_flag = false;
                        break;
                    }
                }
                if($delete_flag){
                    $obj->setActivo(false);
                    $em->persist($obj);
                }
            }
        }
        try {
            $em->flush();
        } catch (FileException $exception) {
            return new \Exception('La petición ha retornado un error, contacte a su proveedro de software: ' . $exception->getMessage());
        }
        return new JsonResponse(['success' => true, 'msg' => 'Datos actualizados satisfactoriamente.']);
    }

    /**
     * @Route("/getCuentasBancarias/{id}", name="contabilidad_config_unidad_getcuentas",methods={"POST"})
     */
    public function getCuentasBancarias(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cuentas_unidad_array_obj = $em->getRepository(CuentasUnidad::class)->findBy(array(
            'id_unidad' => $id,
            'activo' => true
        ));
        $row = [];
        if (!empty($cuentas_unidad_array_obj)) {
            /**@var $obj CuentasUnidad* */
            foreach ($cuentas_unidad_array_obj as $obj) {
                $row[] = array(
                    'nro_cuenta' => $obj->getNroCuenta(),
                    'moneda' => $obj->getIdMoneda()->getId(),
                    'nombre_moneda' => $obj->getIdMoneda()->getNombre(),
                    'banco' => $obj->getIdBanco()->getId(),
                    'nombre_banco' => $obj->getIdBanco()->getNombre()
                );
            }
        }
        return new JsonResponse(['cuentas' => $row, 'success' => true, 'msg' => 'Datos cargados']);
    }
}
