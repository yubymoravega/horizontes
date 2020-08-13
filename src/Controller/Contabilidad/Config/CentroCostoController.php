<?php

namespace App\Controller\Contabilidad\Config;

use App\Entity\Contabilidad\Config\CentroCosto;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Form\Contabilidad\Config\CentroCostoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\CoreContabilidad\AuxFunctions;

class CentroCostoController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/centro-costo", name="contabilidad_config_centro_costo")
     */
    public function index(EntityManagerInterface $em)
    {
        $form = $this->createForm(CentroCostoType::class);

        $repository_arr = $em->getRepository(CentroCosto::class)->findByActivo(true);
        $row = [];
        foreach ($repository_arr as $item) {
            /**@var $item CentroCosto** */

            $row [] = array(
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'codigo' => $item->getCodigo(),
                'id_cuenta' => $item->getIdCuenta() ? $item->getIdCuenta()->getId() : '',
                'id_sub_cuenta' => $item->getIdSubcuenta() ? $item->getIdSubcuenta()->getId() : '',
                'cuenta' => $item->getIdCuenta()->getDescripcion(),
                'sub_cuenta' => $item->getIdSubcuenta()->getDescripcion()
            );
        }
        return $this->render('contabilidad/config/centro_costo/index.html.twig', [
            'controller_name' => '| Centro de Costo',
            'centro_costo' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/centro-costo-add", name="contabilidad_config_centro_costo_add")
     */
    public function addElementoGasto(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $arr_request = $request->get('centro_costo');
        dd($request);
        if (!AuxFunctions::isDuplicate(
            $em->getRepository(CentroCosto::class),
            array('nombre' => $arr_request['nombre']),
            'add')) {
            $obj = new CentroCosto();
            $obj->setNombre($arr_request['nombre']);
            $obj->setCodigo($arr_request['codigo']);
            $obj->setActivo(true);
            $id_cuenta = $arr_request['id_cuenta'];
            $obj->setIdCuenta($em->getRepository(Cuenta::class)->find($id_cuenta));
            $id_sub_cuenta = $arr_request['id_sub_cuenta'];
            $obj->setIdSubcuenta($em->getRepository(Subcuenta::class)->find($id_sub_cuenta));

            try {
                $em->persist($obj);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Centro de Costo adicionado satisfactoriamente");
        } else
            $this->addFlash('error', "Centro de Costo ya se encuentra registrado");
        return $this->redirectToRoute('contabilidad_config_centro_costo');
    }
}
