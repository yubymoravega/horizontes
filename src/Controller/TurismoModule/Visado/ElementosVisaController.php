<?php

namespace App\Controller\TurismoModule\Visado;

use App\CoreContabilidad\AuxFunctions;
use App\CoreTurismo\AuxFunctionsTurismo;
use App\Entity\Cliente;
use App\Entity\Contabilidad\Config\Servicios;
use App\Entity\Contabilidad\Config\Unidad;
use App\Entity\TurismoModule\Visado\ElementosVisa;
use App\Form\Contabilidad\Config\UnidadType;
use App\Form\TurismoModule\Visado\ElementosVisaType;
use ContainerI1pew61\getUserClientTmpRepositoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ElementosVisaController
 * @package App\Controller\TurismoModule\Visado
 * @Route("/configuracion-turismo/gestion-consular/elementos-visa")
 */
class ElementosVisaController extends AbstractController
{
    /**
     * @Route("/", name="turismo_module_visado_elementos_visa")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ElementosVisaType::class);

        /** @var Cliente $obj_cliente */
        $obj_cliente = AuxFunctionsTurismo::GetDataCliente($em,$this->getUser());
        $data_elementos = $em->getRepository(ElementosVisa::class)->findBy([
            'activo'=>true,
            'id_servicio'=>$em->getRepository(Servicios::class)->find(AuxFunctionsTurismo::IDENTIFICADOR_VISADO),
            'id_unidad'=>AuxFunctions::getUnidad($em,$this->getUser())
        ]);
        $rows = [];
        /** @var ElementosVisa $item */
        foreach ($data_elementos as $item){
            $rows[]= array(
                'descripcion'=>$item->getDescripcion(),
                'costo_str'=>number_format($item->getCosto(),2),
                'costo'=>$item->getCosto(),
                'id_proveedor'=>$item->getIdProveedor()->getId(),
                'proveedor'=>$item->getIdProveedor()->getNombre(),
                'codigo'=>$item->getCodigo(),
                'id'=>$item->getId()
            );
        }
        return $this->render('turismo_module/visado/elementos_visa/index.html.twig', [
            'controller_name' => 'ElementosVisaController',
            'elementos'=>$rows,
            'form' => $form->createView(),
            'telefono'=>$obj_cliente->getTelefono(),
            'nombre'=>$obj_cliente->getNombre(),
            'apellidos'=>$obj_cliente->getApellidos(),
            'correo'=>$obj_cliente->getCorreo(),
            'direccion'=>$obj_cliente->getDireccion(),
            'id_cliente'=>$obj_cliente->getId()
        ]);
    }

    /**
     * @Route("/add", name="turismo_visdo_elementos_add", methods={"POST"})
     */
    public function addElemento(EntityManagerInterface $em, Request $request, ValidatorInterface $validator)
    {
        $form = $this->createForm(ElementosVisaType::class);
        $form->handleRequest($request);
        /** @var ElementosVisa $elemnto */
        $elemnto = $form->getData();
        $errors = $validator->validate($elemnto);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $elemnto
                    ->setIdUnidad(AuxFunctions::getUnidad($em,$this->getUser()))
                    ->setActivo(true)
                    ->setIdServicio($em->getRepository(Servicios::class)->find(AuxFunctionsTurismo::IDENTIFICADOR_VISADO))
                ;
                $em->persist($elemnto);
                $em->flush();
                $this->addFlash('success', "Elemento adicionado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('turismo_module_visado_elementos_visa');
    }


    /**
     * @Route("/upd/{id}", name="turismo_visdo_elementos_update")
     */
    public function updateUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, ElementosVisa $elementos)
    {
        $form = $this->createForm(ElementosVisaType::class, $elementos);
        $form->handleRequest($request);
        $errors = $validator->validate($elementos);
        if ($form->isSubmitted()  && $form->isValid()) {
            try {
                $em->persist($elementos);
                $em->flush();
                $this->addFlash('success', "Elemento actualizado satisfactoriamente");
            } catch (FileException $exception) {
                return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
            }
        }
        if ($errors->count()) $this->addFlash('error', $errors->get(0)->getMessage());
        return $this->redirectToRoute('turismo_module_visado_elementos_visa');
    }

    /**
     * @Route("/delete/{id}", name="turismo_visdo_elementos_delete", methods={"DELETE"})
     */
    public function deleteUnidad(EntityManagerInterface $em, Request $request, ValidatorInterface $validator, $id)
    {
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $elemento_er = $em->getRepository(ElementosVisa::class);
            $success = '';
            $msg = '';
                $elemento_obj = $elemento_er->find($id);
                $msg = 'No se pudo eliminar el almac??n';
                $success = 'error';
                if ($elemento_obj) {
                    /**@var $elemento_obj ElementosVisa** */
                    $elemento_obj->setActivo(false);
                    try {
                        $em->persist($elemento_obj);
                        $em->flush();
                        $success = 'success';
                        $msg = 'Elemento eliminado satisfactoriamente';
                    } catch
                    (FileException $exception) {
                        return new \Exception('La petici??n ha retornado un error, contacte a su proveedro de software.');
                    }
                }
            $this->addFlash($success, $msg);
        }
        return $this->redirectToRoute('turismo_module_visado_elementos_visa');
    }

}
