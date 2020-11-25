<?php

namespace App\Controller\Contabilidad\Inventario;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Inventario\Producto;
use App\Form\Contabilidad\Inventario\ProductoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Yaml\Yaml;

class ProductoController extends AbstractController
{
    /**
     * @Route("/contabilidad/inventario/producto", name="contabilidad_inventario_producto")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $productos_arr = $em->getRepository(Producto::class)->findByActivo(true);
        $row = [];
        foreach ($productos_arr as $item) {
            /**@var $item Producto***/
            $row [] = array(
                'id' => $item->getId(),
                'descripcion' => $item->getDescripcion(),
                'existencia'=>$item->getExistencia(),
                'codigo'=>$item->getCodigo(),
                'importe'=>$item->getImporte(),
                'precio'=> number_format(($item->getImporte()/$item->getExistencia()),3,'.',''),
                'um' => $item->getIdUnidadMedida()->getNombre(),
                'cuenta'=>$item->getCuenta()
            );
        }
        return $this->render('contabilidad/inventario/producto/index.html.twig', [
            'controller_name' => 'ProductoController',
            'productos' => $row,
        ]);
    }

    /**
     * @Route("/contabilidad/inventario/producto-add", name="contabilidad_inventario_producto_add")
     */
    public function addProducto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Producto::class);
        $params = array(
            'codigo' => $request->get('codigo'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            $obj_cargo = new Producto();

            $obj_cargo
                ->setDescripcion($request->get('descripcion'))
                ->setCodigo($request->get('codigo'))
                ->setPrecioCosto(floatval($request->get('precio_costo')))
                ->setActivo(true);
            try {
                $em->persist($obj_cargo);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Producto adicionado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El producto ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/inventario/producto-upd", name="contabilidad_inventario_producto_upd")
     */
    public function updProducto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(Producto::class);
        $params = array(
            'codigo' => $request->get('codigo'),
            'activo' => true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'upd', $request->get('id_producto'))) {
            $obj_producto = $entity_repository->find($request->get('id_producto'));
            /**@var $obj_producto Producto**/
            $obj_producto
                ->setDescripcion($request->get('descripcion'))
                ->setCodigo($request->get('codigo'))
                ->setPrecioCosto(floatval($request->get('precio_costo')))
                ->setActivo(true);
            try {
                $em->persist($obj_producto);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Producto actualizado satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "El producto ya se encuentra registrado");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/inventario/producto-delete/{id}", name="contabilidad_inventario_producto_delete")
     */
    public function deleteProducto($id)
    {
        $em = $this->getDoctrine()->getManager();

        $producto_er = $em->getRepository(Producto::class);
        $producto_obj = $producto_er->find($id);
        $msg = 'No se pudo eliminar el producto seleccionado';
        $success = 'error';
        if ($producto_obj) {
            /**@var $producto_obj Producto** */
            $producto_obj->setActivo(false);
            try {
                $em->persist($producto_obj);
                $em->flush();
                $success = 'success';
                $msg = 'Producto eliminado satisfactoriamente';

            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_inventario_producto');
    }
}
