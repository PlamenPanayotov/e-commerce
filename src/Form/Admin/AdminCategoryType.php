<?php

namespace App\Form\Admin;

use App\Entity\Category;
use App\Repository\LanguageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminCategoryType extends AbstractType
{
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $languages = $this->languageRepository->findAll();
        $builder
            ->add('parent')
        ;
        
        foreach ($languages as $language) {
            $builder
                ->add($language->getLocale(), TextType::class, [
                    'mapped' => false, 
                    'label' => $language->getLanguage()
                ])
            ;    
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
