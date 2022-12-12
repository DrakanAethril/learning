<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Resource;
use App\Repository\ResourceRepository;
use App\Entity\User;

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
    public function edit(int $id, ResourceRepository $resourceRepo): Response
    {
        $user = $this->getUser();
        if(!empty($id)) {
            $resource = $resourceRepo->findBy(['author' => $user->getId(), 'id' => $id]);
            if(empty($resource)) {
                // should not do that
                return $this->redirectToRoute('resources_mine');
            }
        } else {
            $resource = new Resource();
        }
        
        return $this->render('resources/create.html.twig', [
            'resource' => $resource
        ]);
    }
}


