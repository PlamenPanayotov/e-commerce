<?php
namespace App\Service\Option;

use App\Repository\OptionRepository;
use App\Repository\ProductOptionRepository;

class OptionService implements OptionServiceInterface
{
    private $optionRepository;
    private $productOptionRepository;

    public function __construct(OptionRepository $optionRepository,
                                ProductOptionRepository $productOptionRepository)
    {
        $this->optionRepository = $optionRepository;
        $this->productOptionRepository = $productOptionRepository;
    }
    public function getAll()
    {
        return $this->optionRepository->findAll();
    }

    public function getAllByOneGroup(int $groupId)
    {
        return $this->optionRepository->findBy(['group' => $groupId]);
    }

    public function getAllByOneProduct(int $productId)
    {
        $prductOptions = $this->productOptionRepository->findBy(['product' => $productId]);
        $options = [];
        foreach ($prductOptions as $option) {
            array_push($options, $option->getOption());
        }
        return $options;
    }
}