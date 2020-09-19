<?php
namespace App\Service\Product;

use App\Entity\Option;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;
use Symfony\Component\Form\Form;

interface ProductOptionServiceInterface
{
    public function setProductOptions(ProductOption $productOption, 
                                        Product $product, 
                                        OptionGroup $optionGroup,
                                        Option $option, 
                                        Form $form);

    public function addOptions($product, $form, $em);
}