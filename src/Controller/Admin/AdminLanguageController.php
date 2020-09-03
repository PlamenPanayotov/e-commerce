<?php

namespace App\Controller\Admin;

use App\Form\User\ChangeLocaleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminLanguageController extends AbstractController
{
   /**
     * @Route("/admin/changeLocale", name="admin-change-locale")
     */
    public function changeLocal(Request $request)
    {
        $form = $this->createForm(ChangeLocaleFormType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {

			$locale = $form->getData()['locale'];

            setcookie('_locale', $locale);
        
            $request->setLocale($locale);
            $request->getSession()->set('_locale', $locale);
            
            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('home/locale.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
