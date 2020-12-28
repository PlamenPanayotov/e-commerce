<?php

namespace App\Controller\Store;

use App\Form\User\ChangeLocaleFormType;
use App\Repository\ProductRepository;
use App\Service\Attachment\AttachmentServiceInterface;
use App\Service\User\UserServiceInterface;
use App\Service\Category\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private object $userService;
    private object $attachmentService;
    private object $categoryService;

    public function __construct(UserServiceInterface $userService,
                                AttachmentServiceInterface $attachmentService,
                                CategoryServiceInterface $categoryService)
    {
        $this->userService = $userService;
        $this->attachmentService = $attachmentService;
        $this->categoryService = $categoryService;
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
            'categories' => $this->categoryService->getSortedCategories(),
            'attachments' => $this->attachmentService->getAttachments()
        ]);
    }

    
}
