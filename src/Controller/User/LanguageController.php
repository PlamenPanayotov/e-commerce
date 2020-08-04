<?php

namespace App\Controller\User;

use App\Form\User\ChangeLocaleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
   /**
     * @Route("/changeLocal", name="change-local")
     */
    public function changeLocal(Request $request)
    {
        $form = $this->createForm(ChangeLocaleFormType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
			$locale = $form->getData()['locale'];
			$user->setLocale($locale);
			$em->persist($user);
            $em->flush();

            setcookie('_locale', $locale);
        
            $request->setLocale($locale);
            $request->getSession()->set('_locale', $locale);
            
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/locale.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
