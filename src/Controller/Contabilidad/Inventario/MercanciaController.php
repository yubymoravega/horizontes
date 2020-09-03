<?php

namespace App\Controller\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Mercancia;
use Doctrine\ORM\Query\Expr\Math;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class MercanciaController
 * @package App\Controller\Contabilidad\Inventario
 * @Route("/contabilidad/inventario/mercancia")
 */
class MercanciaController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_inventario_mercancia",methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $mercancia_arr = $em->getRepository(Mercancia::class)->findBy(array(
            'activo'=>true,
            'id_amlacen'=>1
        ));
        $row = [];
        foreach ($mercancia_arr as $mercancia_obj){
            /**@var $mercancia_obj Mercancia **/
            $row[] = array(
                'codigo'=>$mercancia_obj->getCodigo(),
                'descripcion'=>$mercancia_obj->getDescripcion(),
                'unidad_medida'=>$mercancia_obj->getIdUnidadMedida()->getNombre(),
                'existencia'=>$mercancia_obj->getExistencia(),
                'precio'=> number_format(($mercancia_obj->getImporte()/$mercancia_obj->getExistencia()),3,'.',''),
                'importe'=> $mercancia_obj->getImporte(),

            );
        }
        return $this->render('contabilidad/inventario/mercancia/index.html.twig', [
            'controller_name' => 'MercanciaController',
            'mercancias'=>$row
        ]);
    }
}
