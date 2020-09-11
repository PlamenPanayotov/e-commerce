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
        $this->optionRepository->findAll();
    }
}