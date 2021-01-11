<?php


namespace App\Controller\Contabilidad\Reportes;


use App\CoreContabilidad\AuxFunctions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReportesController
 * @package App\Controller\Contabilidad\Reportes
 * @Route("/contabilidad/reportes")
 */
class ReportesController extends AbstractController
{

    /**
     * @Route("/load-unidades", name="contabilidad_reportes_load_unidades")
     */
    public function loadUnidades(EntityManagerInterface $em, Request $request)
    {
        // load unidades por el usuario en AuxFuncions::getUnidades()
        $unidades = AuxFunctions::getUnidades($em, $this->getUser());
        $row = [];
        foreach ($unidades as $unidad) {
            array_push($row, [
                'id' => $unidad->getId(),
                'nombre' => $unidad->getNombre(),
            ]);
        }

        return new JsonResponse([
            'data' => $row,
            'selected_unidad' => AuxFunctions::getUnidad($em, $this->getUser())->getId()
        ]);
    }
}