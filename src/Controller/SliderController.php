<?php

namespace App\Controller;

use DateTime;
use App\Entity\Slider;
use App\Form\SliderFormType;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class SliderController extends AbstractController
{
    #[Route('admin/voir-slider', name: 'app_slider_controler', methods: ['GET', 'POST'])]
    public function createSlider(SliderRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {

        $slider = new Slider();

        $form = $this->createForm(SliderFormType::class, $slider)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slider->setCreatedAt(new DateTime());
            $slider->setUpdatedAt(new DateTime());

            /** @var UploadedFile $photo */
            $photo = $form->get('photo')->getData();

            //dd($photo);

            if ($photo) {
                $this->handleFile($photo, $slider, $slugger);
            } //end if($photo)

            $repository->save($slider, true);

            $this->addFlash('success', "Le slider a bien été créé avec succès !");
            return $this->redirectToRoute('app_slider_controler');
        } // end if($form)
        $sliders = $entityManager->getRepository(Slider::class)->findBy(['deletedAt' => null]);

        return $this->render('admin/slider/show_slider.html.twig', [
            'form' => $form->createView(),
            'sliders' => $sliders
        ]);
    } // end update()
    #[Route('/supprimer-image/{id}', name: 'soft_delete_slider', methods: ['GET'])]
    public function softDeleteSlider(Slider $slider, SliderRepository $repository): Response
    {
        $slider->setDeletedAt(new DateTime());

        $repository->save($slider, true);

        $this->addFlash('success', "Le slider a bien été archivé avec succès !");
        return $this->redirectToRoute('app_slider_controler');
    } // end softDelete()

    #[Route('/supprimer-image/{id}', name: 'hard_delete_slider', methods: ['GET'])]
    public function hardDeleteSlider(Slider $slider, SliderRepository $repository): Response
    {
        $photo = $slider->getPhoto();

        $repository->remove($slider, true);

        unlink($this->getParameter('uploads_dir') . DIRECTORY_SEPARATOR . $photo);

        $this->addFlash('success', "Le slider a bien été supprimé définitivement de la base.");
        return $this->redirectToRoute('app_slider_controler');
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

    private function handleFile(UploadedFile $photo, Slider $slider, SluggerInterface $slugger)
    {
        $extension = '.' . $photo->guessExtension();
        $safeFilename = $slugger->slug(pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME));

        $newFilename = $safeFilename . '-' . uniqid() . $extension;

        try {
            $photo->move($this->getParameter('uploads_dir'), $newFilename);
            $slider->setPhoto($newFilename);
        } catch (FileException $exception) {
        }
    } // end handleFile()

    #[Route('/modifier-image/{id}', name: 'update_slider', methods: ['GET', 'POST'])]
    public function updateSlider(Slider $slider, SliderRepository $repository, Request $request, SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {

        $currentPhoto = $slider->getPhoto();

        $form = $this->createForm(SliderFormType::class, $slider, ['photo' => $currentPhoto])
            ->handlerequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slider->setUpdatedAt(new DateTime());

            $newPhoto = $form->get('photo')->getData();

            if ($newPhoto) {
                $this->handleFile($newPhoto, $slider, $slugger);
            } else {
                $slider->setPhoto($currentPhoto);
            }

            $repository->save($slider, true);

            $this->addFlash('success', "Le slider a bien été modifié avec succès !");
            return $this->redirectToRoute('app_slider_controler');
        }

        $sliders = $entityManager->getRepository(Slider::class)->findBy(['deletedAt' => null]);

        return $this->render('admin/slider/show_slider.html.twig', [
            'form' => $form->createView(),
            'sliders' => $sliders,
            'slider' => $slider
        ]);
    }
}
