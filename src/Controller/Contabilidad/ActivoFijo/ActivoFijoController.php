<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\GrupoActivos;
use App\Entity\Contabilidad\Inventario\Documento;
use App\Form\Contabilidad\ActivoFijo\ActivoFijoType;
use App\Form\Contabilidad\Inventario\AjusteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/gestionar", name="contabilidad_activo_fijo_gestionar", methods={"GET","POST"})
     */
    public function gestionar(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ActivoFijoType::class);

        return $this->render('contabilidad/activo_fijo/activo_fijo/form.html.twig', [
            'controller_name' => 'CRUDActivoFijo',
            'formulario' => $form->createView()
        ]);
    }
    /**
     * @Route("/getData", name="contabilidad_activo_fijo_get_data", methods={"POST"})
     */
    public function getData(EntityManagerInterface $em, Request $request)
    {
        $cuenta_activo = AuxFunctions::getCuentasByTipo($em,[3]);
        $cuenta_depreciacion = AuxFunctions::getCuentasByTipo($em,[6]);
        $cuenta_gasto = AuxFunctions::getCuentasByTipo($em,[14]);
        $paises = AuxFunctions::getPaises();

        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $arr_centros_costo = $em->getRepository(CentroCosto::class)->findBy([
            'id_unidad'=>$unidad,
            'activo'=>true
        ]);
        $arr_area_repsonsabilidad = $em->getRepository(AreaResponsabilidad::class)->findBy([
            'id_unidad'=>$unidad,
            'activo'=>true
        ]);
        $arr_elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();

        $arr_grupo_activos = $em->getRepository(GrupoActivos::class)->findAll();

        $rows_cc = [];
        $rows_ar = [];
        $rows_eg = [];
        $rows_ga = [];

        /** @var CentroCosto $item */
        foreach ($arr_centros_costo as $item){
            $rows_cc[]=array(
                'id'=>$item->getId(),
                'nombre'=>$item->getCodigo().' - '. $item->getNombre()
            );
        }
        /** @var AreaResponsabilidad $item */
        foreach ($arr_area_repsonsabilidad as $item){
            $rows_ar[]=array(
                'id'=>$item->getId(),
                'nombre'=>$item->getCodigo().' - '. $item->getNombre()
            );
        }
        /** @var ElementoGasto $item */
        foreach ($arr_elemento_gasto as $item){
            $rows_eg[]=array(
                'id'=>$item->getId(),
                'nombre'=>$item->getCodigo().' - '. $item->getDescripcion()
            );
        }
        /** @var GrupoActivos $item */
        foreach ($arr_grupo_activos as $item){
            $rows_ga[]=array(
                'id'=>$item->getId(),
                'nombre'=>$item->getCodigo().' - '. $item->getDescripcion()
            );
        }
        return new JsonResponse(['success'=>true,'cuenta_activo'=>$cuenta_activo,'cuenta_depreciacion'=>$cuenta_depreciacion,
            'cuenta_gasto'=>$cuenta_gasto,'paises'=>$paises,'centro_costo'=>$rows_cc,'area_responsabilidad'=>$rows_ar,
            'elemento_gasto'=>$rows_eg,'grupo_activos'=>$rows_ga]);
    }



}
