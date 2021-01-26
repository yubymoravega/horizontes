<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class PlantillaAgenciaController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/plantilla-agencia")
 */
class PlantillaAgenciaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_plantilla_agencia")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad' => $obj_unidad
        ]);
        $year = Date('Y');
        $rows = [];
        /** @var Empleado $item */
        foreach ($empleados as $item) {
            if (!$item->getBaja()) {
                $rows[] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'correo' => $item->getCorreo(),
                    'cargo_nombre' => $item->getIdCargo() ? $item->getIdCargo()->getNombre() : '',
                    'rol' => $item->getRol() ? $item->getRol() : '',
                    'identificacion' => $item->getIdentificacion(),
                    'telefono' => $item->getTelefono(),
                    'id_cargo' => $item->getIdCargo() ? $item->getIdCargo()->getId() : '',
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'is_usuario' => $item->getIdUsuario() ? true : false,
                    'id_unidad' => $item->getIdUnidad() ? $item->getIdUnidad()->getId() : '',
                    'unidad_nombre' => $item->getIdUnidad() ? $item->getIdUnidad()->getNombre() : '',
                    'direccion' => $item->getDireccionParticular(),
                    'fecha_alta' => $item->getFechaAlta()->format('Y-m-d')
                );
            }

        }
        return $this->render('contabilidad/capital_humano/plantilla_agencia/index.html.twig', [
            'controller_name' => 'PlantillaAgenciaController',
            'empleados' => $rows,
        ]);
    }

    /**
     * @Route("/print", name="contabilidad_capital_humano_plantilla_imprimir")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $obj_unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $empleados = $em->getRepository(Empleado::class)->findBy([
            'id_unidad' => $obj_unidad
        ]);
        $year = Date('Y');
        $rows = [];
        /** @var Empleado $item */
        foreach ($empleados as $key => $item) {
            if (!$item->getBaja()) {
                $rows[] = array(
                    'index' => $key % 2,
                    'id' => $item->getId(),
                    'nombre' => $item->getNombre(),
                    'correo' => $item->getCorreo(),
                    'cargo_nombre' => $item->getIdCargo() ? $item->getIdCargo()->getNombre() : '',
                    'rol' => $item->getRol() ? $item->getRol() : '',
                    'salario_x_hora' => number_format($item->getSalarioXHora(), 2),
                    'telefono' => $item->getTelefono(),
                    'id_cargo' => $item->getIdCargo() ? $item->getIdCargo()->getId() : '',
                    'sueldo_bruto' => number_format($item->getSueldoBrutoMensual(), 2),
                    'is_usuario' => $item->getIdUsuario() ? true : false,
                    'id_unidad' => $item->getIdUnidad() ? $item->getIdUnidad()->getId() : '',
                    'unidad_nombre' => $item->getIdUnidad() ? $item->getIdUnidad()->getNombre() : '',
                    'direccion' => $item->getDireccionParticular(),
                    'fecha_alta' => $item->getFechaAlta()->format('Y-m-d')
                );
            }

        }

        return $this->render('contabilidad/capital_humano/plantilla_agencia/print.html.twig', [
            'controller_name' => 'PrintPlantilla',
            'empleados' => $rows,
            'fecha_impresion' => Date('d-m-Y'),
            'unidad' => $obj_unidad->getCodigo() . ' - ' . $obj_unidad->getNombre()
        ]);
    }
}
