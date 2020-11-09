<?php
namespace App\Service\Product;

use App\Entity\Option;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;
use App\Repository\ProductOptionRepository;
use App\Service\Option\OptionServiceInterface;
use Symfony\Component\Form\Form;

class ProductOptionService implements ProductOptionServiceInterface
{

    private $optionService;
    
    private $productOptionRepository;

    public function __construct(OptionServiceInterface $optionService,
                                ProductOptionRepository $productOptionRepository)
    {
        $this->optionService = $optionService;
        $this->productOptionRepository = $productOptionRepository;
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

    public function getProductOptionsByProduct(int $productId = null)
    {
        if($productId) {
            return $this->productOptionRepository->findBy(["product" => $productId]);
        }
        return null;
    }

    public function getOptionGroupsByProduct(int $productId = null)
    {
        if($productId) {
            $options = $this->getProductOptionsByProduct($productId);
            foreach ($options as $option) {
                $optionGroups = $option->getOptionGroup();
            break;
            }
            // dump($optionGroups);
            // exit;
            return $optionGroups;
        }
        return null;        
    }
}