<?php

namespace App\Form\Admin;

use App\Entity\Category;
use App\Entity\OptionGroup;
use App\Entity\Product;
use App\Entity\ProductOption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('price', TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class
            ])
            ->add('option', EntityType::class, [
                'class' => OptionGroup::class,
                'mapped' => false
            ])
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('images', FileType::class, [
                'mapped' => false,
                'multiple' => true
            ])
            
                
                ->add('name_en', TextType::class, [
                    'mapped' => false,
                    ])
                ->add('description_en', TextareaType::class, ['mapped' => false])
                ->add('metaKeywords_en', TextType::class, ['mapped' => false])
                ->add('metaDescription_en', TextareaType::class, ['mapped' => false])
                ->add('shortDescription_en', TextareaType::class, ['mapped' => false])

                ->add('name_bg', TextType::class, ['mapped' => false])
                ->add('description_bg', TextareaType::class, ['mapped' => false])
                ->add('metaKeywords_bg', TextType::class, ['mapped' => false])
                ->add('metaDescription_bg', TextareaType::class, ['mapped' => false])
                ->add('shortDescription_bg', TextareaType::class, ['mapped' => false])
                
                // ->add('option_group', FormType::class, [
                //     'data_class' => OptionGroupType::class,
                //     'mapped' => false
                // ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
