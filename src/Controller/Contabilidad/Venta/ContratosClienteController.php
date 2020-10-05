<?php

namespace App\Controller\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ContratosCliente;
use App\Form\Contabilidad\Venta\ContratosClienteType;
use App\Repository\Contabilidad\Venta\ContratosClienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/contabilidad/venta/contratos-cliente")
 */
class ContratosClienteController extends AbstractController
{
    /**
     * @Route("/", name="contabilidad_venta_contratos_cliente_index", methods={"GET"})
     */
    public function index(ContratosClienteRepository $contratosClienteRepository): Response
    {
        return $this->render('contabilidad/venta/contratos_cliente/index.html.twig', [
            'contratos_clientes' => $contratosClienteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="contabilidad_venta_contratos_cliente_new", methods={"GET","POST"})
     */
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $contratosCliente = new ContratosCliente();
        $form = $this->createForm(ContratosClienteType::class, $contratosCliente);
        $form->handleRequest($request);
        $error = $validator->validate($contratosCliente);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $year_ = Date('Y');
            $contratosCliente->setActivo(true);
            $contratosCliente->setAnno($year_);
            $contratosCliente->setResto($contratosCliente->getImporte());
            $entityManager->persist($contratosCliente);
            $entityManager->flush();
            $this->addFlash('success', 'Almacén creado satisfactoriamente');
            return $this->redirectToRoute('contabilidad_venta_contratos_cliente_index');
        }

        if ($error->count()) $this->addFlash('error', $error->get(0)->getMessage());

        return $this->render('contabilidad/venta/contratos_cliente/new.html.twig', [
            'contratos_cliente' => $contratosCliente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contabilidad_venta_contratos_cliente_show", methods={"GET"})
     */
    public function show(ContratosCliente $contratosCliente): Response
    {
        return $this->render('contabilidad/venta/contratos_cliente/show.html.twig', [
            'contratos_cliente' => $contratosCliente,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="contabilidad_venta_contratos_cliente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContratosCliente $contratosCliente, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(ContratosClienteType::class, $contratosCliente);
        $form->handleRequest($request);
        $error = $validator->validate($contratosCliente);
        if ($form->isSubmitted() && $form->isValid()) {
            $contratosCliente->setResto($contratosCliente->getImporte());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Almacén actualizado satisfactoriamente');
            return $this->redirectToRoute('contabilidad_venta_contratos_cliente_index');
        }
        if ($error->count()) $this->addFlash('error', $error->get(0)->getMessage());
        return $this->render('contabilidad/venta/contratos_cliente/edit.html.twig', [
            'contratos_cliente' => $contratosCliente,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="contabilidad_venta_contratos_cliente_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ContratosCliente $contratosCliente): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contratosCliente->getId(), $request->request->get('_token'))) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $contratosCliente->setActivo(false);
                $entityManager->persist($contratosCliente);
                $entityManager->flush();
                $this->addFlash('success', 'Almacén eliminado satisfactoriamente');
            } catch
            (FileException $exception) {
                return new \Exception('La petición ha retornado un error, contacte a su proveedro de software.');
            }
        }

        return $this->redirectToRoute('contabilidad_venta_contratos_cliente_index');
    }
}
