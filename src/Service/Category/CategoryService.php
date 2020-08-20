<?php
namespace App\Service\Category;

use App\Repository\CategoryRepository;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    
    public function getAll()
    {
        return $this->categoryRepository->findAll();
    }
}