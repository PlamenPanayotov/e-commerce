<?php
namespace App\Service\OptionGroup;

use App\Repository\OptionGroupRepository;
use App\Service\Option\OptionServiceInterface;

class OptionGroupService implements OptionGroupServiceInterface
{
    private $optionGroupRepository;

    public function __construct(OptionGroupRepository $optionGroupRepository)
    {
        $this->optionGroupRepository = $optionGroupRepository;
    }

    public function getAll()
    {
        $this->optionGroupRepository->findAll();
    }
}