<?php

namespace App\Controller;

use DateTime;


use App\Entity\Commentary;
use App\Form\CommentaryFormType;
use App\Repository\CommentaryRepository;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    
    #[Route('/ajouter-un-commentaire', name: 'create_commentaire', methods: ['GET', 'POST'])]
    public function createCommentaire(Request $request, CommentaryRepository $repo): Response
    {

        $commentary = new Commentary();

        $form = $this->createForm(CommentaryFormType::class, $commentary)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $commentary->setCreatedAt(new DateTime());
            $commentary->setUpdatedAt(new DateTime());

            $repo->save($commentary, true);

            $this->addFlash('success', "Nous vous remercions pour votre avis !");

            return $this->redirectToRoute('create_commentaire');
        }

    

        $salle = $repo->findAll('salle');
        
        $salle = $repo->findBy([
            'deletedAt' => null,
            //'category' => $salle
        ]);

        return $this->render('/commentaire/show_commantaire.html.twig', [
            'form' => $form,
        
            'salle' => $salle,
            'commentary' => $commentary,


        ]);
    }


} // end class

