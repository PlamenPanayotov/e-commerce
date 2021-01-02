<?php
namespace App\Service\Category;


interface CategoryServiceInterface
{
    public function setCategoryTranslation($category, $form, $entityManager);

    public function getAll();

    public function getSortedCategories();
}