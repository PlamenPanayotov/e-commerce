<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Form\EditPassword;


class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @Route("/user/profile", name="user_profile")
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

    /**
     * @Route("/user/edit/profile", name="user_edit_profile")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->userService->currentUser();
        $isVerified = $user->isVerified();
        
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('user/edit.html.twig', [
            'editUserForm' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/user/edit/password", name="user_edit_password")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->userService->currentUser();
        
        $form = $this->createForm(EditPassword::class, $user);
        $old_pwd = $request->get('old_password'); 
        $new_pwd = $request->get('new_password'); 
        $new_pwd_confirm = $request->get('new_password_confirm');
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);
            if($checkPass === true) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('user_profile');
            } else {
                $this->addFlash('error', 'Wrong old password');
                return $this->redirectToRoute('user_edit_password');
            }
        }
        return $this->render('user/edit_password.html.twig', [
            'editPasswordForm' => $form->createView(),
        ]);
    }
}
