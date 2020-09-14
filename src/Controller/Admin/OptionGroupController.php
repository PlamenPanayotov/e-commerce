<?php

namespace App\Controller\Admin;

use App\Entity\OptionGroup;
use App\Form\Admin\OptionGroupType;
use App\Repository\OptionGroupRepository;
use App\Service\Option\OptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/options_group")
 */
class OptionGroupController extends AbstractController
{
    private $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }
    /**
     * @Route("/", name="option_group_index", methods={"GET"})
     */
    public function index(OptionGroupRepository $optionGroupRepository): Response
    {
        return $this->render('admin/option_group/index.html.twig', [
            'option_groups' => $optionGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="option_group_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $optionGroup = new OptionGroup();
        $form = $this->createForm(OptionGroupType::class, $optionGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($optionGroup);
            $entityManager->flush();

            return $this->redirectToRoute('option_group_index');
        }

        return $this->render('admin/option_group/new.html.twig', [
            'option_group' => $optionGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_group_show", methods={"GET"})
     */
    public function show(OptionGroup $optionGroup): Response
    {
        $options = $this->optionService->getAllByOneGroup($optionGroup->getId());
        return $this->render('admin/option_group/show.html.twig', [
            'option_group' => $optionGroup,
            'options' => $options
        ]);
    }

    /**
     * @Route("/{id}/edit", name="option_group_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OptionGroup $optionGroup): Response
    {
        $form = $this->createForm(OptionGroupType::class, $optionGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('option_group_index');
        }

        return $this->render('admin/option_group/edit.html.twig', [
            'option_group' => $optionGroup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="option_group_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OptionGroup $optionGroup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$optionGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($optionGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('option_group_index');
    }
}
