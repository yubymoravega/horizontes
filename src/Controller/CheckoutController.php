<?php

namespace App\Controller;

use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\Provincias;
use App\Entity\Municipios;
use App\Entity\Carrito;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\TasaDeCambio;
use App\Entity\Trasacciones;
use App\Entity\ReporteEfectivo;
use App\Entity\User;
use App\Form\Cotizacion\PlanificacionPagosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cotizacion;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CheckoutController
 * @package App\Controller
 * @Route("/checkout-services")
 */
class CheckoutController extends AbstractController
{
    /**
     * @Route("/", name="checkout_services")
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
        $data_servicios = [];
        $total = 0;

        /** @var Carrito $item */
        foreach ($carrito as $key => $item) {
            $json_array = $item->getJson();
            $data_servicios[] = $item->getJson();
            $json_array_data = $json_array['data'];

            $data[] = [
                'id' => $key,
                'servicio' => $json_array['nombre_servicio'],
                'sub_total' => number_format($json_array['total'], 2),
                'precio_servicio' => number_format($json_array['precio_servicio'], 2),
                'id_cliente' => $json_array['id_cliente'],
                'id_servicio' => $json_array['id_servicio'],
                'data' => $json_array_data
            ];
            $total += floatval($json_array['total']);
        }

        $minimo = AuxFunctionsTurismo::getMinimoPagarJson($em, $data_servicios);

        $form = $this->createForm(PlanificacionPagosType::class);
        return $this->render('checkout/index.html.twig', [
            'carrito' => $data,
            'total' => number_format($total, 2),
            'form' => $form->createView(),
            'minimo_pagar'=>$minimo
        ]);
    }

    /**
     * @Route("/cotizacion", name="make_cotizacion")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        dd($request);
        $nombre_empleado = $this->getUser()->getUsername();
        $carrito_er = $em->getRepository(Carrito::class);

        $solicitudes_carrito = $carrito_er->findBy(['empleado' => $nombre_empleado]);

        $data = [];
        /** @var Carrito $item */
        $id_cliente = 0;
        $total = 0;
        foreach ($solicitudes_carrito as $item) {
            $data[] = $item->getJson();
            $json = $item->getJson();
            $id_cliente = $json['id_cliente'];
            $total += floatval($json['total']);
            $em->remove($item);
        }

        /** @var Cliente $obj_cliente */
        $obj_cliente = $em->getRepository(Cliente::class)->find(intval($id_cliente));

        $obj_usuario = $em->getRepository(User::class)->find($this->getUser());

        if (!empty($data)) {
            $new_cotizacion = new Cotizacion();
            $new_cotizacion
                ->setIdCliente($id_cliente)
                ->setIdMoneda($obj_usuario->getIdMoneda())
                ->setDatetime(new DateTime('NOW'))
                ->setEdit(true)
                ->setEmpleado($nombre_empleado)
                ->setJson($data)
                ->setNombreCliente($obj_cliente->getNombre())
                ->setPagado(false)
                ->setTotal($total);
            $em->persist($new_cotizacion);
            $em->flush();
        }
        return $this->redirectToRoute('cotizacion');
    }
}
