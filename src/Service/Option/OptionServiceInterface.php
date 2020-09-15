<?php
namespace App\Service\Option;

interface OptionServiceInterface
{
    public function getAll();

    public function getAllByOneGroup(int $groupId);

    public function getAllByOneProduct(int $productId);
}