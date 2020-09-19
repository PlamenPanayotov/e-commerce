<?php
namespace App\Service\Product;

use App\Entity\Option;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;
use App\Service\Option\OptionServiceInterface;
use Symfony\Component\Form\Form;

class ProductOptionService implements ProductOptionServiceInterface
{

    private $optionService;

    public function __construct(OptionServiceInterface $optionService)
    {
        $this->optionService = $optionService;
    }
   
    public function setProductOptions(ProductOption $productOption, 
                                        Product $product, 
                                        OptionGroup $optionGroup,
                                        Option $option, 
                                        Form $form)
    {  
        $productOption->setProduct($product)
                        ->setOptionGroup($optionGroup)
                        ->setOption($option)
                        ->setPriceIncrement(0);
    }

    public function addOptions($product, $form, $em)
    {
        $optionGroup = $form->get('option')->getData();
            if ($optionGroup != null) {
                $options = $this->optionService->getAllByOneGroup($optionGroup->getId());

                foreach ($options as $option) {
                    $productOption = new ProductOption();
                    $this->setProductOptions($productOption, $product, $optionGroup, $option, $form);
                    $em->persist($productOption);
                }
            }
    }
}