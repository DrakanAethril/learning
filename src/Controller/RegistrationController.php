<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use App\Repository\RegisterKeyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager, RegisterKeyRepository $registerKeyRepo): Response
    {
        $user = new User();
        $errors = [];
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $errorStructureKey = '';
        $validStructureKey = false;
        if($form->isSubmitted()) {
            $currentStructureKey = $form->get('registerKey')->getData();
            $registerKey = $registerKeyRepo->findOneBy(['key_code' => $currentStructureKey]);
            if(!empty($registerKey) && !empty($registerKey->getId()) ) {
                $validStructureKey = true;
            } else {
                $errorStructureKey = 'Invalid structure key';
            }
        }

        if ($form->isSubmitted() && $form->isValid() && $validStructureKey) {
            $user->setRoles(['ROLE_STUDENT']);
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if(!empty($registerKey->getStructures())) {
                foreach($registerKey->getStructures() as $structure) {
                    $user->addStructure($structure);
                }
            }
            if(!empty($registerKey->getCohorts())) {
                foreach($registerKey->getCohorts() as $cohort) {
                    $user->addCohort($cohort);
                }
            }
            

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        } else {
            $errors = $form->getErrors(true);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'formErrors' => $errors,
            'errorStructureKey' => $errorStructureKey
        ]);
    }
}
