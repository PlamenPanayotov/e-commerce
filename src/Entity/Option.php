<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`option`")
 */
class Option
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
     * @ORM\ManyToOne(targetEntity="App\Entity\OptionGroup", inversedBy="options")
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductOption", mappedBy="option")
     */
    private $productOptions;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
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

    

    public function getGroup(): ?OptionGroup
    {
        return $this->group;
    }

    
    public function setGroup(OptionGroup $group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Collection|ProductOptions[]
     */
    public function getProductOptions(): Collection
    {
        return $this->productOptions;
    }
}
