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
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class RegistroComprobantesController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/registro/comprobantes")
 */
class RegistroComprobantesController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_registro_comprobantes")
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Empleado $empleado */
        $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
            'id_usuario'=>$user
        ));
        $row = [];
        if($empleado){
            /** @var Unidad $obj_unidad */
            $obj_unidad = $empleado->getIdUnidad();
            $comprobantes = $em->getRepository(RegistroComprobantes::class)->findBy(array(
                'anno'=>Date('Y'),
                'id_unidad'=>$obj_unidad
            ));
            /** @var RegistroComprobantes $comp */
            foreach ($comprobantes as $comp){
                $row[] = array(
                    'id'=>$comp->getId(),
                    'nro'=>$comp->getNroConsecutivo().'/'.$comp->getAnno(),
                    'tipo_comprobante'=>$comp->getIdTipoComprobante()->getDescripcion(),
                    'descripcion'=>$comp->getDescripcion(),
                    'fecha'=>$comp->getFecha()->format('d-m-Y'),
                    'usuario'=>$comp->getIdUsuario()->getUsername(),
                    'almacen'=>$comp->getIdAlmacen()->getCodigo().'-'.$comp->getIdAlmacen()->getDescripcion()
                );
            }
        }
        return $this->render('contabilidad/general/registro_comprobantes/index.html.twig', [
            'controller_name' => 'RegistroComprobantesController',
            'registro'=>$row
        ]);
    }
}
