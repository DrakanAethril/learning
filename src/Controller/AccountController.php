<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Form\UserInfoUpdateFormType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function structure(Request $request, StructureRepository $structureRepository, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $user = $this->getUser();
        $errors = [];
        if($request->isMethod('POST') && !empty($request->request->get('structure')) ) {
            $structureIdSaved = $request->request->get('structure');
            $structureSaved = $structureRepository->findOneBy(['id' => $structureIdSaved]);
            $cohortsSaved = $request->request->all()['cohort-'.$structureIdSaved] ?? [];
            // does user have the structure ?
            if(!$user->getStructures()->contains($structureSaved)) {
                $errors[] = $translator->trans('account-errors.invalid-structure');
            } else {
                if(empty($cohortsSaved)) {
                    $errors[] = $translator->trans('account-errors.empty-cohorts');
                } else {
                    // get structure potential cohorts
                    $potentialCohorts = $structureSaved->getCohorts();
                    if(!empty($potentialCohorts)) {
                        foreach($potentialCohorts as $currentCohort) {
                            if(in_array($currentCohort->getId(), $cohortsSaved)) { //Entity is already testing if it's conatined or not, no need to recheck here.
                                $user->addCohort($currentCohort);
                            } else {
                                $user->removeCohort($currentCohort);
                            }
                        }
                    }
                    $entityManager->persist($user);
                    $entityManager->flush();
                }
            }
        }

        return $this->render('account/structure.html.twig', [
            'formErrors' => $errors, 
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
