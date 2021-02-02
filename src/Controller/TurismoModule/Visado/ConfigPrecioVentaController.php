<?php

namespace App\Controller\TurismoModule\Visado;

use App\Entity\TurismoModule\Utils\ConfigPrecioVentaServicio;
use App\Form\TurismoModule\Utils\ConfigPrecioVentaServicioType;
use App\Form\TurismoModule\Visado\SolicitudType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConfigPrecioVentaController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/turismo/gestion-consular/config-precio-venta")
 */
class ConfigPrecioVentaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_config_precio_venta")
     */
    public function index(EntityManagerInterface $em)
    {
        $formulario = $this->createForm(ConfigPrecioVentaServicioType::class);
        $configuraciones = $em->getRepository(ConfigPrecioVentaServicio::class)->findAll();
        $rows = [];
        /** @var ConfigPrecioVentaServicio $item */
        foreach ($configuraciones as $item){
            $rows[]=[
                'identificador'=>$item->getIdentificadorServicio(),
                'porciento'=>$item->getProciento(),
                'valor_fijo'=>$item->getValorFijo()
            ];
        }
        return $this->render('turismo_module/visado/config_precio_venta/index.html.twig', [
            'controller_name' => 'ConfigPrecioVentaController',
            'formulario'=>$formulario->createView()
        ]);
    }
}
