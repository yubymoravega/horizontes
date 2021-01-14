<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NominaPagoController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/nomina-pago")
 */
class NominaPagoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_nomina_pago")
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        $obj_unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad'=>$obj_unidad
        ]);
        $year = Date('Y');
        $rows = [];
        /** @var Empleado $item */
        $index = 0;
        foreach ($empleados as $item){
            if(!$item->getBaja()){
                $index++;
                $rows[] = array(
                    'nro'=>$index,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(),2),
                    'comision_mensual' => number_format($item->getSalarioXHora(),2),
                    'vacaiones' => number_format($item->getSalarioXHora(),2),

                );
            }

        }

        return $this->render('contabilidad/capital_humano/nomina_pago/index.html.twig', [
            'controller_name' => 'NominaPagoController',
            'empleados' => $rows,
        ]);
    }
}
