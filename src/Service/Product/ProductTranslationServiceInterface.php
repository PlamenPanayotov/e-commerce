<?php
namespace App\Service\Product;

use App\Entity\Product;
use App\Entity\ProductTranslation;
use Symfony\Component\Form\FormInterface;

interface ProductTranslationServiceInterface
{
    public function setTranslation(ProductTranslation $firstTranslation,
                                    ProductTranslation $secondTranslation, 
                                    FormInterface $form,
                                    Product $product): bool;
}