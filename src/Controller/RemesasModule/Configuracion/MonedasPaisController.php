<?php

namespace App\Controller\RemesasModule\Configuracion;

use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\MonedaPais;
use App\Entity\Pais;
use App\Form\RemesasModule\Configuracion\MonedasPaisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonDecode;

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
        $form = $this->createForm(MonedasPaisType::class);
        $row = [];
        $paises = $em->getRepository(Pais::class)->findBy(['activo' => true]);
        $monedas_er = $em->getRepository(MonedaPais::class);
        $moneda_er = $em->getRepository(Moneda::class);
        foreach ($paises as $item) {
            $data_moneda = [];
            $monedas_pais = $monedas_er->findBy(['idPais' => $item->getId(), 'status' => 1]);
            foreach ($monedas_pais as $elemt) {
                $nombre_moneda = $moneda_er->find($elemt->getIdMoneda())->getNombre();
                $data_moneda[] = [
                    'nombre' => $nombre_moneda
                ];
            }
            $row[] = [
                'nombre' => $item->getNombre(),
                'id' => $item->getId(),
                'monedas' => $data_moneda
            ];
        }
        return $this->render('remesas_module/configuracion/monedas_pais/index.html.twig', [
            'controller_name' => 'MonedasPaisController',
            'paises' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/getMonedas/{id}", name="remesas_module_configuracion_monedas_pais_getmonedas")
     */
    public function getMonedas(EntityManagerInterface $em, Request $request, $id)
    {
        $monedas = $em->getRepository(MonedaPais::class)->findBy(['idPais' => $id, 'status' => 1]);
        $rows = [];
        $moneda_er = $em->getRepository(Moneda::class);
        foreach ($monedas as $item) {
            $rows[] = [
                'moneda' => $item->getIdMoneda(),
                'nombre_moneda' => $moneda_er->find($item->getIdMoneda())->getNombre(),
                'id_moneda_pais' => $item->getId()
            ];
        }
        return new JsonResponse(['success' => true, 'data' => $rows]);
    }

    /**
     * @Route("/updateMonedasPais", name="remesas_module_configuracion_monedas_pais_UpdateMonedasPais")
     */
    public function UpdateMonedasPais(EntityManagerInterface $em, Request $request)
    {
        $id_pais = intval($request->request->get('id_pais'));
        $lista = json_decode($request->request->get('lista'));
        $monedas_paises_er = $em->getRepository(MonedaPais::class);
        $monedas_paises = $monedas_paises_er->findBy(['idPais' => $id_pais, 'status' => 1]);

        foreach ($monedas_paises as $item) {
            $item->setStatus(0);
            $em->persist($item);
        }
        $em->flush();

        foreach ($lista as $list) {
            $id_moneda = intval($list->moneda);
            $monedas_paises_obj = $monedas_paises_er->findOneBy(['idPais' => $id_pais, 'idMoneda' => $id_moneda]);
            if ($monedas_paises_obj) {
                $monedas_paises_obj->setStatus(1);
            } else {
                $monedas_paises_obj = new MonedaPais();
                $monedas_paises_obj
                    ->setStatus(1)
                    ->setIdMoneda($id_moneda)
                    ->setIdPais($id_pais);
            }
            $em->persist($monedas_paises_obj);
        }
        $em->flush();
        $this->addFlash('success', 'Datos actualizados satisfactoriamente');
        return $this->redirectToRoute('remesas_module_configuracion_monedas_pais');
    }
}
