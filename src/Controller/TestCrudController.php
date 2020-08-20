<?php

namespace App\Controller;

use App\Entity\TestCrud;
use App\Form\TestCrudType;
use App\Repository\TestCrudRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test/crud")
 */
class TestCrudController extends AbstractController
{
    /**
     * @Route("/", name="test_crud_index", methods={"GET"})
     */
    public function index(TestCrudRepository $testCrudRepository): Response
    {
        return $this->render('test_crud/index.html.twig', [
            'test_cruds' => $testCrudRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="test_crud_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $testCrud = new TestCrud();
        $form = $this->createForm(TestCrudType::class, $testCrud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($testCrud);
            $entityManager->flush();

            return $this->redirectToRoute('test_crud_index');
        }

        return $this->render('test_crud/new.html.twig', [
            'test_crud' => $testCrud,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_crud_show", methods={"GET"})
     */
    public function show(TestCrud $testCrud): Response
    {
        return $this->render('test_crud/show.html.twig', [
            'test_crud' => $testCrud,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_crud_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TestCrud $testCrud): Response
    {
        $form = $this->createForm(TestCrudType::class, $testCrud);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_crud_index');
        }

        return $this->render('test_crud/edit.html.twig', [
            'test_crud' => $testCrud,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_crud_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TestCrud $testCrud): Response
    {
        if ($this->isCsrfTokenValid('delete'.$testCrud->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($testCrud);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_crud_index');
    }
}
