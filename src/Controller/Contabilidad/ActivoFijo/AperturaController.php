<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\MovimientoActivoFijo;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TipoMovimiento;
use App\Form\Contabilidad\ActivoFijo\MovimientoActivoFijoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AperturaController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/apertura")
 */
class AperturaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_apertura", methods={"GET","POST"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MovimientoActivoFijoType::class);
        $error = null;
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $movimiento_apertura = $request->get('movimiento_activo_fijo');
            $nro_inventatio = $movimiento_apertura['nro_inventatio'];
            $descripcion = $movimiento_apertura['descripcion'];
            $id_cuenta = $movimiento_apertura['id_cuenta'];
            $id_subcuenta = $movimiento_apertura['id_subcuenta'];
            $fundamentacion = $movimiento_apertura['fundamentacion'];
            $fecha = isset($movimiento_apertura['fecha']) ? \DateTime::createFromFormat('Y-m-d', $movimiento_apertura['fecha']) : null;
            $anno = $fecha->format('Y');

            $user = $this->getUser();
            $obj_unidad = AuxFunctions::getUnidad($em,$user);
            $obj_activo = $em->getRepository(ActivoFijo::class)->findOneBy([
                'nro_inventario'=>$nro_inventatio,
                'descripcion'=>$descripcion,
                'activo'=>true,
                'id_unidad'=>$obj_unidad
            ]);

            if(!$obj_activo)
                return new JsonResponse(['success'=>false,'msg'=>'El Activo Fijo no existe, en esta unidad']);

            $duplicate = $em->getRepository(MovimientoActivoFijo::class)->findOneBy([
                'activo'=>true,
                'id_activo_fijo'=>$obj_activo,
                'id_unidad'=>$obj_unidad
            ]);
            if($duplicate){
                $this->addFlash('error','El Activo Fijo ya existe, en esta unidad');
                return $this->render('contabilidad/activo_fijo/apertura/index.html.twig', [
                    'controller_name' => 'AperturaController',
                    'formulario' => $form->createView()
                ]);
            }


            $new_movimiento = new MovimientoActivoFijo();
            $new_movimiento
                ->setIdTipoMovimiento($em->getRepository(TipoMovimiento::class)->find(1))
                ->setIdUnidad($obj_unidad)
                ->setIdUsuario($user)
                ->setIdActivoFijo($obj_activo)
                ->setIdCuenta($em->getRepository(Cuenta::class)->find($id_cuenta))
                ->setIdSubcuenta($em->getRepository(Subcuenta::class)->find($id_subcuenta))
                ->setNroConsecutivo(1)
                ->setActivo(true)
                ->setAnno($anno)
                ->setFecha($fecha)
                ->setEntrada(true)
                ->setFundamentacion($fundamentacion);
            $em->persist($new_movimiento);
            try {
                $em->flush();
            }
            catch (FileException $em){
                return $em->getMessage();
            }
        }
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
