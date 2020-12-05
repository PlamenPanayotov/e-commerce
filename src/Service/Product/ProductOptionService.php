<?php
namespace App\Service\Product;

use App\Entity\Option;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;
use App\Repository\ProductOptionRepository;
use App\Repository\ProductRepository;
use App\Service\Option\OptionServiceInterface;
use Symfony\Component\Form\Form;

class ProductOptionService implements ProductOptionServiceInterface
{

    private $optionService;
    
    private $productOptionRepository;

    private $productRepository;

    public function __construct(OptionServiceInterface $optionService,
                                ProductOptionRepository $productOptionRepository,
                                ProductRepository $productRepository)
    {
        $this->optionService = $optionService;
        $this->productOptionRepository = $productOptionRepository;
        $this->productRepository = $productRepository;
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
            $group = '';
            $optionGroups = [];
            foreach ($options as $option) {
                $optionGroup = $option->getOptionGroup();
                if($group !== $optionGroup) {
                    array_push($optionGroups, $optionGroup);
                    $group = $optionGroup;
                }
            }
            return $optionGroups;
        }
        return null;        
    }
}