<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\Cuenta;
use App\Entity\Contabilidad\Config\Moneda;
use App\Entity\Contabilidad\Config\Subcuenta;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Form\Contabilidad\Config\CuentaType;
use App\Form\Contabilidad\Config\TasaCambioType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TasaCambioController extends AbstractController
{
    /**
     * @Route("/contabilidad/config/tasa-cambio", name="contabilidad_config_tasa_cambio")
     */
    public function index(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TasaCambioType::class);

        $tasa_cambio_arr = $em->getRepository(TasaCambio::class)->findByActivo(true);
        $row = [];
        foreach ($tasa_cambio_arr as $item) {
            /**@var $item TasaCambio** */
            $row [] = array(
                'id' => $item->getId(),
                'anno' => $item->getAnno(),
                'mes' => $item->getMes(),
                'nombre_mes' => AuxFunctions::getNombreMes($item->getMes()),
                'valor' => $item->getValor(),
                'id_moneda_origen'=>$item->getIdMonedaOrigen()->getId(),
                'nombre_moneda_origen'=>$item->getIdMonedaOrigen()->getNombre(),
                'id_moneda_destino'=>$item->getIdMonedaDestino()->getId(),
                'nombre_moneda_destino'=>$item->getIdMonedaDestino()->getNombre(),
            );
        }
        return $this->render('contabilidad/config/tasa_cambio/index.html.twig',  [
            'controller_name' => 'TasaCambioController',
            'tasa_cambio' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contabilidad/config/tasa-cambio-add", name="contabilidad_config_tasa-cambio_add")
     */
    public function addTasaCambio(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(TasaCambio::class);
        $params = array(
            'id_moneda_origen'=>$request->get('id_moneda_origen'),
            'id_moneda_destino'=>$request->get('id_moneda_destino'),
            'mes'=>$request->get('mes'),
            'anno'=>$request->get('anno'),
            'activo'=>true
        );
        if (!AuxFunctions::isDuplicate($entity_repository, $params, 'add')) {
            /**@var $obj_tazaCambio TasaCambio** */
            $obj_tazaCambio = new TasaCambio();
            $obj_tazaCambio
                ->setAnno(intval($request->get('anno')))
                ->setMes($request->get('mes'))
                ->setValor(floatval($request->get('valor')))
                ->setIdMonedaOrigen($em->getRepository(Moneda::class)->find($request->get('id_moneda_origen')))
                ->setIdMonedaDestino($em->getRepository(Moneda::class)->find($request->get('id_moneda_destino')))
                ->setActivo(true);
            try {
                $em->persist($obj_tazaCambio);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Tasa de cambio adicionada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "La tasa de cambio ya se encuentra registrada");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/tasa-cambio-upd", name="contabilidad_config_tasa-cambio_upd")
     */
    public function updTasaCambio(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $entity_repository = $em->getRepository(TasaCambio::class);
        $params = array(
            'id_moneda_origen'=>$request->get('id_moneda_origen'),
            'id_moneda_destino'=>$request->get('id_moneda_destino'),
            'mes'=>$request->get('mes'),
            'anno'=>$request->get('anno'),
            'activo'=>true
        );
        if (! AuxFunctions::isDuplicate($entity_repository, $params, 'upd',$request->get('id_tasa_cambio'))) {
            /**@var $obj_tasa_cambio TasaCambio***/
            $obj_tasa_cambio = $em->getRepository(TasaCambio::class)->find($request->get('id_tasa_cambio'));
            if(!$obj_tasa_cambio){
                $this->addFlash('error', "La tasa de cambio solicitada no se encuentra en la base de datos");
                return new JsonResponse(['success' => true]);
            }
            $obj_tasa_cambio
                ->setAnno(intval($request->get('anno')))
                ->setMes($request->get('mes'))
                ->setValor(floatval($request->get('valor')))
                ->setIdMonedaOrigen($em->getRepository(Moneda::class)->find($request->get('id_moneda_origen')))
                ->setIdMonedaDestino($em->getRepository(Moneda::class)->find($request->get('id_moneda_destino')))
                ->setActivo(true);
            try {
                $em->persist($obj_tasa_cambio);
                $em->flush();
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
            $this->addFlash('success', "Tasa de cambio actualizada satisfactoriamente");
            return new JsonResponse(['success' => true]);
        }
        $this->addFlash('error', "La tasa de cambio ya se encuentra registrada");
        return new JsonResponse(['success' => false]);
    }

    /**
     * @Route("/contabilidad/config/tasa-cambio-delete/{id}", name="contabilidad_config_tasa_cambio_delete")
     */
    public function Delete($id)
    {
        $em = $this->getDoctrine()->getManager();

            $tasa_cambio_er = $em->getRepository(TasaCambio::class);
            $tasa_cambio_obj = $tasa_cambio_er->find($id);
            $msg = 'No se pudo eliminar la tasa de cambio seleccionada';
            $success = 'error';
            if ($tasa_cambio_obj) {
                /**@var $tasa_cambio_obj TasaCambio** */
                $tasa_cambio_obj->setActivo(false);
                try {
                    $em->persist($tasa_cambio_obj);
                    $em->flush();
                    $success = 'success';
                    $msg = 'Tasa de cambio eliminada satisfactoriamente';

                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            }
        $this->addFlash($success, $msg);
        return $this->redirectToRoute('contabilidad_config_tasa_cambio');
    }
}
