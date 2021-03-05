<?php

namespace App\Controller;

use App\Entity\Provincias;
use App\Entity\Municipios;
use App\Entity\Carrito;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\TasaDeCambio;
use App\Entity\Trasacciones;
use App\Entity\ReporteEfectivo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cotizacion;
use Symfony\Component\HttpFoundation\Request;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout-services", name="checkout_services")
     */
    public function checkout_services(EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $carrito = $em->getRepository(Carrito::class)->findBy(['empleado' => $user->getUsername()]);

        if (empty($carrito)) {
            $this->addFlash(
                'success',
                'Nada a facturar'
            );
            return $this->redirectToRoute('home');
        }
        $data = [];
        $total = 0;

        /** @var Carrito $item */
        foreach ($carrito as $key=>$item) {
            $json_array = $item->getJson();

            $json_array_data = $json_array['data'];

            $data[] = [
                'id'=>$key,
                'servicio' => $json_array['nombre_servicio'],
                'sub_total' => number_format($json_array['total'], 2),
                'precio_servicio' => number_format($json_array['precio_servicio'], 2),
                'id_cliente' => $json_array['id_cliente'],
                'id_servicio' => $json_array['id_servicio'],
                'data' => $json_array_data
            ];
            $total += floatval($json_array['total']);
        }
        return $this->render('checkout/index.html.twig', [
            'carrito' => $data,
            'total'=>number_format($total,2)
        ]);
    }
}
