<?php
namespace App\Service\Category;


interface CategoryServiceInterface
{
    public function getAll();

    public function getSortedCategories();
}