<?php

namespace App\Controller\Store;

use App\Entity\Product;
use App\Service\Category\CategoryServiceInterface;
use App\Service\Product\ProductOptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("product")
 */
class ProductController extends AbstractController
{

    private $categoryService;
    private $productOptionService;

    public function __construct(CategoryServiceInterface $categoryService,
                                ProductOptionServiceInterface $productOptionService)
    {
        $this->categoryService = $categoryService;
        $this->productOptionService = $productOptionService;
    }
    /**
     * @Route("/details/{id}", name="product_details")
     */
    public function productDetails(Product $product): Response
    {
        return $this->render('store/product/product_details.html.twig', [
            'product' => $product,
            'categories' => $this->categoryService->getSortedCategories(),
            'productOptionGroups' => $this->productOptionService->getOptionGroupsByProduct($product->getId()),
        ]);
    }
}
