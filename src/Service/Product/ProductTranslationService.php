<?php
namespace App\Service\Product;

use App\Entity\Product;
use App\Entity\ProductTranslation;
use Symfony\Component\Form\FormInterface;

class ProductTranslationService implements ProductTranslationServiceInterface
{
    public function setTranslation(ProductTranslation $fitstTranslation,
                                     ProductTranslation $secondTranslation,
                                    FormInterface $form,
                                    Product $product): bool
    {
        $product->setName($form->get('name_en')->getData());
        $product->setDescription($form->get('description_en')->getData());
        $fitstTranslation->setName($form->get('name_en')->getData());
        $fitstTranslation->setDescription($form->get('description_en')->getData());
        $fitstTranslation->setMetaKeywords($form->get('metaKeywords_en')->getData());
        $fitstTranslation->setMetaDescription($form->get('metaDescription_en')->getData());
        $fitstTranslation->setShortDescription($form->get('shortDescription_en')->getData());
        $fitstTranslation->setLocale('en_US');
        $fitstTranslation->setProduct($product);

        $secondTranslation->setName($form->get('name_bg')->getData());
        $secondTranslation->setDescription($form->get('description_bg')->getData());
        $secondTranslation->setMetaKeywords($form->get('metaKeywords_bg')->getData());
        $secondTranslation->setMetaDescription($form->get('metaDescription_bg')->getData());
        $secondTranslation->setShortDescription($form->get('shortDescription_bg')->getData());
        $secondTranslation->setLocale('bg_BG');
        $secondTranslation->setProduct($product);

        return true;
    }
}