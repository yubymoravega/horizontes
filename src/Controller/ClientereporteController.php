<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\ClienteReporte;
use App\Entity\User;
use App\Entity\Cliente;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collection\ArrayCollection;
use Doctrine\ORM\QueryBuild;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;



class ClientereporteController extends AbstractController
{
    // 2. Expose the EntityManager in the class level
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // 3. Update the value of the private entityManager variable through injection
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/paymentreport", name="paymentreport")
     */
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {


        $dql = "SELECT a FROM App:ClienteReporte a ";


        if ($request->get('to') && $request->get('from')) {

            $to = str_replace('/', "-", $request->get('to'));
            $to = $to[6] . $to[7] . $to[8] . $to[9] . '-' . $to[0] . $to[1] . '-' . $to[3] . $to[4];

            $from = str_replace('/', "-", $request->get('from'));
            $from = $from[6] . $from[7] . $from[8] . $from[9] . '-' . $from[0] . $from[1] . '-' . $from[3] . $from[4];

            $dql .= "WHERE a.fecha BETWEEN '$from' AND '$to'";

            if ($request->get('estado')) {

                if ($request->get('estado') == 'succeeded') {
                    $dql .= " AND  a.estado = 'succeeded'";
                } else {
                    $dql .= " AND  a.estado != 'succeeded'";
                }
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.user = '" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('estado')) {

            if ($request->get('estado') == 'succeeded') {
                $dql .= " WHERE  a.estado = 'succeeded'";
            } else {
                $dql .= " WHERE  a.estado != 'succeeded'";
            }

            if ($request->get('empleado')) {

                $dql .= " AND  a.user  ='" . $request->get('empleado') . "'";
            }

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } elseif ($request->get('empleado')) {

            $dql .= " WHERE  a.user = '" . $request->get('empleado') . "'";

            if ($request->get('telefono')) {

                $dql .= " AND  a.idCliente  ='" . $request->get('telefono') . "'";
            }
        } else {

            if ($request->get('telefono')) {

                $dql .= " WHERE  a.idCliente ='" . $request->get('telefono') . "'";
            }
        }

        $dql .= " ORDER BY a.fecha DESC";
        $query = $em->createQuery($dql);

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render(
            'clientereporte/index.html.twig',
            ['pagination' => $pagination, 'user' => $user]
        );
    }
}
