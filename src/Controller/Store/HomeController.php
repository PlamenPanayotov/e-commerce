<?php

namespace App\Controller\Store;

use App\Form\User\ChangeLocaleFormType;
use App\Repository\ProductRepository;
use App\Service\Attachment\AttachmentServiceInterface;
use App\Service\Category\CategoryServiceInterface;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private object $userService;
    private object $categoryService;
    private object $attachmentService;

    public function __construct(UserServiceInterface $userService,
                                CategoryServiceInterface $categoryService,
                                AttachmentServiceInterface $attachmentService)
    {
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->attachmentService = $attachmentService;
    }
    /**
     * @Route("/", name="app_home")
     */
    public function index(ProductRepository $productRepository)
    {
        $user = $this->userService->currentUser();
        $products = $productRepository->findAll();
        $isVerified = $this->userService->isVerified();
        return $this->render('store/home/index.html.twig', [
            'isVerified' => $isVerified,
            'user' => $user,
            'products' => $products,
            'categories' => $this->categoryService->getAll(),
            'attachments' => $this->attachmentService->getAttachments()
        ]);
    }

    
}
