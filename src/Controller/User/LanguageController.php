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
     * @Route("/changeLocale{locale}", name="change-locale")
     */
    public function changeLocal(Request $request)
    {
        $locale = $request->get('locale');
        setcookie('_locale', $locale);
        $request->setLocale($locale);
        $request->getSession()->set('_locale', $locale);
        $url = $_SERVER['HTTP_REFERER'];
        return $this->redirect($url);
    }
}
