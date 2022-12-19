<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/structure', name: 'structure')]
    public function structure(): Response
    {
        return $this->render('account/structure.html.twig', [
            'controller_name' => 'AccountController',
            'accountTab' => 'structure'
        ]);
    }

    #[Route('/security', name: 'security')]
    public function security(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        $submittedToken = $request->request->get('_csrf_token');
        $validToken = false;
        $errors = [];
        if($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('change_pwd', $submittedToken)) {
                $validToken = true;
            }
            if($form->isValid() && $validToken) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
            } else {
                $errors = $form->getErrors(true);
            }
        }
       
        return $this->render('account/security.html.twig', [
            'controller_name' => 'AccountController',
            'changePasswordForm' => $form->createView(),
            'accountTab' => 'security',
            'formErrors' => $errors
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
