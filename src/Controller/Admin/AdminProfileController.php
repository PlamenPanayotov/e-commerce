<?php

namespace App\Controller\Admin;

use App\Service\Admin\AdminServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminProfileController extends AbstractController
{
    private $adminService;

    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * @Route("/admin/profile", name="admin_profile")
     */
    public function index()
    {
        return $this->render('admin/admin_profile/index.html.twig', [
            'controller_name' => 'AdminProfileController',
            'admin' => $this->adminService->currentAdmin()
        ]);
    }
}
