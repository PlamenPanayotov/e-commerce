<?php

namespace App\Entity;

use App\Repository\OptionGroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionGroupeRepository::class)
 */
class OptionGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Option", mappedBy="group")
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductOption", mappedBy="option_group")
     */
    private $productOptions;

    public function __construct()
    {
        $this->productOptions = new ArrayCollection();
    }

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
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /**
     * @return Collection|ProductOptions[]
     */
    public function getProductOptions(): Collection
    {
        return $this->productOptions;
    }
    
}
