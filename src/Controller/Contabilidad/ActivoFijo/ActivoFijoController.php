<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\Inventario\Documento;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ActivoFijoController
 * CRUD DE ACTIVO FIJO
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo")
 */
class ActivoFijoController extends AbstractController
{
    /**
     * @Route("/registrar", name="contabilidad_activo_fijo_registrar", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $id_usuario = $this->getUser()->getId();

        $unidad = AuxFunctions::getUnidad($em,$id_usuario);

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad'=>$unidad->getId(),
            'activo'=>true
        ));
        $rows = [];
        if(!empty($arr_activos_fijos)){
            /** @var ActivoFijo $obj */
            foreach ($arr_activos_fijos as $obj){
                $rows[] = array(
                    'nro_inv'=>$obj->getNroInventario(),
                    'descripcion'=>$obj->getDescripcion(),
                    'importe'=>$obj->getImporte(),
                    'fecha'=>$obj->getFecha()->format('d/m/Y'),
                    'grupo_activos'=>$obj->getIdGrupoActivo()->getDescripcion(),
                    'proveedor'=>$obj->getIdProveedor()->getNombre(),
                    'id'=>$obj->getId()
                 );
            }
        }
        return $this->render('contabilidad/activo_fijo/activo_fijo/index.html.twig', [
            'controller_name' => 'ActivoFijoController',
            'activos_fijos'=>$rows
        ]);
    }

    /**
     * @Route("/depreciar", name="contabilidad_activo_fijo_depreciar", methods={"GET"})
     */
    public function depreciar()
    {
        $em = $this->getDoctrine()->getManager();
        $id_usuario = $this->getUser()->getId();
        $depreciacion_er = $em->getRepository(Depreciacion::class);
        $unidad = AuxFunctions::getUnidad($em,$id_usuario);

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad'=>$unidad->getId(),
            'activo'=>true
        ));
        $rows = [];

        $today = Date('Y-m-d');
        $year_ = date('Y');
        $month_ = date('m');
        $deprecio = false;
        if(!empty($arr_activos_fijos)){
            /** @var ActivoFijo $obj */
            foreach ($arr_activos_fijos as $obj){
                $depreciacion_obj = $depreciacion_er->findOneBy(array(
                    'mes'=>$month_,
                    'anno'=>$year_,
                    'id_activo_fijo'=>$obj->getId()
                ));

                if($depreciacion_obj){
                    $this->addFlash('error','Ya se realizó la depreciación de los activos fijos de su unidad para este mes.');
                    break;
                }
                else{

                    $porciento_deprecia = $obj->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                    if($porciento_deprecia){
                        $importe = $obj->getImporte() * floatval($porciento_deprecia);
                        $deprecio = true;
                        $nueva_depreciacion = new Depreciacion();
                        $nueva_depreciacion
                            ->setAnno($year_)
                            ->setMes($month_)
                            ->setFecha(\DateTime::createFromFormat('Y-m-d', $today))
                            ->setIdActivoFijo($obj)
                            ->setImporteDepreciacion($importe);
                        $em->persist($nueva_depreciacion);
                    }
                }
            }
            if($deprecio){
                try {
                    $em->flush();
                    $this->addFlash('success','Drepreciación realizada con éxito.');
                }
                catch (FileException $e) {
                    return $e->getMessage();
                }
            }
        }
        return $this->redirectToRoute('contabilidad_activo_fijo_registrar');
    }
}
