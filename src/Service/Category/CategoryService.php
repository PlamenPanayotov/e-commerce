<?php
namespace App\Service\Category;

use App\Entity\CategoryTranslation;
use App\Repository\CategoryRepository;
use App\Repository\NavigationRepository;
use App\Repository\LanguageRepository;

class CategoryService implements CategoryServiceInterface
{
    private $categoryRepository;

    private $navigationRepository;

    private $languageRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        NavigationRepository $navigationRepository,
        LanguageRepository $languageRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->navigationRepository = $navigationRepository;
        $this->languageRepository = $languageRepository;
    }

    public function setCategoryTranslation($category, $form, $entityManager)
    {
        $languages = $this->languageRepository->findAll();

        foreach ($languages as $language) {
            $categoryTranslation = new CategoryTranslation();
            $categoryTranslation
                ->setLanguage($language)
                ->setName($form->get($language->getLocale())->getData())
                ->setCategory($category);

            $entityManager->persist($categoryTranslation);
        }
    }

    public function editCategoryTranslation($category, $form, $entityManager)
    {
        $languages = $this->languageRepository->findAll();
        $translations = $category->getTranslations();

        for ($i = 0; $i < count($languages); $i++) {
            if ($translations[$i]) {
                $translations[$i]->setName(
                    $form->get($languages[$i]->getLocale())->getData()
                );
            } else {
                $categoryTranslation = new CategoryTranslation();
                $categoryTranslation
                    ->setLanguage($languages[$i])
                    ->setName(
                        $form->get($languages[$i]->getLocale())->getData()
                    )
                    ->setCategory($category);

                $entityManager->persist($categoryTranslation);
            }
        }
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
