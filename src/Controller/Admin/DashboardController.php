<?php

namespace App\Controller\Admin;

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardController extends AbstractController
{
    private $userService;
    private $security;
    private $userRepository;

    public function __construct(UserServiceInterface $userService,
                                UserRepository $userRepository,
                                Security $security)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->security = $security;


    }
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function adminDashboard(ProductRepository $productRepository)
    {

        $admin = $this->security->getUser();
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'Dashboard',
            'admin' => $admin,
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/users", name="admin_users")
     */
    public function allUsers()
    {
        $users = $this->userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);
    }
}
