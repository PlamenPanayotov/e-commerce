<?php

namespace App\Controller;

use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @Route("/profile", name="user_profile")
     */
    public function profile()
    {
        $user = $this->userService->currentUser();
        $isVerified = $user->isVerified();
        if(!$user) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'isVerified' => $isVerified
        ]);
    }
}
