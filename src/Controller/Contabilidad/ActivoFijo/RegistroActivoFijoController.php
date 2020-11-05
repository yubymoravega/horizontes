<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistroActivoFijoController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo/registro")
 */
class RegistroActivoFijoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_registro_activo_fijo")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/index.html.twig', [
            'controller_name' => 'RegistroActivoFijoController',
            'datos'=>$this->getData($em,$request)
        ]);
    }

    public function getData(EntityManagerInterface $em, Request $request){
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $arr_activos = $em->getRepository(ActivoFijo::class)->findBy([
            'activo'=>true,
            'id_unidad'=>$unidad
        ]);

        $arr_area_responsabilidad = [];
        /** @var ActivoFijo $activo */
        foreach ($arr_activos as $activo){
            if(!in_array($activo->getIdAreaResponsabilidad()->getId(),$arr_area_responsabilidad)){
                $arr_area_responsabilidad[count($arr_area_responsabilidad)]=$activo->getIdAreaResponsabilidad()->getId();
            }
        }
        $rows = [];
        foreach ($arr_area_responsabilidad as $ar){
            $row = [];
            /** @var ActivoFijo $activo */
            foreach ($arr_activos as $activo){
                if($activo->getIdAreaResponsabilidad()->getId() == $ar){
                    /** @var ActivoFijoCuentas $obj_cuenta */
                    $obj_cuenta = $em->getRepository(ActivoFijoCuentas::class)->findOneBy([
                        'id_activo'=>$activo
                    ]);
                    $row[]= array(
                        'id'=>$activo->getId(),
                        'nro_inventario'=>$activo->getNroInventario(),
                        'descripcion'=>$activo->getDescripcion(),
                        'grupo_activo'=>$activo->getIdGrupoActivo()->getCodigo().' - '.$activo->getIdGrupoActivo()->getDescripcion(),
                        'cuenta_subcuenta'=>$obj_cuenta->getIdCuentaActivo()->getNroCuenta().'/'.$obj_cuenta->getIdSubcuentaActivo()->getNroSubcuenta()
                    );
                }

            }
            /** @var  AreaResponsabilidad $area_responsabilidad */
            $area_responsabilidad = $em->getRepository(AreaResponsabilidad::class)->find($ar);
            $rows[] = array(
                'area_responsabilidad'=>$area_responsabilidad->getCodigo().' - '.$area_responsabilidad->getNombre(),
                'datos'=>$row
            );
        }
        return $rows;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @Route("/print_registro", name="contabilidad_activo_fijo_registro_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $id_user = $this->getUser()->getId();
        /** @var Unidad $unidad */
        $unidad = AuxFunctions::getUnidad($em,$id_user);
        $codigo = $unidad->getCodigo();
        $nombre = $unidad->getNombre();
        return $this->render('contabilidad/activo_fijo/registro_activo_fijo/print.html.twig', [
            'datos' => $this->getData($em, $request),
            'unidad_nombre' => $nombre,
            'unidad_codigo' => $codigo
        ]);
    }
}
