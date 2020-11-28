<?php
namespace App\Service\Product;

use App\Entity\Product;
use App\Repository\ProductTranslationRepository;

interface ProductServiceInterface
{
    public function deleteProduct(Product $product, $entityManager, $dir);
}
