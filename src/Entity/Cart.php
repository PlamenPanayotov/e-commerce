<?php

namespace App\Entity;

use App\Repository\CartRepository;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get one Cart has One Customer.
     */ 
    public function getUser(): ?User
    {
        return $this->user;
    }


    public function setUser(?User $user)
    {
        $this->user = $user;

        return $this;
    }
}
