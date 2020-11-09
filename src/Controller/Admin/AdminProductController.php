<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use App\Entity\Product;
use App\Entity\ProductOption;
use App\Entity\ProductTranslation;
use App\Form\Admin\AdminProductType;
use App\Repository\ProductRepository;
use App\Repository\ProductTranslationRepository;
use App\Service\Admin\AdminServiceInterface;
use App\Service\Attachment\AttachmentServiceInterface;
use App\Service\Category\CategoryServiceInterface;
use App\Service\Option\OptionServiceInterface;
use App\Service\OptionGroup\OptionGroupServiceInterface;
use App\Service\Product\ProductOptionServiceInterface;
use App\Service\Product\ProductTranslationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/products")
 */
class AdminProductController extends AbstractController
{
    private $productTranslationService;
    private $categoryService;
    private $adminService;
    private $optionService;
    private $optionGroupService;
    private $productOptionService;
    private $attachmentService;

    public function __construct(ProductTranslationServiceInterface $productTranslationService,
                                CategoryServiceInterface $categoryService,
                                AdminServiceInterface $adminService,
                                OptionServiceInterface $optionService,
                                OptionGroupServiceInterface $optionGroupService,
                                ProductOptionServiceInterface $productOptionService,
                                AttachmentServiceInterface $attachmentService)
    {
        $this->productTranslationService = $productTranslationService;
        $this->categoryService = $categoryService;
        $this->adminService = $adminService;
        $this->optionService = $optionService;
        $this->optionGroupService = $optionGroupService;
        $this->productOptionService = $productOptionService;
        $this->attachmentService = $attachmentService;
    }
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductTranslationRepository $productTranslationRepository, Request $request): Response
    {
        $locale = $request->getLocale();
        return $this->render('admin/product/all_products.html.twig', [
            'products' => $productTranslationRepository->findBy(['locale' => $locale]),
            'admin' => $this->adminService->currentAdmin(),
            'attachments' => $this->attachmentService->getAttachments()
        ]);
    }

    /**
     * @Route("/new/{options}", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categories = $this->categoryService->getAll();
        $optionGroups = $this->optionGroupService->getAll();

        $product = new Product();
        $productFirstTranslation = new ProductTranslation();
        $productSecondTranslation = new ProductTranslation();

        $form = $this->createForm(AdminProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
 
            $this->productTranslationService->setTranslation($productFirstTranslation, $productSecondTranslation, $form, $product);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->persist($productFirstTranslation);
            $entityManager->persist($productSecondTranslation);
        
            $directory = $this->getParameter('uploads_directory');
            $files = $request->files->get('admin_product')['images'];
            
            $this->attachmentService->addAttachments($files, $directory, $product, $entityManager, $request);

            if($request->get('options') == true) {
                $this->productOptionService->addOptions($product, $form, $entityManager);
            }
          
            $entityManager->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'optionGroups' => $optionGroups,
            'productTranslationEn' => $productFirstTranslation,
            'productTranslationBg' => $productSecondTranslation,
            'productOptionGroups' => $this->productOptionService->getOptionGroupsByProduct($product->getId()),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        $options = $this->optionService->getAllByOneProduct($product->getId());
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
            'options' => $options
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product, ProductTranslationRepository $productTranslationRepository): Response
    {
        $optionGroups = $this->optionGroupService->getAll();
        $productTranslations = $productTranslationRepository->findBy(['product' => $product->getId()]);
        $productTranslationEn = $productTranslations[0];
        $productTranslationBg = $productTranslations[1];
        $form = $this->createForm(AdminProductType::class, $product);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $directory = $this->getParameter('uploads_directory');
            
            $files = $request->files->get('admin_product')['images'];
            // dump($files);
            // exit;
            
            $this->attachmentService->addAttachments($files, $directory, $product, $entityManager, $request);

            $this->productOptionService->addOptions($product, $form, $entityManager);
            $entityManager->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'categories' => $this->categoryService->getAll(),
            'productTranslationEn' => $productTranslationEn,
            'productTranslationBg' => $productTranslationBg,
            'optionGroups' => $optionGroups,
            'productOptionGroups' => $this->productOptionService->getOptionGroupsByProduct($product->getId()),
            'attachments' => $this->attachmentService->getNamesByProduct($product),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product, ProductTranslationRepository $productTranslationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {

            $productTranslations = $productTranslationRepository->findBy(['product' => $product->getId()]);
            
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($productTranslations as $productTranslation) {
                $entityManager->remove($productTranslation);
            }

            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
