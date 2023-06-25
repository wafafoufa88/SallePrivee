<?php

namespace App\Controller;

use DateTime;
use App\Entity\Abonnement;
use App\Form\AbonnementFormType;
use App\Repository\AbonnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AbonnementController extends AbstractController
{
    #[Route('/ajouter-un-abonnement', name: 'create_abonnement', methods: ['GET', 'POST'])]
    public function createActivite(AbonnementRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
        $abonnement= new Abonnement();

        $form = $this->createForm(AbonnementFormType::class, $abonnement)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

        
            $abonnement->setCreatedAt(new DateTime());
            $abonnement->setUpdatedAt(new DateTime());

            $entityManager->persist($abonnement);
            $entityManager->flush();

             /** @var UploadedFile $photo */
            $photo = $form->get('photo')->getData();

            //dd($photo);

            if ($photo) {
                $this->handleFile($photo, $abonnement, $slugger);
             } //end if($photo)

            $repository->save($abonnement, true);

            $this->addFlash('success', "L'abonnement bien été ajouté");
            return $this->redirectToRoute('show_dashboard');
        }

        return $this->render("admin/abonnement/show_abonnement.html.twig", [
            'form' => $form->createView()
        ]);
    }
    private function handleFile(UploadedFile $photo, Abonnement $activite, SluggerInterface $slugger)
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


    #[Route('/modifier-un-abonnement/{id}', name: 'update_abonnement', methods: ['GET', 'POST'])]
    public function updateActivity(Abonnement $abonnement, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(AbonnementFormType::class, $abonnement)
            ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

        
            $abonnement->setUpdatedAt(new DateTime());

            $entityManager->persist($abonnement);
            $entityManager->flush();

            $this->addFlash('success', "L'abonnement a bien été modifié");
            return $this->redirectToRoute('show_dashboard');
        }

        return $this->render("admin/abonnement/show_abonnement.html.twig", [
            'form' => $form->createView(),
            'abonnement' => $abonnement
        ]);
    }
    #[Route('/archiver-un-abonnement/{id}', name: 'soft_delete_abonnement', methods: ['GET'])]
    public function softDeleteActivite(Abonnement $abonnement, EntityManagerInterface $entityManager): RedirectResponse
    {
        $abonnement->setDeletedAt(new DateTime());

        $entityManager->persist($abonnement);
        $entityManager->flush();

        $this->addFlash('success', "L'abonnement a bien été archivé");
        return $this->redirectToRoute('show_dashboard');
    }
    #[Route('/restaurer-un-abonnement/{id}', name: 'restore_abonnement', methods: ['GET'])]
    public function restoreActivite(Abonnement $abonnement, EntityManagerInterface $entityManager): RedirectResponse
    {
        $abonnement->setDeletedAt(null);

        $entityManager->persist($abonnement);
        $entityManager->flush();

        $this->addFlash('success', "L'abonnement a bien été restauré");
        return $this->redirectToRoute('show_dashboard');
    }
    #[Route('/supprimer-un-abonnement/{id}', name: 'hard_delete_abonnement', methods: ['GET'])]
    public function hardDeleteA(Abonnement $abonnement , EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($abonnement );
        $entityManager->flush();

        $this->addFlash('success', "L'abonnement  bien été supprimé définitivement de la base");
        return $this->redirectToRoute('show_dashboard');
    }


}
