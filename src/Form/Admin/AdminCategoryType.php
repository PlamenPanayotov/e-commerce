<?php

namespace App\Form\Admin;

use App\Entity\Category;
use App\Repository\LanguageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminCategoryType extends AbstractType
{
    private $languageRepository;

    public function __construct(
        LanguageRepository $languageRepository,
        RequestStack $requestStack
    ) {
        $this->languageRepository = $languageRepository;
        $this->request = $requestStack->getCurrentRequest();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $languages = $this->languageRepository->findAll();
        $builder->add('parent');

        $category = $this->request->get('category');
        if ($category) {
            $translations = $category->getTranslations();

            for ($i = 0; $i < count($languages); $i++) {
                $builder->add($languages[$i]->getLocale(), TextType::class, [
                    'mapped' => false,
                    'label' => $category->getTranslations()[$i]
                        ? $category
                            ->getTranslations()
                            [$i]->getLanguage()
                            ->getLanguage()
                        : null,
                    'data' => $category->getTranslations()[$i]
                        ? $category->getTranslations()[$i]->getName()
                        : null,
                ]);
            }
        } else {
            foreach ($languages as $language) {
                $builder->add($language->getLocale(), TextType::class, [
                    'mapped' => false,
                    'label' => $language->getLanguage(),
                ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
