<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\MonedaPais;
use App\Entity\Pais;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MonedasPaisController
 * @package App\Controller\RemesasModule\Configuracion
 * @Route("/configuracion-turismo/remesas/monedas-pais")
 */
class MonedasPaisController extends AbstractController
{
    /**
     * @Route("/", name="remesas_module_configuracion_monedas_pais")
     */
    public function index(EntityManagerInterface $em)
    {
        $row = [];
        $paises = $em->getRepository(Pais::class)->findBy(['activo'=>true]);
        $monedas_er = $em->getRepository(MonedaPais::class);
        $moneda_er = $em->getRepository(Moneda::class);
        foreach ($paises as $item){
            $data_moneda = [];
            $monedas_pais = $monedas_er->findBy(['idPais'=>$item->getId()]);
            foreach ($monedas_pais as $elemt){
                $nombre_moneda = $moneda_er->find($elemt->getIdMoneda())->getNombre();
                $data_moneda[]=[
                  'nombre' => $nombre_moneda
                ];
            }
            $row[]=[
                'nombre'=>$item->getNombre(),
                'id'=>$item->getId(),
                'monedas'=>$data_moneda
            ];
        }
//        dd($row);
        return $this->render('remesas_module/configuracion/monedas_pais/index.html.twig', [
            'controller_name' => 'MonedasPaisController',
            'paises'=>$row
        ]);
    }
}
