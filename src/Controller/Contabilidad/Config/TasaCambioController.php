<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\Config\TasaCambio;
use App\Form\Contabilidad\Config\TasaCambioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TasaCambioController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/tasa-cambio")
 */
class TasaCambioController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_tasa_cambio", methods={"GET"})
     */
    public function index(EntityManagerInterface $em)
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
                'id_moneda_origen' => $item->getIdMonedaOrigen()->getId(),
                'nombre_moneda_origen' => $item->getIdMonedaOrigen()->getNombre(),
                'id_moneda_destino' => $item->getIdMonedaDestino()->getId(),
                'nombre_moneda_destino' => $item->getIdMonedaDestino()->getNombre(),
            );
        }
        return $this->render('contabilidad/config/tasa_cambio/index.html.twig', [
            'controller_name' => 'TasaCambioController',
            'tasa_cambio' => $row,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_tasa-cambio_add", methods={"POST"})
     */
    public function addTasaCambio(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(TasaCambioType::class);
        $form->handleRequest($request);
        /** @var TasaCambio $tasacambio */
        $tasacambio = $form->getData();
        $errors = $validator->validate($tasacambio);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $tasacambio->setActivo(true);
                $em->persist($tasacambio);

                $another = new TasaCambio();
                $another
                    ->setAnno($tasacambio->getAnno())
                    ->setMes($tasacambio->getMes())
                    ->setActivo(true)
                    ->setIdMonedaDestino($tasacambio->getIdMonedaOrigen())
                    ->setIdMonedaOrigen($tasacambio->getIdMonedaDestino())
                    ->setValor((1/$tasacambio->getValor()));
                $em->persist($another);
                $em->flush();
                $this->addFlash('success', "Centro de Costo adicionado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_tasa_cambio');
    }

    /**
     * @Route("/upd/{id}", name="contabilidad_config_tasa-cambio_upd", methods={"POST"})
     */
    public function updTasaCambio(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, TasaCambio $cambio)
    {
        $form = $this->createForm(TasaCambioType::class, $cambio);
        $form->handleRequest($request);
        $errors = $validator->validate($cambio);
        if ($form->isValid() && $form->isSubmitted()) {
            try {
                $em->persist($cambio);
                $em->flush();
                $this->addFlash('success', "La tasa de cambio actualizada satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_tasa_cambio');
    }

    /**
     * @Route("/delete/{id}", name="contabilidad_config_tasa_cambio_delete", methods={"DELETE"})
     */
    public function Delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {

            $em = $this->getDoctrine()->getManager();
            $tasa_cambio_obj = $em->getRepository(TasaCambio::class)->find($id);
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
        }
        return $this->redirectToRoute('contabilidad_config_tasa_cambio');
    }
}
