<?php

namespace App\Controller\Contabilidad\Venta;

use App\Controller\Contabilidad\Venta\IVenta\ClientesAdapter;
use App\Controller\Contabilidad\Venta\IVenta\ICliente;
use App\Form\Contabilidad\Venta\FacturaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FacturaController
 * @package App\Controller\Contabilidad\Venta
 * @Route("/contabilidad/venta/factura")
 */
class FacturaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_factura")
     */
    public function index()
    {
        $form = $this->createForm(FacturaType::class);
        return $this->render('contabilidad/venta/factura/index.html.twig', [
            'controller_name' => 'FacturaController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/get-clientes/{type}", methods={"POST"})
     */
    public function getCliente(EntityManagerInterface $em ,$type)
    {
        /** @var ICliente $cliente */
        $cliente = ClientesAdapter::getClienteFactory($em, $type);
        return new JsonResponse(['success' => true, 'clientes' => $cliente->getListClientes()]);
    }
}
