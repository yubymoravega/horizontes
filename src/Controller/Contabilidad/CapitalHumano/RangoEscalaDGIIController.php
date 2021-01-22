<?php

namespace App\Controller\Contabilidad\CapitalHumano;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\RangoEscalaDGII;
use App\Form\Contabilidad\CapitalHumano\RangoEscalaDGIIType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RangoEscalaDGIIController
 * @package App\Controller\Contabilidad\CapitalHumano
 * @Route("/contabilidad/capital-humano/rango-escala-dgii")
 */
class RangoEscalaDGIIController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_capital_humano_rango_escala_d_g_i_i")
     */
    public function index(EntityManagerInterface $em,Request $request)
    {
        $rangos = $em->getRepository(RangoEscalaDGII::class)->findBy(['activo'=>true,'anno'=>AuxFunctions::getCurrentYear($em,AuxFunctions::getUnidad($em,$this->getUser()))]);
        $form = $this->createForm(RangoEscalaDGIIType::class);
        $rows = [];
        /** @var RangoEscalaDGII $item */
        foreach ($rangos as $item){
            $rows[]=[
                'id'=>$item->getId(),
                'anno'=>$item->getAnno(),
                'escala'=>$item->getEscala(),
                'maximo'=>number_format($item->getMaximo(),2),
                'minimo'=>number_format($item->getMinimo(),2),
                'valor_fijo'=>number_format($item->getValorFijo(),2),
                'maximo_value'=>$item->getMaximo(),
                'minimo_value'=>$item->getMinimo(),
                'valor_fijo_value'=>$item->getValorFijo(),
                'por_ciento'=>$item->getPorCiento()
            ];
        }
        return $this->render('contabilidad/capital_humano/rango_escala_dgii/index.html.twig', [
            'controller_name' => 'RangoEscalaDGIIController',
            'form' => $form->createView(),
            'rangos'=>$rows
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_capital_humano_rango_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(RangoEscalaDGIIType::class);
        $form->handleRequest($request);

        /** @var RangoEscalaDGII $rango */
        $rango = $form->getData();
        $errors = $validator->validate($rango);

        if ($form->isValid() && $form->isSubmitted()) {
            $rango->setActivo(true);
            try {
                $em->persist($rango);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Rango de Escala adicionado satisfactoriamente");
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_capital_humano_rango_escala_d_g_i_i');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_capital_humano_rango_update", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, RangoEscalaDGII $rango)
    {
        $form = $this->createForm(RangoEscalaDGIIType::class, $rango);
        $form->handleRequest($request);
        $errors = $validator->validate($rango);

        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($rango);
                $em->flush();
                $this->addFlash('success', "Rango de Escala actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_capital_humano_rango_escala_d_g_i_i');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_capital_humano_rango_delete", methods={"DELETE"})
     */
    public function delete(EntityManagerInterface $em, Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $elgasto_obj = $em->getRepository(RangoEscalaDGII::class)->find($id);
            $msg = 'No se pudo eliminar el Rango de Escala seleccionado';
            $success = 'error';
            if ($elgasto_obj) {
                /**@var $elgasto_obj RangoEscalaDGII** */
                $elgasto_obj->setActivo(false);
                try {
                    $em->persist($elgasto_obj);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Rango de Escala eliminado satisfactoriamente';
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('contabilidad_capital_humano_rango_escala_d_g_i_i');
    }
}
