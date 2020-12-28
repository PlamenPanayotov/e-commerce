<?php
namespace App\Service\Category;

use App\Repository\CategoryRepository;
use App\Repository\NavigationRepository;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    private $navigationRepository;

    public function __construct(CategoryRepository $categoryRepository, NavigationRepository $navigationRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->navigationRepository = $navigationRepository;
    }
    
    public function getAll()
    {
        return $this->categoryRepository->findAll();
    }

    public function getSortedCategories()
    {
        return $this->navigationRepository->findBy([], ['sequence' => 'ASC']);
    }
}