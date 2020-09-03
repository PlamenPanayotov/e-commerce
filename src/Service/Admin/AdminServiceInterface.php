<?php
namespace App\Service\Admin;

use App\Entity\Admin;

interface AdminServiceInterface
{
    public function currentAdmin(): ?Admin;
}