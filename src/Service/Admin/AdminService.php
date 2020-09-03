<?php
namespace App\Service\Admin;

use App\Entity\Admin;
use Symfony\Component\Security\Core\Security;

class AdminService implements AdminServiceInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function currentAdmin(): ?Admin
    {
        return $this->security->getUser();
    }
}