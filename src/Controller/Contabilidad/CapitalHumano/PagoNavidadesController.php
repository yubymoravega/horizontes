<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\CapitalHumano\NominaPago;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PagoNavidadesController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/pago-mes-13")
 */
class PagoNavidadesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_pago_navidades")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $anno = intval(Date('Y'));
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $nomina_pago_er = $em->getRepository(NominaPago::class);
        $arr_data = $nomina_pago_er->findBy([
            'anno' => $anno,
            'quincena' => 4,
            'id_unidad' => $unidad
        ]);
        if (!empty($arr_data)) {
            $message = 'El pago del mes 13 del año ' . ($anno - 1) . ' ya ha sido efectuado.';
            return $this->render('contabilidad/capital_humano/pago_navidades/error.html.twig', [
                'controller_name' => 'PagoNavidadesController',
                'message' => $message
            ]);
        }
        $empleados_er = $em->getRepository(Empleado::class);
        $empleados_unidad = $empleados_er->findBy([
            'id_unidad' => $unidad,
        ]);
        $rows = [];
        /** @var Empleado $item */
        foreach ($empleados_unidad as $item) {
            if ($item->getFechaAlta()->format('Y') <= ($anno - 1)) {
                if ($item->getFechaBaja() == null) {
                    if ($item->getFechaAlta()->format('Y') == ($anno - 1))
                        $cant_meses = 12 - intval($item->getFechaAlta()->format('m')) + 1;
                    else
                        $cant_meses = 12;
                } else {
                    if ($item->getFechaBaja()->format('Y') == $anno) {
                        $cant_meses = 12;
                    } else {
                        if ($item->getFechaBaja()->format('Y') == ($anno-1)) {
                            $cant_meses = intval($item->getFechaBaja()->format('m'));
                        }
                        else{
                            $cant_meses = 0;
                        }
                    }
                }
            } else {
                $cant_meses = 0;
            }
            if ($cant_meses > 0){
                $rows[]= array(
                    'empleado' => $item->getNombre(),
                    'cantidad_mese'=> $cant_meses,
                    'fecha_alta'=>$item->getFechaAlta()->format('d-m-y'),
                    'fecha_baja'=>$item->getFechaBaja()?$item->getFechaBaja()->format('d-m-y'):'',
                    'sueldo_bruto'=>$item->getSueldoBrutoMensual(),
                    'sueldo_bruto_calculo'=>round(($item->getSueldoBrutoMensual()/12),2),
                    'a_pagar'=>round(($item->getSueldoBrutoMensual()/12*$cant_meses),2),
                );
            }
        }
        dd($rows);
        return $this->render('contabilidad/capital_humano/pago_navidades/index.html.twig', [
            'controller_name' => 'PagoNavidadesController',
        ]);
    }
}
