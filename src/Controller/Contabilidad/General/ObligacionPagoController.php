<?php

namespace App\Controller\Contabilidad\General;

use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\General\ObligacionPago;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ObligacionPagoController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/obligacion-pago")
 */
class ObligacionPagoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_obligacion_pago", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $id_user = $this->getUser()->getId();
        $obligacion_er = $em->getRepository(ObligacionPago::class);
        $obj_empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'activo' => true,
            'id_usuario' => $id_user
        ));
        $row = array();
        if ($obj_empleado) {
            $id_unidad = $obj_empleado->getIdUnidad()->getId();
            $obligacion_arr = $obligacion_er->findBy(array(
                'liquidado'=>false,
                'id_unidad'=>$id_unidad,
                'activo'=>true
            ));
            if(!empty($obligacion_arr)){
                foreach ($obligacion_arr as $obj_obligacion){
                    /**@var $obj_obligacion ObligacionPago**/
                    $row [] = array(
                        'codigo'=>$obj_obligacion->getCodigoFactura(),
                        'fecha'=>$obj_obligacion->getFechaFactura()->format('d-m-Y'),
                        'resto'=> number_format(floatval($obj_obligacion->getResto()),2,'.',''),
                        'proveedor'=>$obj_obligacion->getIdProveedor()->getNombre(),
                        'id_proveedor'=>$obj_obligacion->getIdProveedor()->getId(),
                        'descripcion'=>$obj_obligacion->getIdDocumento()->getDescripcionMercancia(),
                        'id'=>$obj_obligacion->getId()
                    );
                }
            }
        }
        return $this->render('contabilidad/general/obligacion_pago/index.html.twig', [
            'controller_name' => 'ObligacionPagoController',
            'obligaciones'=>$row
        ]);
    }
}
