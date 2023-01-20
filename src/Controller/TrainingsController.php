<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Repository\TrainingsRepository;
use App\Entity\Trainings;
use App\Entity\Resource;
use App\Repository\ResourceRepository;

class TrainingsController extends AbstractController
{
    #[Route('/lms/trainings', name: 'lms_trainings')]
    public function index(TrainingsRepository $trainingsRepo): Response
    {
        $user = $this->getUser();
        $availableTrainings = $trainingsRepo->getAvailableTrainingsForUser($user);
        var_dump($availableTrainings);
        exit;
        return $this->render('trainings/index.html.twig', [
            'controller_name' => 'TrainingsController',
        ]);
    }

    #[Route('trainings/edit/{id<\d+>?0}', name: 'trainings_create')]
    public function edit(int $id, Request $request, TrainingsRepository $trainingRepo, ResourceRepository $resourceRep, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        $successEdit = false;
        $errors = [];
        $user = $this->getUser();
        if(!empty($id)) {
            $create = false;
            $training = $trainingRepo->findOneBy(['author' => $user->getId(), 'id' => $id]);
            if(empty($training)) {
                // should not do that
                return $this->redirectToRoute('resources_mine'); // on purpose redirect ot resources list
            }
        } else {
            $create = true;
            // check if we have the base resource
            $resourceId = $request->get('idR');
            $resource = $resourceRep->findOneBy(['author' => $user->getId(), 'id' => $resourceId]);
            if(empty($resource)) {
                return $this->redirectToRoute('resources_mine'); // on purpose redirect ot resources list
            }
            $training = new Trainings();
            $training->setResource($resource);
        }

        
        return $this->render('trainings/create.html.twig', [
            'training' => $training,
            'creation' => $create
        ]);

    }
}
