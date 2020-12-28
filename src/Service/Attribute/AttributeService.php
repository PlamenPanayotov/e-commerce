<?php
namespace App\Service\Attribute;

use App\Repository\AttributeRepository;

class AttributeService implements AttributeServiceInterface
{
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function getAll()
    {
        return $this->attributeRepository->findAll();
    }
}