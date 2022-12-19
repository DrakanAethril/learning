<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserInfoUpdateFormType;
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
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserInfoUpdateFormType::class, $user);
        $form->handleRequest($request);

        $submittedToken = $request->request->get('_csrf_token');
        $validToken = false;
        $errors = [];
        $success = false;
        if($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('user_upd_infos', $submittedToken)) {
                $validToken = true;
            }
            if($form->isValid() && $validToken) {
                $entityManager->persist($user);
                $entityManager->flush();
                $success = true;
            } else {
                $errors = $form->getErrors(true);
            }
        }
        return $this->render('account/infos.html.twig', [
            'userUpdateInfosForm' => $form->createView(),
            'accountTab' => 'infos',
            'formErrors' => $errors,
            'formSuccess' => $success
        ]);
    }

    #[Route('/structure', name: 'structure')]
    public function structure(): Response
    {
        return $this->render('account/structure.html.twig', [
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
        $success = false;
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
                $success = true;
            } else {
                $errors = $form->getErrors(true);
            }
        }
       
        return $this->render('account/security.html.twig', [
            'changePasswordForm' => $form->createView(),
            'accountTab' => 'security',
            'formErrors' => $errors,
            'formSuccess' => $success
        ]);
    }

    #[Route('/removal', name: 'removal')]
    public function removal(): Response
    {
        return $this->render('account/removal.html.twig', [
            'accountTab' => 'removal'
        ]);
    }
}
