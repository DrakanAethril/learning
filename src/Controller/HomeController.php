<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function indexNoLocale(): Response
    {
        return $this->redirectToRoute('home_lg', ['_locale' => 'fr']);
    }

    #[Route('/{_locale<%app.supported_locales%>}/', name: 'home_lg')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
