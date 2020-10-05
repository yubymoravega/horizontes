<?php

namespace App\Controller\Contabilidad\Venta;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\CuentasCliente;
use App\Form\Contabilidad\Venta\ClienteContabilidadType;
use App\Form\Contabilidad\Venta\CuentasClienteType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ClienteContabilidadController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/cliente-contabilidad")
 */
class ClienteContabilidadController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_cliente_contabilidad")
     */
    public function index(EntityManagerInterface $em, Request $request, PaginatorInterface $pagination)
    {
        $clientes_arr_obj = $em->getRepository(ClienteContabilidad::class)->findByActivo(true);
        $row = [];
        foreach ($clientes_arr_obj as $item) {
            /**@var $item ClienteContabilidad** */

            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo(),
                'fax' => $item->getFax(),
                'telefonos' => $item->getTelefonos(),
                'correos' => $item->getCorreos(),
                'direccion' => $item->getDireccion()
            );
        }
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', 1), /*page number*/
            15, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );

        $form = $this->createForm(ClienteContabilidadType::class);
        $form_cuentas = $this->createForm(CuentasClienteType::class);
        return $this->render('contabilidad/venta/cliente_contabilidad/index.html.twig', [
            'controller_name' => 'ClienteContabilidadController',
            'form' => $form->createView(),
            'form_cuentas' => $form_cuentas->createView(),
            'clientes' => $paginator
        ]);
    }


    /**
     * @Route("/add", name="contabilidad_venta_cliente_contabilidad_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ClienteContabilidadType::class);
        $form->handleRequest($request);
        /** @var ClienteContabilidad $cliente */
        $cliente = $form->getData();
        $errors = $validator->validate($cliente);
//        dd($centro_costo, $form, $request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $cliente
                    ->setActivo(true);
                $em->persist($cliente);
                $em->flush();
                $this->addFlash('success', "Cliente adicionado satisfactoriamente");

            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_venta_cliente_contabilidad');
    }

    /**
     * @Route("/add-cuentas", name="contabilidad_venta_cliente_contabilidad_add_cuentas", methods={"POST"})
     */
    public function addCuentas(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $lista = $request->get('lista');
        $id_cliente = $request->get('id_cliente');
        $cliente_er = $em->getRepository(ClienteContabilidad::class);
        $moneda_er = $em->getRepository(Moneda::class);
        /** @var ClienteContabilidad $cliente */
        $cuentas_cliente_arr = $em->getRepository(CuentasCliente::class)->findBy(array(
            'id_cliente' => $id_cliente
        ));
        if (empty($cuentas_cliente_arr)) {
            foreach ($lista as $item) {
                $new_cuenta_cliente = new CuentasCliente();
                $new_cuenta_cliente
                    ->setNroCuenta($item['nro_cuenta'])
                    ->setIdMoneda($moneda_er->find($item['moneda']))
                    ->setIdCliente($cliente_er->find($id_cliente))
                    ->setActivo(true);
                $em->persist($new_cuenta_cliente);
            }
        } else {

        }
        try {
            $em->flush();
        } catch (FileException $exception) {
            return new \Exception('La petición ha retornado un error, contacte a su proveedro de software: ' . $exception->getMessage());
        }
        return new JsonResponse(['success' => true, 'msg' => 'Datos actualizados satisfactoriamente.']);
    }

    /**
     * @Route("/{id}", name="contabilidad_venta_cliente_contabilidad_upd", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, ClienteContabilidad $cliente)
    {
        $form = $this->createForm(ClienteContabilidadType::class, $cliente);
        $form->handleRequest($request);
        $errors = $validator->validate($cliente);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($cliente);
                $em->flush();
                $this->addFlash('success', "Cliente actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_venta_cliente_contabilidad');
    }

    /**
     * @Route("/{id}", name="contabilidad_venta_cliente_contabilidad_delete",methods={"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $_obj = $em->getRepository(ClienteContabilidad::class)->find($id);
            if ($_obj) {
                /**@var $_obj ClienteContabilidad** */
                $_obj->setActivo(false);
                try {
                    $em->persist($_obj);
                    $em->flush();
                    $this->addFlash('success', 'Cliente eliminado satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el cliente');

        }
        return $this->redirectToRoute('contabilidad_venta_cliente_contabilidad');
    }

    /**
     * @Route("/getCuentasBancarias/{id}", name="contabilidad_venta_cliente_contabilidad_getcuentas",methods={"POST"})
     */
    public function getCuentasBancarias(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cuentas_clientes_array_obj = $em->getRepository(CuentasCliente::class)->findBy(array(
            'id_cliente' => $id,
            'activo' => true
        ));
        $row = [];
        if (!empty($cuentas_clientes_array_obj)) {
            /**@var $obj CuentasCliente* */
            foreach ($cuentas_clientes_array_obj as $obj) {
                $row[] = array(
                    'nro_cuenta' => $obj->getNroCuenta(),
                    'moneda' => $obj->getIdMoneda()->getId(),
                    'nombre_moneda' => $obj->getIdMoneda()->getNombre()
                );
            }
        }
        return new JsonResponse(['cuentas' => $row, 'success' => true, 'msg' => 'Datos cargados']);
    }
}
