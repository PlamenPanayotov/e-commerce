<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\User\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginAuthenticator;
use App\Service\User\UserServiceInterface;
use App\Service\Email\EmailConfirmationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;
    private $emailConfirmationService;
    private $userService;

    public function __construct(EmailVerifier $emailVerifier, 
                                EmailConfirmationServiceInterface $emailConfirmationService,
                                UserServiceInterface $userService)
    {
        $this->emailVerifier = $emailVerifier;
        $this->emailConfirmationService = $emailConfirmationService;
        $this->userService = $userService;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                $this->emailConfirmationService->emailContent($user)
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('store/user/user_register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('user_profile');
    }

    /**
     * @Route("/verify/new_email", name="app_verify_new_email")
     */
    public function emailVerifier()
    {
        $user = $this->userService->currentUser();
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                $this->emailConfirmationService->emailContent($user));

        $this->addFlash('success', 'Email was sent');

        return $this->redirectToRoute('user_profile');
    }
}
