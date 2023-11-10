<?php

namespace App\Controller;
use App\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/vote', name: 'app_vote')]
    public function index(): Response
    {   
        $data = $this->getDoctrine()->getRepository(Vote::class)->findAll();
        return $this->render('vote/index.html.twig', [
            'list' => $data
            
        ]);
    }
}
