<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\AgenciasTv;
use App\Entity\Contabilidad\Config\Unidad;

class PublicidadController extends AbstractController
{

     // 2. Expose the EntityManager in the class level
     private $entityManager; 

     public function __construct(EntityManagerInterface $entityManager)
     {
         // 3. Update the value of the private entityManager variable through injection
         $this->entityManager = $entityManager;
     }
 

    /**
     * @Route("/publicidad", name="publicidad")
     */
    public function index()
    {
        return $this->render('publicidad/index.html.twig', [
            'controller_name' => 'PublicidadController',
        ]);
    }

    /**
     * @Route("/publicidad/save", name="publicidad/save")
     */
    public function save(Request $request)
    {

        if($request->files->get('1')){
        $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
        $archivo = $request->files->get('1');
        $archivo->move($destino,'1.jpg');
        }

        if($request->files->get('2')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('2');
            $archivo->move($destino,'2.jpg');
        }

        if($request->files->get('3')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('3');
            $archivo->move($destino,'3.jpg');
        }
        
        if($request->files->get('4')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('4');
            $archivo->move($destino,'4.jpg');
        }

        if($request->files->get('5')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('5');
            $archivo->move($destino,'5.jpg');
        }

        if($request->files->get('6')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('6');
            $archivo->move($destino,'6.jpg');
        }

        if($request->files->get('7')){
            $destino= $this->getParameter('kernel.project_dir')."/public/images/imgHome/";
            $archivo = $request->files->get('7');
            $archivo->move($destino,'7.jpg');
        }

        $this->addFlash(
            'success',
            'Imagen Guardada'
        );

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/publicidad/unidad", name="publicidad/unidad")
     */
    public function unidad(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dql = "SELECT a FROM App:Contabilidad\Config\Unidad a WHERE a.activo = '1'";

        $dataBase = $this->getDoctrine()->getManager();
        $tv = $dataBase->getRepository(AgenciasTv::class)->findAll();

        $dql .= " ORDER BY a.nombre DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        return $this->render('publicidad/publicidadUnidad.html.twig',[
            'pagination' => $pagination, 'tvs' => $tv
        ]);
    }


    /**
     * @Route("/publicidad/img/agencias", name="publicidad/img/agencias")
     */
    public function imgAgencias()
    {
        $dataBase = $this->getDoctrine()->getManager();
        $unidad = $dataBase->getRepository(Unidad::class)->findAll();
    

        return $this->render('publicidad/imgUnidad.html.twig', [
            'unidades' => $unidad
        ] );
    }

}
