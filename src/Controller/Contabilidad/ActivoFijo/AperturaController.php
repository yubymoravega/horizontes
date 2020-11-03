<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AperturaController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/apertura")
 */
class AperturaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_apertura")
     */
    public function index()
    {
        $form = $this->createForm(MovimientoActivoFijoType::class);
        return $this->render('contabilidad/activo_fijo/apertura/index.html.twig', [
            'controller_name' => 'AperturaController',
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/getCuentas", name="contabilidad_activo_fijo_apertura_get_cuentas", methods={"POST"})
     */
    public function getCuentas(Request $request, EntityManagerInterface $em)
    {
        $row = AuxFunctions::getCuentasMovimientosEntradaActivoFijo($em);
        return new JsonResponse([
            'cuentas' => $row,
            'success' => true
        ]);
    }
    /**
     * @Route("/getNroInv/{nro_inv}", name="contabilidad_activo_fijo_apertura_get_nro_inv", methods={"POST"})
     */
    public function getNroInv(Request $request, EntityManagerInterface $em,$nro_inv)
    {
        $user = $this->getUser();
        $id_unidad = AuxFunctions::getUnidad($em,$user);
        /** @var ActivoFijo $obj_activo_fijo */
        $obj_activo_fijo = $em->getRepository(ActivoFijo::class)->findOneBy([
            'id_unidad'=>$id_unidad,
            'activo'=>true,
            'nro_inventario'=>$nro_inv
        ]);
        return new JsonResponse([
            'descripcion'=>$obj_activo_fijo?$obj_activo_fijo->getDescripcion():'',
            'id'=>$obj_activo_fijo?$obj_activo_fijo->getDescripcion():'',
            'success' => true
        ]);
    }


}
