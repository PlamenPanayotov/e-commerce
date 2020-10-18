<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductTranslation", mappedBy="product")
     */
    private $translations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductOption", mappedBy="product")
     */
    private $productOptions;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Attachment", mappedBy="product", cascade={"persist"})
     */
    private $attachments;
    

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->productOptions = new ArrayCollection();
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
        $this->attachments = new ArrayCollection();
        
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @param ProductTranslation $productTranslation
     * 
     * @return Product
     */
    public function addTranslations(ProductTranslation $productTranslation)
    {
        $this->translations[] = $productTranslation;
        return $this;
    }

    /**
     * @param ProductTranslation $productTranslation
     */
    public function removeTranslations(ProductTranslation $productTranslation)
    {
        $this->translations->removeElement($productTranslation);
    }


    /**
     * @return Collection|ProductTranslation[]
     */ 
    public function getTranslations(): Collection
    {
        return $this->translations;
    }
    
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }

    // /**
    //  * Set the value of translations
    //  *
    //  * @return  self
    //  */ 
    // public function addTranslations(?ProductTranslation $translation)
    // {
    //     $this->translations->add($translation);
    //     $translation->setProduct($this);
    // }

    /**
     * @return Collection|ProductOptions[]
     */
    public function getProductOptions(): Collection
    {
        return $this->productOptions;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Attachment[]
     */
    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function addAttachment(Attachment $attachment): self
    {
        if (!$this->attachments->contains($attachment)) {
            $this->attachments[] = $attachment;
            $attachment->setProduct($this);
        }

        return $this;
    }

    public function removeAttachment(Attachment $attachment): self
    {
        if ($this->attachments->contains($attachment)) {
            $this->attachments->removeElement($attachment);
            // set the owning side to null (unless already changed)
            if ($attachment->getProduct() === $this) {
                $attachment->setProduct(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
