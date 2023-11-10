<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Form\JoueurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(): Response
    {
       $data = $this->getDoctrine()->getRepository(Joueur::class)->findAll();
        return $this->render('joueur/index.html.twig', [
            'list' => $data
            
        ]);
    }
    /*public function listJoueur(): Response
    {
        $joueur = $this->getDoctrine()->getRepository(Joueur::class)
    ->createQueryBuilder('j')
    ->orderBy('j.nom', 'ASC')
    ->getQuery()
    ->getResult();
    $joueurs = $this->getDoctrine()->getRepository(Joueur::class)->findAll();

    foreach ($joueurs as $joueur) {
        $joueur->setNom(strtoupper($joueur->getNom()));
    }

        return $this->render('joueur/list.html.twig', [
            'joueurs' => $joueurs,
        ]);
    }*/
    public function showJoueurs():array
    {
        return $this->createQueryBuilder('j')
                    ->where('j.equipe = :val')
                    ->setParameter('val','Tunisie')
                    ->orderBy('j.nom', 'ASC')
                    ->SetMaxResults(10)
                    ->getQuery()
                    ->getResult();
                    return $this->render('joueur/.html.twig', ['formA' => $form]);
    }
    
    public function create(Request $request){
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            $this->addFlash('notice','Submitted Successfully!!');
    
            return $this->redirectToRoute('app_joueur');
            
        }
        return $this->render('joueur/create.html.twig',[
            'form' => $form->createView()]);
    
    }

    public function update( Request $request, $id){
        $joueur = $this->getDoctrine()->getRepository(Joueur::class)->find($id);
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form ->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();
            $this->addFlash('notice','Update Successfully!!');
    
            return $this->redirectToRoute('app_joueur');
            
        }
        return $this->render('joueur/update.html.twig',[
            'form' => $form->createView()]);
    
    }



    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository(Joueur::class)->find($id);
    
        if (!$data) {
            // Handle the case when the entity is not found, e.g., show an error message.
            $this->addFlash('error', 'Entity not found');
        } else {
            $em->remove($data);
            $em->flush();
            $this->addFlash('notice', 'Deleted Successfully!!');
        }
    
        return $this->redirectToRoute('app_joueur');
    }
}