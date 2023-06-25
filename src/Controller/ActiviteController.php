<?php

namespace App\Controller;

use DateTime;
use App\Entity\Activite;
use App\Form\ActiviteFormType;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ActiviteController extends AbstractController
{
#[Route('/ajouter-une-activite', name: 'create_activite', methods: ['GET', 'POST'])]
    public function createActivite(ActiviteRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $activite= new Activite();

        $form = $this->createForm(ActiviteFormType::class, $activite)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

        
            $activite->setCreatedAt(new DateTime());
            $activite->setUpdatedAt(new DateTime());

            $entityManager->persist($activite);
            $entityManager->flush();

             /** @var UploadedFile $photo */
            $photo = $form->get('photo')->getData();

            //dd($photo);

            if ($photo) {
                $this->handleFile($photo, $activite, $slugger);
             } //end if($photo)

            $repository->save($activite, true);

            $this->addFlash('success', "L'activite bien été ajouté");
            return $this->redirectToRoute('show_dashboard');
        }
        
        
        return $this->render("admin/activite/show_activite.html.twig", [
            'form' => $form->createView(),
    
        
        ]);
    }
    private function handleFile(UploadedFile $photo, Activite $activite, SluggerInterface $slugger)
    {
        $extension = '.' . $photo->guessExtension();
        $safeFilename = $slugger->slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME));

        $newFilename = $safeFilename . '-' . uniqid() . $extension;

        try {
            $photo->move($this->getParameter('uploads_dir'), $newFilename);
            $activite->setPhoto($newFilename);
        } catch (FileException $exception) {
        }
    } // end handleFile()

    /*#[Route('/voir-mon-activite', name: 'show_activite', methods: ['GET', 'POST'])]
    public function showActivite(ActiviteRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activite();
        $services = $repository->findAll();
        

        return $this->render('services/show_service.html.twig', [
            'services' => $services,
        
        ]);
    }*/
    #[Route('/modifier-une-activite/{id}', name: 'update_activite', methods: ['GET', 'POST'])]
    public function updateActivity(Activite $activite, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ActiviteFormType::class, $activite)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

        
            $activite->setUpdatedAt(new DateTime());

            $entityManager->persist($activite);
            $entityManager->flush();

            $this->addFlash('success', "L'activite a bien été modifié");
            return $this->redirectToRoute('show_dashboard');
        }

        return $this->render("admin/activite/show_activite.html.twig", [
            'form' => $form->createView(),
            'activite' => $activite
        ]);
    }
    #[Route('/archiver-une-activite/{id}', name: 'soft_delete_activite', methods: ['GET'])]
    public function softDeleteActivite(Activite $activite, EntityManagerInterface $entityManager): RedirectResponse
    {
        $activite->setDeletedAt(new DateTime());

        $entityManager->persist($activite);
        $entityManager->flush();

        $this->addFlash('success', "L'activite a bien été archivé");
        return $this->redirectToRoute('show_dashboard');
    }
    #[Route('/restaurer-une-activite/{id}', name: 'restore_activite', methods: ['GET'])]
    public function restoreActivite(Activite $activite, EntityManagerInterface $entityManager): RedirectResponse
    {
        $activite->setDeletedAt(null);

        $entityManager->persist($activite);
        $entityManager->flush();

        $this->addFlash('success', "L'activite a bien été restauré");
        return $this->redirectToRoute('show_dashboard');
    }
    #[Route('/supprimer-une-activite/{id}', name: 'hard_delete_activite', methods: ['GET'])]
    public function hardDeleteA(Activite $activite, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($activite);
        $entityManager->flush();

        $this->addFlash('success', "L'activite bien été supprimé définitivement de la base");
        return $this->redirectToRoute('show_dashboard');
    }


}
