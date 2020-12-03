<?php

namespace App\Controller\Store;

use App\Entity\Product;
use App\Service\Category\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("product")
 */
class ProductController extends AbstractController
{

    private $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * @Route("/details/{id}", name="product_details")
     */
    public function productDetails(Product $product): Response
    {
        return $this->render('product/product_details.html.twig', [
            'product' => $product,
            'categories' => $this->categoryService->getAll()
        ]);
    }
}
