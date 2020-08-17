<?php

namespace App\Controller;

use App\Entity\ProductTranslation;
use App\Form\ProductTranslation1Type;
use App\Repository\ProductTranslationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product/translation")
 */
class ProductTranslationController extends AbstractController
{
    /**
     * @Route("/", name="product_translation_index", methods={"GET"})
     */
    public function index(ProductTranslationRepository $productTranslationRepository): Response
    {
        return $this->render('product_translation/index.html.twig', [
            'product_translations' => $productTranslationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_translation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productTranslation = new ProductTranslation();
        $form = $this->createForm(ProductTranslationType::class, $productTranslation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productTranslation);
            $entityManager->flush();

            return $this->redirectToRoute('product_translation_index');
        }

        return $this->render('product_translation/new.html.twig', [
            'product_translation' => $productTranslation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_translation_show", methods={"GET"})
     */
    public function show(ProductTranslation $productTranslation): Response
    {
        return $this->render('product_translation/show.html.twig', [
            'product_translation' => $productTranslation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_translation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductTranslation $productTranslation): Response
    {
        $form = $this->createForm(ProductTranslation1Type::class, $productTranslation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_translation_index');
        }

        return $this->render('product_translation/edit.html.twig', [
            'product_translation' => $productTranslation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_translation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductTranslation $productTranslation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productTranslation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productTranslation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_translation_index');
    }
}
