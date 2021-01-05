<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Agencias; 
use App\Entity\User; 
use Symfony\Component\HttpFoundation\Response;

class AdmController extends AbstractController
{

// 2. Expose the EntityManager in the class level
private $entityManager;

public function __construct(EntityManagerInterface $entityManager)
{
    // 3. Update the value of the private entityManager variable through injection
    $this->entityManager = $entityManager;
}

    /**
     * @Route("/user", name="user")
     */
    public function user(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $dql = "SELECT a FROM App:User a  ";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );
        //return new Response(var_dump($pagination));

        return $this->render('adm/user.html.twig',
        ['pagination' => $pagination]);
    }

     /**
     * @Route("/agencias", name="agencias")
     */
    public function agencias()
    {

       
    }

     /**
     * @Route("/agencias/reporte", name="agencias/reporte")
     */
    public function agenciasReporte(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dql = "SELECT a FROM App:Agencias a  ";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );
        //return new Response(var_dump($pagination));

        return $this->render(
            'adm/agenciaReporte.html.twig',
            ['pagination' => $pagination]
        );
       
    }

      /**
     * @Route("/agencias/add/{nombre}", name="agencias/add/")
     */
    public function add($nombre)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $agencia = new Agencias; 
        $agencia->setNombre($nombre);

        $dataBase->persist($agencia);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Agencia Agregada'
        );

        return $this->redirectToRoute('agencias/reporte'); 
       
    } 

        /**
     * @Route("/agencias/edit/{id}/{nombre}", name="agencias/edit/")
     */
    public function edit($id,$nombre)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $agencia = $dataBase->getRepository(Agencias::class)->find($id);
        $agencia->setNombre($nombre);

        $dataBase->flush($agencia);

        $this->addFlash(
            'success',
            'Agencia Editada'
        );

        return $this->redirectToRoute('agencias/reporte'); 
       
    } 

        /**
     * @Route("/agencias/borrar/{id}", name="agencias/borrar/")
     */
    public function borrar($id)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $agencia = $dataBase->getRepository(Agencias::class)->find($id);
        
        $dataBase->remove($agencia);
        $dataBase->flush();

        $this->addFlash(
            'success',
            'Agencia Borrada'
        );

        return $this->redirectToRoute('agencias/reporte'); 
       
    } 

        /**
     * @Route("/agencias/detalle/{id}", name="agencias/detalle/")
     */
    public function detalle($id,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {

        $dataBase = $this->getDoctrine()->getManager();

       
        $user = $dataBase->getRepository(User::class)->findAll();
        $agencia = $dataBase->getRepository(Agencias::class)->find($id);

        $dql = "SELECT a FROM App:User a  WHERE a.idAgencia ='$id'";

        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );
        //return new Response(var_dump($pagination[0]));

        return $this->render(
            'adm/agenciaReporteDetalle.html.twig',
            ['pagination' => $pagination , 'users' => $user ,'agencia' => $agencia]
        );
       
       
    } 

        /**
     * @Route("/agencias/user/add/{idAgencia}/{idUser}", name="agencias/user/add")
     */
    public function userAdd($idAgencia,$idUser)
    {

        $dataBase = $this->getDoctrine()->getManager();
        $user = $dataBase->getRepository(User::class)->find($idUser);
        $user->setIdAgencia($idAgencia);
        $dataBase->flush($user);

        $this->addFlash(
            'success',
            'Usuario Agregado'
        );

        return $this->redirectToRoute('agencias/detalle/', ["id" => $idAgencia]); 
       
    } 
}
