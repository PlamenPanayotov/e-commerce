<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * One Category has Many Categories.
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * Many Categories have One Category.
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\Column(type="integer")
     */
    private $row;

     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CategoryTranslation", mappedBy="category")
     */
    private $translations;
    
    public function __construct() 
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get one Category has Many Categories.
     */ 
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set one Category has Many Categories.
     *
     * @return  self
     */ 
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get many Categories have One Category.
     */ 
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set many Categories have One Category.
     *
     * @return  self
     */ 
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(int $row): self
    {
        $this->row = $row;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    // public function addChild(Category $child): self
    // {
    //     if (!$this->children->contains($child)) {
    //         $this->children[] = $child;
    //         $child->setParent($this);
    //     }

    //     return $this;
    // }

    // public function removeChild(Category $child): self
    // {
    //     if ($this->children->contains($child)) {
    //         $this->children->removeElement($child);
    //         // set the owning side to null (unless already changed)
    //         if ($child->getParent() === $this) {
    //             $child->setParent(null);
    //         }
    //     }

    //     return $this;
    // }

    
   
    /**
     * Set the value of nameBg
     *
     * @return  self
     */ 
    public function setNameBg($nameBg)
    {
        $this->nameBg = $nameBg;

        return $this;
    }

    /**
     * Get the value of nameBg
     */ 
    public function getNameBg()
    {
        return $this->nameBg;
    }

}
