<?php
namespace App\Service\Product;

use App\Entity\Option;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;

class ProductOptionService implements ProductOptionServiceInterface
{
    public function setProductOptions(ProductOption $productOption, Product $product, Option $option, OptionGroup $optionGroup)
    {
        
        $productOption->setProduct($product)
                    ->setOption($option)
                    ->setOptionGroup($optionGroup);     
        
    }
}