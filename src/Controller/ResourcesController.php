<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Resource;
use App\Repository\ResourceRepository;
use App\Form\ResourceFormType;
use DateTime;

#[Route('/resources', name: 'resources_')]
class ResourcesController extends AbstractController
{
    #[Route('/mine', name: 'mine')]
    public function index(ResourceRepository $resourceRepo): Response
    {
        $user = $this->getUser();
        return $this->render('resources/index.html.twig', [
            'resources' => $resourceRepo->findBy(['author' => $user->getId()]),
        ]);
    }

    #[Route('/edit/{id<\d+>?0}', name: 'create')]
    public function edit(int $id, Request $request, ResourceRepository $resourceRepo, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if(!empty($id)) {
            $resource = $resourceRepo->findBy(['author' => $user->getId(), 'id' => $id]);
            if(empty($resource)) {
                // should not do that
                return $this->redirectToRoute('resources_mine');
            } else {
                $resource = $resource[0];
            }
        } else {
            $resource = new Resource();
        }

        $form = $this->createForm(ResourceFormType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(empty($resource->getDateCreate())) $resource->setDateCreate(new DateTime());
            if(empty($resource->getAuthor())) $resource->setAuthor($user);
            $resource->setContent([]);

            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute('resources_create', ['id' => $resource->getId()]);

        }
        
        return $this->render('resources/create.html.twig', [
            'resourceForm' => $form->createView()
        ]);
    }
}


