<?php

namespace App\Entity;

use App\Repository\ProductOptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductOptionRepository::class)
 */
class ProductOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $priceIncrement;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="product_options")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceIncrement(): ?float
    {
        return $this->priceIncrement;
    }

    public function setPriceIncrement(float $priceIncrement): self
    {
        $this->priceIncrement = $priceIncrement;

        return $this;
    }

 
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    
}
