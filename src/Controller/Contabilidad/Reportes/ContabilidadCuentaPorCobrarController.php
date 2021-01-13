<?php

namespace App\Controller\Contabilidad\Reportes;

use App\CoreContabilidad\AuxFunctions;
use App\CoreContabilidad\ControllerContabilidadReport;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\CobrosPagos;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContabilidadCuentaPorCobrarController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes/contabilidad-cuenta-por-cobrar")
 */
class ContabilidadCuentaPorCobrarController extends ControllerContabilidadReport
{
    /**
     * @Route("/", name="contabilidad_reportes_contabilidad_cuenta_por_cobrar")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
//        $today = AuxFunctions::getCurrentDate($em, $unidad);
        $facturas = $em->getRepository(Factura::class)->findBy([
            'id_unidad' => $unidad,
            'activo' => true,
            'cancelada' => false,
        ]);
        $row = [];
        /** @var Factura $item */
        foreach ($facturas as $item) {
            $resto = $this->getResto($em, $item);
            if ($resto > 0) {
                $diferencia = $today->diff($item->getFechaFactura())->days;
                if ($diferencia > 0 && $diferencia < 31) {
                    $row[] = [
                        'cliente' => $this->getCliente($em, $item),
                        'factura' => 'FACT-' . $item->getNroFactura(),
                        'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                        'case_1' => number_format($resto, 2),
                        'case_2' => '',
                        'case_3' => '',
                        'case_4' => '',
                    ];
                } elseif ($diferencia > 30 && $diferencia < 46) {
                    $row[] = [
                        'cliente' => $this->getCliente($em, $item),
                        'factura' => 'FACT-' . $item->getNroFactura(),
                        'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                        'case_2' => number_format($resto, 2),
                        'case_1' => '',
                        'case_3' => '',
                        'case_4' => '',
                    ];
                } elseif ($diferencia > 45 && $diferencia < 61) {
                    $row[] = [
                        'cliente' => $this->getCliente($em, $item),
                        'factura' => 'FACT-' . $item->getNroFactura(),
                        'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                        'case_3' => number_format($resto, 2),
                        'case_2' => '',
                        'case_1' => '',
                        'case_4' => '',
                    ];
                } else {
                    $row[] = [
                        'cliente' => $this->getCliente($em, $item),
                        'factura' => 'FACT-' . $item->getNroFactura(),
                        'fecha' => $item->getFechaFactura()->format('d-m-Y'),
                        'case_4' => number_format($resto, 2),
                        'case_2' => '',
                        'case_3' => '',
                        'case_1' => '',
                    ];
                }

            }
        }
        $rows_return = [];
        $proveedor_repeat = [];
        foreach ($row as $data) {
            if (!in_array($data['cliente'], $proveedor_repeat))
                $proveedor_repeat[count($proveedor_repeat)] = $data['cliente'];
        }
        foreach ($proveedor_repeat as $proveedor) {
            $puntero = 0;
            foreach ($row as $key => $data) {
                if ($data['cliente'] == $proveedor) {
                    $rows_return[] = [
                        'cliente' => $puntero == 0 ? $proveedor : '',
                        'factura' => $data['factura'],
                        'fecha' => $data['fecha'],
                        'case_4' => $data['case_4'],
                        'case_2' => $data['case_2'],
                        'case_3' => $data['case_3'],
                        'case_1' => $data['case_1'],
                    ];
                    $puntero++;
                }
            }
        }

        return $this->render('contabilidad/reportes/contabilidad_cuenta_por_cobrar/index.html.twig', [
            'controller_name' => 'CuentaPorCobrarController',
            'obligaciones_cobro' => $rows_return
        ]);
    }

    public function getResto(EntityManagerInterface $em, Factura $obj_factura)
    {
        $cobros = $em->getRepository(CobrosPagos::class)->findBy(['id_factura' => $obj_factura]);
        $importe_factura = $obj_factura->getImporte();
        $pagos = 0;
        /** @var CobrosPagos $cobroPago */
        foreach ($cobros as $cobroPago) {
            $pagos += ($cobroPago->getDebito() + $cobroPago->getCredito());
        }
        return $importe_factura - $pagos;
    }

    public function getCliente(EntityManagerInterface $em, Factura $obj_factura)
    {
        $tipo_cliente = $obj_factura->getTipoCliente();
        $id_cliente = $obj_factura->getIdCliente();
        $cliente = $em->getRepository(Cliente::class);
        $unidad = $em->getRepository(Unidad::class);
        $cliente_contabilidad = $em->getRepository(ClienteContabilidad::class);
        switch ($tipo_cliente) {
            case 1:
                $nombre_cliente = $cliente->find($id_cliente)->getNombre();
                break;
            case 2:
                $nombre_cliente = $unidad->find($id_cliente)->getNombre();
                break;
            case 3:
                $nombre_cliente = $cliente_contabilidad->find($id_cliente)->getNombre();
                break;
        }
        return $nombre_cliente;
    }
}
