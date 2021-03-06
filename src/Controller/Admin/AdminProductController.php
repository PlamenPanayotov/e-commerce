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
use App\Service\Attribute\AttributeServiceInterface;
use App\Service\Category\CategoryServiceInterface;
use App\Service\Option\OptionServiceInterface;
use App\Service\OptionGroup\OptionGroupServiceInterface;
use App\Service\Product\ProductOptionServiceInterface;
use App\Service\Product\ProductServiceInterface;
use App\Service\Product\ProductTranslationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Regex;

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
    private $productService;
    private $productRepository;
    private $attributeService;

    public function __construct(ProductTranslationServiceInterface $productTranslationService,
                                CategoryServiceInterface $categoryService,
                                AdminServiceInterface $adminService,
                                OptionServiceInterface $optionService,
                                OptionGroupServiceInterface $optionGroupService,
                                ProductOptionServiceInterface $productOptionService,
                                AttachmentServiceInterface $attachmentService,
                                ProductServiceInterface $productService,
                                ProductRepository $productRepository,
                                AttributeServiceInterface $attributeService)
    {
        $this->productTranslationService = $productTranslationService;
        $this->categoryService = $categoryService;
        $this->adminService = $adminService;
        $this->optionService = $optionService;
        $this->optionGroupService = $optionGroupService;
        $this->productOptionService = $productOptionService;
        $this->attachmentService = $attachmentService;
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->attributeService = $attributeService;
    }

    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductTranslationRepository $productTranslationRepository, Request $request): Response
    {       
        return $this->render('admin/product/all_products.html.twig', [
            'products' => $this->productRepository->findAll(),
            'admin' => $this->adminService->currentAdmin()
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
            $product->addAttribute($form->get('attribute')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->persist($productFirstTranslation);
            $entityManager->persist($productSecondTranslation);
        
            $directory = $this->getParameter('uploads_directory');
            
            $this->attachmentService->addAttachments($directory, $product, $entityManager, $request);

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
            'attributes' => $this->attributeService->getAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        $optionGroups = $this->productOptionService->getOptionGroupsByProduct($product->getId());
        $options = $this->optionService->getAllByOneProduct($product->getId());
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
            'optionGroups' => $optionGroups,
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
    
            $this->attachmentService->addAttachments($directory, $product, $entityManager, $request);

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
            'attachments' => $this->attachmentService->getAllByOneProduct($product),
            'attributes' => $this->attributeService->getAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $directory = $this->getParameter('uploads_directory') . '/';
            $entityManager = $this->getDoctrine()->getManager();
            $this->productService->deleteProduct($product, $entityManager, $directory);            
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
