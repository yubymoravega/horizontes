<?php

namespace App\Controller\Contabilidad;

use App\CoreContabilidad\AuxFunctions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;

class ReportesController extends AbstractController
{
    /**
     * @Route("/contabilidad/reportes", name="contabilidad_reportes")
     */
    public function index(EntityManagerInterface $em)
    {
//        $this->limpiarVariables();
        return $this->render('contabilidad/reportes/index.html.twig', [
            'controller_name' => 'ReportesController',
        ]);
    }
//    /**
//     * @Route("/asignarVariables", name="contabilidad_reportes")
//     */
//    public function asignarVariables(Request $request, RequestEvent $event)
//    {
////        dd($request);
//        $id_unidad = $request->get('unidad');
//        $id_almacen = $request->get('almacen');
//
//        $event->getRequest()->getSession()->set('selected_unidad_filter/id', $id_unidad);
//        $event->getRequest()->getSession()->set('selected_almacen_filter/id', $id_almacen);
//    }
//
//    public function limpiarVariables(Request $request, RequestEvent $event)
//    {
//        $event->getRequest()->getSession()->set('selected_unidad_filter/id', null);
//        $event->getRequest()->getSession()->set('selected_almacen_filter/id', null);
//    }
}
