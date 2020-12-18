<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\TipoDocumento;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\General\CobrosPagos;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use App\Entity\Contabilidad\Venta\Factura;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment\Doc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CuentaPorPagarController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/cuenta-por-pagar")
 */
class CuentaPorPagarController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_cuenta_por_pagar")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $today = \DateTime::createFromFormat('d-m-Y', Date('d-m-Y'));
        $row = [];
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $informe_recepcion_er = $em->getRepository(InformeRecepcion::class);
        $documento_er = $em->getRepository(Documento::class);
        $almacenes = $em->getRepository(Almacen::class)->findBy(
            ['id_unidad' => $unidad, 'activo' => true]
        );
        $tipo_documento = $em->getRepository(TipoDocumento::class)->find(1);
        /** @var Almacen $almacen */
        foreach ($almacenes as $almacen) {
            $documentos = $documento_er->findBy(
                ['id_almacen' => $almacen, 'activo' => true, 'id_tipo_documento' => $tipo_documento]
            );
            /** @var Documento $doc */
            foreach ($documentos as $doc) {
                /** @var InformeRecepcion $informe */
                $informe = $informe_recepcion_er->findOneBy([
                    'id_documento' => $doc
                ]);
                $resto = $this->getResto($em, $informe);
                if ($resto > 0) {
                    $diferencia = $today->diff($informe->getFechaFactura())->days;
                    if ($diferencia > 0 && $diferencia < 31) {
                        $row[] = [
                            'cliente' => $informe->getIdProveedor()->getNombre(),
                            'factura' => $informe->getCodigoFactura(),
                            'fecha' => $informe->getFechaFactura()->format('d-m-Y'),
                            'case_1' => number_format($resto, 2),
                            'case_2' => '',
                            'case_3' => '',
                            'case_4' => '',
                        ];
                    } elseif ($diferencia > 30 && $diferencia < 46) {
                        $row[] = [
                            'cliente' => $informe->getIdProveedor()->getNombre(),
                            'factura' => $informe->getCodigoFactura(),
                            'fecha' => $informe->getFechaFactura()->format('d-m-Y'),
                            'case_2' => number_format($resto, 2),
                            'case_1' => '',
                            'case_3' => '',
                            'case_4' => '',
                        ];
                    } elseif ($diferencia > 45 && $diferencia < 61) {
                        $row[] = [
                            'cliente' => $informe->getIdProveedor()->getNombre(),
                            'factura' => $informe->getCodigoFactura(),
                            'fecha' => $informe->getFechaFactura()->format('d-m-Y'),
                            'case_3' => number_format($resto, 2),
                            'case_2' => '',
                            'case_1' => '',
                            'case_4' => '',
                        ];
                    } else {
                        $row[] = [
                            'cliente' => $informe->getIdProveedor()->getNombre(),
                            'factura' => $informe->getCodigoFactura(),
                            'fecha' => $informe->getFechaFactura()->format('d-m-Y'),
                            'case_4' => number_format($resto, 2),
                            'case_2' => '',
                            'case_3' => '',
                            'case_1' => '',
                        ];
                    }
                }
            }
        }
        return $this->render('contabilidad/general/cuenta_por_pagar/index.html.twig', [
            'controller_name' => 'CuentaPorCobrarController',
            'obligaciones_cobro' => $row
        ]);
    }

    public
    function getResto(EntityManagerInterface $em, InformeRecepcion $obj_informe)
    {
        $cobros = $em->getRepository(CobrosPagos::class)->findBy(['id_informe' => $obj_informe]);
        $importe_factura = $obj_informe->getIdDocumento()->getImporteTotal();
        $pagos = 0;
        /** @var CobrosPagos $cobroPago */
        foreach ($cobros as $cobroPago) {
            $pagos += ($cobroPago->getDebito() + $cobroPago->getCredito());
        }
        return $importe_factura - $pagos;
    }
}
