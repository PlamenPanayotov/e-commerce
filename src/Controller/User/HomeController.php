<?php

namespace App\Controller\User;

use App\Form\User\ChangeLocaleFormType;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private object $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index()
    {
        $isVerified = $this->userService->isVerified();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'isVerified' => $isVerified
        ]);
    }

    
}
