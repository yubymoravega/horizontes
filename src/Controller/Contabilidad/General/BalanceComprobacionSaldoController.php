<?php

namespace App\Controller\Contabilidad\General;

use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BalanceComprobacionSaldoController
 * @package App\Controller\Contabilidad\General
 * @Route("/contabilidad/general/balance-comprobacion-saldo")
 */
class BalanceComprobacionSaldoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_general_balance_comprobacion_saldo")
     */
    public function index(EntityManagerInterface $em,Request $request, PaginatorInterface $pagination)
    {
        $arr_cuentas = $em->getRepository(Cuenta::class)->findAll();
        $row = [];
        /** @var Cuenta $cuenta */
        foreach ($arr_cuentas as $cuenta){
            $arr_subcuentas = $em->getRepository(Subcuenta::class)->findBy([
                'activo'=>true,
                'id_cuenta'=>$cuenta
            ]);
            $row[] = array(
                'cuenta'=>$cuenta->getNroCuenta(),
                'descripcion'=>$cuenta->getNombre(),
                'id_cuenta'=>$cuenta->getId(),
                'subcuenta'=>'',
                'id_subcuenta'=>''
            );
            if(!empty($arr_subcuentas)){
                /** @var Subcuenta $subcuenta */
                foreach ($arr_subcuentas as $subcuenta){
                    $row[] = array(
                        'cuenta'=>'',
                        'descripcion'=>$subcuenta->getDescripcion(),
                        'id_cuenta'=>$cuenta->getId(),
                        'subcuenta'=>$subcuenta->getNroSubcuenta(),
                        'id_subcuenta'=>$subcuenta->getId()
                    );
                }
            }
        }
        $paginator = $pagination->paginate(
            $row,
            $request->query->getInt('page', $request->get("page") || 1), /*page number*/
            30, /*limit per page*/
            ['align' => 'center', 'style' => 'bottom',]
        );
        return $this->render('contabilidad/general/balance_comprobacion_saldo/index.html.twig', [
            'controller_name' => 'BalanceComprobacionSaldoController',
            'cuentas'=>$paginator
        ]);
    }
}
