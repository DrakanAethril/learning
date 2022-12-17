<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/me', name: 'account_')]
class AccountController extends AbstractController
{
    #[Route('/', name: 'account_infos')]
    public function index(): Response
    {
        return $this->render('account/infos.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
