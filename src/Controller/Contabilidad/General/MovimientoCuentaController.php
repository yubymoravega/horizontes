<?php

namespace App\Controller\Contabilidad\General;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Almacen;
use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\ElementoGasto;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\User;
use App\Form\Contabilidad\General\MovimientoCuentaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovimientoCuentaController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/movimiento-cuenta")
 */
class MovimientoCuentaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_movimiento_cuenta", methods={"POST","GET"})
     */
    public function index()
    {
        $form = $this->createForm(MovimientoCuentaType::class);
        return $this->render('contabilidad/general/movimiento_cuenta/index.html.twig', [
            'controller_name' => 'MovimientoCuentaController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/getDatos", name="contabilidad_general_movimiento_cuenta_get_dato", methods={"POST"})
     */
    public function getDatos()
    {
        $em = $this->getDoctrine()->getManager();
        $row_inventario = AuxFunctions::getCuentasByCriterio($em, ['ALM','EXP','CCT','EG']);

        //elemento de gasto
        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo().' - '.$item->getDescripcion()
                );
            }
        }
        //centro de costo
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario'=>$this->getUser()
        ));

        $centro_costo_arr = $em->getRepository(CentroCosto::class)->findBy(array(
            'activo'=>true,
            'id_unidad'=>$empleado->getIdUnidad()
        ));

        $centros_costo = [];
        if(!empty($centro_costo_arr)){
            /** @var CentroCosto $centroCosto */
            foreach ($centro_costo_arr as $centroCosto){
                $centros_costo[] = array(
                    'id'=>$centroCosto->getId(),
                    'nombre'=>$centroCosto->getCodigo().' - '. $centroCosto->getNombre()
                );
            }
        }

        $almacen_arr = $em->getRepository(Almacen::class)->findBy(array(
            'id_unidad'=>$empleado->getIdUnidad(),
            'activo'=>true
        ));
        $almacenes = [];
        if (!empty($almacen_arr)){
            /** @var Almacen $almacen */
            foreach ($almacen_arr as $almacen){
                $almacenes[] = array(
                    'id'=>$almacen->getId(),
                    'nombre'=>$almacen->getCodigo().' - '. $almacen->getDescripcion()
                );
            }
        }

        $elemento_gasto = $em->getRepository(ElementoGasto::class)->findAll();
        $rows = [];
        if (!empty($elemento_gasto)) {
            foreach ($elemento_gasto as $item) {
                /**@var $item ElementoGasto */
                $rows [] = array(
                    'id' => $item->getId(),
                    'nombre' => $item->getCodigo().' - '.$item->getDescripcion()
                );
            }
        }
        return new JsonResponse([
            'cuentas_inventario' => $row_inventario,
            'elemento_gasto' => $rows,
            'centro_costo'=>$centros_costo,
            'almacenes'=>$almacenes,
            'success' => true
        ]);

    }
}