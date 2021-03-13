<?php

namespace App\Controller\Contabilidad\Config;

use App\CoreContabilidad\AuxFunctions;
use App\Entity\Contabilidad\CapitalHumano\Empleado;
use App\Entity\Contabilidad\Config\Impuesto;
use App\Form\Contabilidad\Config\ImpuestoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ImpuestoController
 * @package App\Controller\Contabilidad\Config
 * @Route("/contabilidad/config/impuesto")
 */
class ImpuestoController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_config_impuesto")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $unidad = AuxFunctions::getUnidad($em,$this->getUser());
        $impuestos = $em->getRepository(Impuesto::class)->findBy(['id_unidad'=>$unidad,'activo'=>true]);
        $formulario = $this->createForm(ImpuestoType::class);
        $rows = [];
        foreach ($impuestos as $item){
            $rows[]=[
                'nombre'=>$item->getNombre(),
                'valor'=>number_format($item->getValor(),2),
                'id'=>$item->getId()
            ];
        }
        return $this->render('contabilidad/config/impuesto/index.html.twig', [
            'controller_name' => 'ImpuestoController',
            'form'=>$formulario->createView(),
            'impuestos'=>$rows
        ]);
    }

    /**
     * @Route("/add", name="contabilidad_config_impuesto_add", methods={"POST"})
     */
    public function add(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ImpuestoType::class);
        $form->handleRequest($request);
        /** @var Impuesto $impuesto */
        $impuesto = $form->getData();
        $errors = $validator->validate($impuesto);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $id_usuario = $this->getUser();
                $empleado = $em->getRepository(Empleado::class)->findOneBy(array(
                    'id_usuario' => $id_usuario
                ));
                if ($empleado) {
                    $impuesto
                        ->setIdUnidad($empleado->getIdUnidad())
                        ->setActivo(true);

                    $duplicate = $em->getRepository(Impuesto::class)->findOneBy([
                        'nombre'=>$impuesto->getNombre(),
                        'id_unidad'=>$empleado->getIdUnidad()
                    ]);
                    if($duplicate){
                        $this->addFlash('error', "Ya existe un impuesto con el nombre ".$impuesto->getNombre());
                        return $this->redirectToRoute('contabilidad_config_impuesto');
                    }

                    $em->persist($impuesto);
                    $em->flush();
                    $this->addFlash('success', "Impuesto adicionado satisfactoriamente");
                } else {
                    $this->addFlash('error', "Usted no es empleado de la empresa");
                }
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_impuesto');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_impuesto_upd", methods={"POST"})
     */
    public function update(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, Impuesto $impuesto)
    {
        $form = $this->createForm(ImpuestoType::class, $impuesto);
        $form->handleRequest($request);
        $errors = $validator->validate($impuesto);
        if ($form->isValid() && $form->isSubmitted()) {
            try {

                /** @var Impuesto $duplicate */
                $duplicate = $em->getRepository(Impuesto::class)->findOneBy([
                    'nombre'=>$impuesto->getNombre(),
                    'id_unidad'=>$impuesto->getIdUnidad()
                ]);
                if($duplicate && $duplicate->getId() != $impuesto->getId()){
                    $this->addFlash('error', "Ya existe un impuesto con el nombre ".$impuesto->getNombre());
                    return $this->redirectToRoute('contabilidad_config_impuesto');
                }

                $em->persist($impuesto);
                $em->flush();
                $this->addFlash('success', "Impuesto actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('contabilidad_config_impuesto');
    }

    /**
     * @Route("/{id}", name="contabilidad_config_impuesto_delete",methods={"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $_obj = $em->getRepository(Impuesto::class)->find($id);
            if ($_obj) {
                /**@var $_obj Impuesto** */
                $_obj->setActivo(false);
                try {
                    $em->persist($_obj);
                    $em->flush();
                    $this->addFlash('success', 'Impuesto eliminado satisfactoriamente');
                } catch
                (FileException $exception) {
                    return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
                }
            } else $this->addFlash('error', 'No se pudo eliminar el impuesto');
        }
        return $this->redirectToRoute('contabilidad_config_impuesto');
    }
}
