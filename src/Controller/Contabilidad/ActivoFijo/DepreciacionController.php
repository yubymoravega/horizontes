<?php

namespace App\Controller\Contabilidad\ActivoFijo;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijo;
use App\Entity\Contabilidad\ActivoFijo\ActivoFijoCuentas;
use App\Entity\Contabilidad\ActivoFijo\Depreciacion;
use App\Entity\Contabilidad\Config\AreaResponsabilidad;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DepreciacionController
 * @package App\Controller\Contabilidad\ActivoFijo
 * @Route("/contabilidad/activo-fijo-depreciacion")
 */
class DepreciacionController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_activo_fijo_depreciacion")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        return $this->render('contabilidad/activo_fijo/depreciacion/index.html.twig', [
            'controller_name' => 'RegistroActivoFijoController',
            'datos' => $this->getData($em, $request)
        ]);
    }

    public function getData(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em, $this->getUser());
        $arr_activos = $em->getRepository(ActivoFijo::class)->findBy([
            'activo' => true,
            'id_unidad' => $unidad
        ]);
        $cuentas_activo = $em->getRepository(ActivoFijoCuentas::class);
        $arr_area_responsabilidad = [];
        /** @var ActivoFijo $activo */
        foreach ($arr_activos as $activo) {
            /** @var ActivoFijoCuentas $cuenta */
            $cuenta = $cuentas_activo->findOneBy(['id_activo'=>$activo->getId()]);
            $str = $cuenta->getIdCuentaActivo()->getNroCuenta().'/'.$cuenta->getIdSubcuentaActivo()->getNroSubcuenta();
            if (!in_array($str, $arr_area_responsabilidad)) {
                $arr_area_responsabilidad[count($arr_area_responsabilidad)] = $str;
            }
        }
        $rows = [];
        foreach ($arr_area_responsabilidad as $ar) {
            $row = [];
            /** @var ActivoFijo $activo */
            foreach ($arr_activos as $activo) {
                /** @var ActivoFijoCuentas $cuenta */
                $cuenta = $cuentas_activo->findOneBy(['id_activo'=>$activo->getId()]);
                $str = $cuenta->getIdCuentaActivo()->getNroCuenta().'/'.$cuenta->getIdSubcuentaActivo()->getNroSubcuenta();

                if ($str == $ar) {
                    $depreciacion_x_grupo = $activo->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                    $valor_a_depreciar = floatval($depreciacion_x_grupo) * floatval($activo->getValorInicial()) / 100;
                    $row[] = array(
                        'id' => $activo->getId(),
                        'nro_inventario' => $activo->getNroInventario(),
                        'descripcion' => $activo->getDescripcion(),
                        'depreciacion_mes' => $activo->getValorReal()>0? number_format($valor_a_depreciar,2):'',
                        'depreciacion_acumulada' => number_format($activo->getDepreciacionAcumulada(),2),
                        'valor_real' => number_format($activo->getValorInicial()-$activo->getDepreciacionAcumulada(),2),
                        'valor_inicial' => number_format($activo->getValorInicial(),2),
                        'tasa_depreciacion' => number_format($depreciacion_x_grupo,2),
                    );
                }
            }
            /** @var  AreaResponsabilidad $area_responsabilidad */
            $rows[] = array(
                'area_responsabilidad' => $ar,
                'datos' => $row
            );
        }
        return $rows;
    }

    /**
     * @Route("/depreciar", name="contabilidad_activo_fijo_depreciar", methods={"GET"})
     */
    public function depreciar()
    {
        $em = $this->getDoctrine()->getManager();
        $id_usuario = $this->getUser()->getId();
        $depreciacion_er = $em->getRepository(Depreciacion::class);
        $unidad = AuxFunctions::getUnidad($em, $id_usuario);

        $arr_activos_fijos = $em->getRepository(ActivoFijo::class)->findBy(array(
            'id_unidad' => $unidad->getId(),
            'activo' => true
        ));
        $rows = [];

        $today = Date('Y-m-d');
        $year_ = date('Y');
        $month_ = date('m');
        $deprecio = false;
        if (!empty($arr_activos_fijos)) {
            /** @var ActivoFijo $obj */
            foreach ($arr_activos_fijos as $obj) {
                $depreciacion_obj = $depreciacion_er->findOneBy(array(
                    'mes' => $month_,
                    'anno' => $year_,
                    'id_activo_fijo' => $obj->getId()
                ));

                if ($depreciacion_obj) {
                    $this->addFlash('error', 'Ya se realizó la depreciación de los activos fijos de su unidad para este mes.');
                    break;
                } else {

                    $porciento_deprecia = $obj->getIdGrupoActivo()->getPorcientoDepreciaAnno();
                    if ($porciento_deprecia) {
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
            if ($deprecio) {
                try {
                    $em->flush();
                    $this->addFlash('success', 'Drepreciación realizada con éxito.');
                } catch (FileException $e) {
                    return $e->getMessage();
                }
            }
        }
        return $this->redirectToRoute('contabilidad_activo_fijo_registrar');
    }

}
