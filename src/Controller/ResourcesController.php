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
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function edit(int $id, Request $request, ResourceRepository $resourceRepo, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
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
        
        if(empty($_POST)) {
            $resourceContent = $resource->getContent();
            $contentErrors = [];
        } else {
            switch($resource->getType()) {
                default:
                    $submittedContent = $this->buildQuizzContentArray($translator);
            }
            $resourceContent = $submittedContent['content'];
            $contentErrors = $submittedContent['error'];
            $resource->setContent($resourceContent);
        }

        if ($form->isSubmitted() && $form->isValid() && empty($contentErrors)) {
                   
            if(empty($resource->getDateCreate())) $resource->setDateCreate(new DateTime());
            if(empty($resource->getAuthor())) $resource->setAuthor($user);

            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute('resources_create', ['id' => $resource->getId()]);

        }
        
        return $this->render('resources/create.html.twig', [
            'resourceForm' => $form->createView(),
            'quizzContent' => $resourceContent,
            'contentError' => $contentErrors
        ]);
    }

    private function buildQuizzContentArray(TranslatorInterface $translator) : array {
        $quizzContent = ['content' => [], 'error' => []];
        if(!empty($_POST) && !empty($_POST['quizz_q_nb']) && intval($_POST['quizz_q_nb']) > 0) {
            $quizzContent['content']['max_q_id'] = intval($_POST['quizz_q_nb']);
            for($i=1; $i<=$_POST['quizz_q_nb']; $i++) {
                if(!isset($_POST['q_'.$i])) continue; //deleted question
                
                // Question text
                if( empty( $_POST['q_'.$i] ) ) { 
                    $quizzContent['error'][] = $translator->trans('Question of item %idQuizzQuestion% needs a text', ['%idQuizzQuestion%' => $i]);
                } else {
                    $quizzContent['content']['q'][$i]['q'] = $_POST['q_'.$i];
                }
                
                // Question explanation
                if(!empty($_POST['q_'.$i.'_e'])) $quizzContent['content']['q'][$i]['e'] = $_POST['q_'.$i.'_e'];
                
                //Questions answers
                if(!empty($_POST['quizz_q_'.$i.'_a_nb']) && intval($_POST['quizz_q_'.$i.'_a_nb']) > 0) {
                    if($_POST['quizz_q_'.$i.'_a_nb'] < 2) {
                        $quizzContent['error'][] = $translator->trans('Question %idQuizzQuestion% needs at least 2 answers', ['%idQuizzQuestion%' => $i]);
                    }
                    $quizzContent['content']['q'][$i]['max_a_id'] = intval($_POST['quizz_q_'.$i.'_a_nb']);
                    for($j=1; $j<=$_POST['quizz_q_'.$i.'_a_nb']; $j++) {
                        if(!isset($_POST['q_'.$i.'_a_'.$j.'_t'])) continue; //deleted answer;

                        if(empty($_POST['q_'.$i.'_a_'.$j.'_t'])) {
                            $quizzContent['error'][] = $translator->trans('All answers of item %idQuizzQuestion% needs text', ['%idQ%' => $i]);
                        } else {
                            $quizzContent['content']['q'][$i]['a'][$j]['t'] = $_POST['q_'.$i.'_a_'.$j.'_t'];
                        }
                        if(!empty($_POST['q_'.$i.'_a_'.$j.'_v'])) $quizzContent['content']['q'][$i]['a'][$j]['v'] = true;

                    }
                }
            }
        } else {
            $quizzContent['error'][] = $translator->trans('Invalid params provided');
        }

        if(!empty($quizzContent['error'])) {
            $quizzContent['error'] = array_unique($quizzContent['error']);
        }
    
        return $quizzContent;
    }

}
