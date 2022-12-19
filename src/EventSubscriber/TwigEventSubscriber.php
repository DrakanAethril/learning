<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Twig\Environment;
use App\Lms\Quotes\Quotes;

class TwigEventSubscriber implements EventSubscriberInterface
{

    public function __construct(Environment $twig, Quotes $quotes)
    {
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('randomQuote', Quotes::getRandomQuote());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
