<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Entity\TurismoModule\Utils\CreditosPrecioVenta;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Form\TurismoModule\Utils\ConfigPrecioVentaServicioType;
use App\Form\TurismoModule\Visado\SolicitudType;
use ContainerAYaIxHQ\getUserClientTmpRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class ConfigPrecioVentaController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/configuracion-turismo/gestion-consular/config-precio-venta")
 */
class ConfigPrecioVentaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_config_precio_venta")
     */
    public function index(EntityManagerInterface $em)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $elementos_visa_costo = $em->getRepository(ElementosVisa::class)->findBy([
            'activo' => true,
            'id_servicio'=>$em->getRepository(Servicios::class)->find(AuxFunctionsTurismo::IDENTIFICADOR_VISADO)
        ]);
        $costo_total = 0;
        /** @var ElementosVisa $item */
        foreach ($elementos_visa_costo as $item) {
            $costo_total += $item->getCosto();
        }
        $formulario = $this->createForm(ConfigPrecioVentaServicioType::class);
        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
        ]);

        if ($configuraciones) {
            $porciento = $configuraciones->getProciento() > 0 ? $configuraciones->getProciento() : '';
            $valor_fijo = $configuraciones->getValorFijo() > 0 ? $configuraciones->getValorFijo() : '';
            $precio_total = $configuraciones->getPrecioVentaTotal();
        } else {
            $porciento = '';
            $valor_fijo = '';
            $precio_total = 0;
        }
        $list_creditos = [];

        if ($configuraciones) {
            $listado = $em->getRepository(CreditosPrecioVenta::class)->findBy(['id_config_precio_venta' => $configuraciones]);
            if (!empty($listado)) {
                $servicios_er = $em->getRepository(Servicios::class);
                /** @var CreditosPrecioVenta $item */
                foreach ($listado as $item) {
                    $servicio_data = $servicios_er->find($item->getIdentificadorServicio());
                    $list_creditos[] = [
                        'importe_text' => number_format($item->getImporte(),2),
                        'importe' => $item->getImporte(),
                        'servicio' => $servicio_data->getId(),
                        'servicio_nombre' => $servicio_data->getNombre()
                    ];
                }
            }
        }
        return $this->render('turismo_module/visado/config_precio_venta/index.html.twig', [
            'controller_name' => 'ConfigPrecioVentaController',
            'formulario' => $formulario->createView(),
            'costo_servicio_text' => number_format($costo_total, 2),
            'costo_servicio_value' => $costo_total,
            'precio_venta_total' => number_format($precio_total , 2),
            'prociento' => $porciento,
            'valor_fijo' => $valor_fijo,
            'creditos' => $list_creditos,
        ]);
    }

    /**
     * @Route("/save", name="turismo_module_visado_config_precio_venta_save")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $config_precio_venta_servicio = $request->request->get('config_precio_venta_servicio');
        $porciento = $config_precio_venta_servicio['prociento'] != '' ? floatval($config_precio_venta_servicio['prociento']) : 0;
        $valor_fijo = $config_precio_venta_servicio['valor_fijo'] != '' ? floatval($config_precio_venta_servicio['valor_fijo']) : 0;
        $creditos_servicios = json_decode($request->request->get('mercancias'), true);

        $config_precio_venta_servicio_er = $em->getRepository(ConfigPrecioVentaServicio::class);
        $creditos_servicios_er = $em->getRepository(CreditosPrecioVenta::class);

        /** @var ConfigPrecioVentaServicio $elemto */
        $elemto = $config_precio_venta_servicio_er->findOneBy([
            'id_unidad' => $unidad,
            'identificador_servicio' => AuxFunctionsTurismo::IDENTIFICADOR_VISADO
        ]);

        if ($elemto) {
            //busco los creditos de los servicios y los elimino
            $arr_creditos = $creditos_servicios_er->findBy([
                'id_config_precio_venta' => $elemto
            ]);
            foreach ($arr_creditos as $item) {
                $em->remove($item);
            }
        } else {
            $elemto = new ConfigPrecioVentaServicio();
        }

        //recalcular el precio de venta
        $elementos_visa_costo = $em->getRepository(ElementosVisa::class)->findBy([
            'activo' => true,
        ]);
        $costo_total = 0;
        /** @var ElementosVisa $item */
        foreach ($elementos_visa_costo as $item) {
            $costo_total += $item->getCosto();
        }

        $elemto
            ->setIdentificadorServicio(AuxFunctionsTurismo::IDENTIFICADOR_VISADO)
            ->setIdUnidad($unidad)
            ->setProciento($porciento)
            ->setValorFijo($valor_fijo);
        $em->persist($elemto);

        $valor_servicios = 0;
        foreach ($creditos_servicios as $item) {
            $valor_servicios += floatval($item['importe']);
            $new_credito_servicio = new CreditosPrecioVenta();
            $new_credito_servicio
                ->setIdConfigPrecioVenta($elemto)
                ->setCredito(true)
                ->setImporte(floatval($item['importe']))
                ->setIdentificadorServicio(intval($item['servicio']));
            $em->persist($new_credito_servicio);
        }

        $total = $costo_total + $porciento + $valor_fijo + $valor_servicios;
        $elemto
            ->setPrecioVentaTotal($total);
        $em->persist($elemto);

        $em->flush();

        return $this->redirectToRoute('turismo_module_configuracion');
    }
}
