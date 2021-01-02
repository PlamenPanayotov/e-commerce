<?php

namespace App\Entity;

use App\Repository\CategoryTranslationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryTranslationRepository::class)
 */
class CategoryTranslation extends TranslationAbstract
{
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="translations")
     */
    private $category;

    /**
     * Get the value of category
     */ 
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory(?Category $category)
    {
        $this->category = $category;

        return $this;
    }
}
