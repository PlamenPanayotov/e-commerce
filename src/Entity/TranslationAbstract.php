<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class TranslationAbstract
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    protected $language;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    
     /**
     * Get the value of language
     */ 
    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    /**
     * Set the value of language
     *
     * @return  self
     */ 
    public function setLanguage(?Language $language)
    {
        $this->language = $language;

        return $this;
    }
}