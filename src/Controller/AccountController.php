<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/me', name: 'account_')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'infos')]
    public function index(): Response
    {
        return $this->render('account/infos.html.twig', [
            'controller_name' => 'AccountController',
            'accountTab' => 'infos'
        ]);
    }

    #[Route('/security', name: 'security')]
    public function security(): Response
    {
        return $this->render('account/security.html.twig', [
            'controller_name' => 'AccountController',
            'accountTab' => 'security'
        ]);
    }

    #[Route('/removal', name: 'removal')]
    public function removal(): Response
    {
        return $this->render('account/removal.html.twig', [
            'controller_name' => 'AccountController',
            'accountTab' => 'removal'
        ]);
    }
}
