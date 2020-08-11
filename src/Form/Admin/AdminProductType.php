<?php

namespace App\Form\Admin;

use App\Entity\Product;
use App\Entity\ProductTranslation;
use App\Form\ProductTranslationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('category')
            
                
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('metaKeywords', TextType::class, ['mapped' => false])
                ->add('metaDescription', TextType::class, ['mapped' => false])
                ->add('shortDescription', TextType::class, ['mapped' => false])
                ->add('locale', TextType::class, ['mapped' => false])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
