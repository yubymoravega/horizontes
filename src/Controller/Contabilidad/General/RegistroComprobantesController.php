<?php

namespace App\Controller\Contabilidad\General;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\Contabilidad\Contabilidad\RegistroComprobantes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistroComprobantesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/registro-comprobantes")
 */
class RegistroComprobantesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_registro_comprobantes")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {

        return $this->render('contabilidad/general/registro_comprobantes/index.html.twig', [
            'controller_name' => 'RegistroComprobantesController',
            'registro' => $this->getData($em, $request)
        ]);
    }

    public function getData(EntityManagerInterface $em, Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario' => $user
        ));
        $row = [];
        if ($empleado) {
            /** @var Unidad $obj_unidad */
            $obj_unidad = $empleado->getIdUnidad();
            $comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                'anno' => Date('Y'),
                'id_unidad' => $obj_unidad
            ));
            /** @var RegistroComprobantes $comp */
            foreach ($comprobantes as $comp) {
                $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'activo' => true,
                    'id_usuario' => $comp->getIdUsuario()->getId()
                ));
                $row[] = array(
                    'id' => $comp->getId(),
                    'nro' => $comp->getNroConsecutivo(),
                    'tipo_comprobante' => $comp->getIdTipoComprobante()->getDescripcion(),
                    'abreviatura_comprobante' => $comp->getIdTipoComprobante()->getAbreviatura(),
                    'descripcion' => $comp->getDescripcion(),
                    'fecha' => $comp->getFecha()->format('d-m-Y'),
                    'usuario' => $obj_empleado->getNombre(),
                    'almacen' => $comp->getIdAlmacen()->getCodigo() . '-' . $comp->getIdAlmacen()->getDescripcion()
                );
            }
        }
        return $row;
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param $id
     * @Route("/print_registro", name="contabilidad_general_registro_comprobantes_print")
     */
    public function print(EntityManagerInterface $em, Request $request)
    {
        $id_user = $this->getUser()->getId();
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_user
        ));
        $codigo = $obj_empleado->getIdUnidad()->getCodigo();
        $nombre = $obj_empleado->getIdUnidad()->getNombre();
        return $this->render('contabilidad/general/registro_comprobantes/print.html.twig', [
            'datos' => $this->getData($em, $request),
            'unidad_nombre'=>$nombre,
            'unidad_codigo'=>$codigo
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Request $request
     * @Route("/detalles/{$id}", name="contabilidad_general_registro_comprobantes_detalles")
     */
    public function getDetalles(EntityManagerInterface $em, Request $request,$id){
        dd($id);
    }
}
