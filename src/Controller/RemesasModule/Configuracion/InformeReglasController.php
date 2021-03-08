<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\RemesasModule\Configuracion\ConfiguracionReglasRemesas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class InformeReglasController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/informe-reglas")
 */
class InformeReglasController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_informe_reglas")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $data = [];
        $config_Reglas = $em->getRepository(ConfiguracionReglasRemesas::class)->findBy([
            'id_unidad'=>AuxFunctions::getUnidad($em,$this->getUser())
        ]);
        $data_to_work = [];
        $uniq_proveedores = [];
        $uniq_paises = [];
        foreach ($config_Reglas as $item) {
            $data_to_work[] = [
                'id'=>$item->getId(),
                'proveedor' => $item->getIdProveedor()->getNombre(),
                'pais' => $item->getIdPais()->getNombre(),
                'minimo' => number_format($item->getMinimo(), 2),
                'maximo' => number_format($item->getMaximo(), 2),
                'costo' => $item->getValorFijoCosto() > 0 ? number_format($item->getValorFijoCosto(), 2) : number_format($item->getPorcientoCosto(), 2) . '%',
                'venta' => $item->getValorFijoVenta() > 0 ? number_format($item->getValorFijoVenta(), 2) : number_format($item->getPorcientoVenta(), 2) . '%'
            ];
            if (!in_array($item->getIdPais()->getNombre(), $uniq_paises))
                $uniq_paises[count($uniq_paises)] = $item->getIdPais()->getNombre();
            if (!in_array($item->getIdProveedor()->getNombre(), $uniq_proveedores))
                $uniq_proveedores[count($uniq_proveedores)] = $item->getIdProveedor()->getNombre();
        }

        foreach ($uniq_paises as $pais) {
            $tmp_proveedores = [];
            foreach ($uniq_proveedores as $proveedor) {
                $tmp_array = [];
                foreach ($data_to_work as $element) {
                    if ($element['proveedor'] == $proveedor && $element['pais'] == $pais) {
                        $tmp_array[] = $element;
                    }
                }
                if (!empty($tmp_array))
                    $tmp_proveedores[] = [
                        'proveedor' => $proveedor,
                        'elementos' => $tmp_array
                    ];
            }
            if(!empty($tmp_proveedores))
                $data[]=[
                    'pais' => $pais,
                    'datos' => $tmp_proveedores
                ];
        }

        return $this->render('remesas_module/configuracion/informe_reglas/index.html.twig', [
            'controller_name' => 'InformeReglasController',
            'data'=>$data
        ]);
    }
}
