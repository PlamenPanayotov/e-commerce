<?php
namespace App\Service\Option;

use App\Repository\OptionRepository;

class OptionService implements OptionServiceInterface
{
    private $optionRepository;

    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
    public function getAll()
    {
        return $this->optionRepository->findAll();
    }

    public function getAllByOneGroup(int $id)
    {
        return $this->optionRepository->findBy(['group' => $id]);
    }
}