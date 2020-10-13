<?php
namespace App\Subscribers;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession()) {
            return;
        }

        $locale = $request->getSession()->get('_locale');
        
        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            if (array_key_exists('_locale', $_COOKIE)) {
                $cookie = $_COOKIE['_locale'];
                $request->setLocale($cookie);

                if ($cookie != 'en_US' && $cookie != 'bg_BG') {
                    $request->setLocale('bg_BG');
                }
            } else {
                $request->setLocale('bg_BG');
            }
        }
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 17]],
        ];
    }
}