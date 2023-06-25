<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\SliderRepository;
use App\Repository\ActiviteRepository;
use App\Repository\AbonnementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'show_home',methods:['GET'])]
    public function showHome(SliderRepository $sliderRepository, AbonnementRepository $abonnementrepository): Response
    {
        $sliders1 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'img salle1'
        ]);
        $sliders2 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'img salle2'
        ]);
        $sliders3 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'img salle3'
        ]);
        $sliders4 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'img salle4'
        ]);
        $sliders5 = $sliderRepository->findOneBy([
            'deletedAt' => null,
            'ordre' => 'img salle5'
        ]);
        $abonnements = $abonnementrepository->findAll(['deletedAt => null']);

        return $this->render('/default/show_home.html.twig', [
            'sliders1' => $sliders1,
            'sliders2' => $sliders2,
            'sliders3' => $sliders3,
            'sliders4' => $sliders4,
            'sliders5' => $sliders5,
            'abonnements'=>$abonnements


        ]); 
    }
<<<<<<< Updated upstream
    #[Route('/contact/contactez-nous', name: 'show_contact', methods: ['GET', 'POST'])]
=======



//////////Qui Sommes-nous?//////////

    #[Route('/salle/qui-sommes-nous', name: 'presentation_salle', methods: ['GET'])]
    public function salleQuiSommesNous(): Response
    {
        return $this->render('salle/presentation_salle.html.twig');
    }


      //////////Accès//////////

    #[Route('/salle/accedez-a-notre-salle', name: 'acces_salle', methods: ['GET'])]
    public function salleAcces(): Response
    {

        return $this->render('salle/acces_salle.html.twig');
    }
     //////////contactez-nous?//////////


    #[Route('/salle/contactez-nous', name: 'show_contact', methods: ['GET', 'POST'])]
>>>>>>> Stashed changes
    public function Contact(): Response
    {

        $contact = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);

        $this->addFlash('success', "Votre message a bien été envoyé, nous reviendrons vers vous dans les plus brefs délais.");


        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    } 
     //////////Nos services//////////

    #[Route('/salle/nos-service', name: 'show_service', methods: ['GET'])]
    public function Service(ActiviteRepository $activiterepository): Response
    {
        $activites = $activiterepository->findAll(['deletedAt => null']);
        return $this->render('pages/services/show_service.html.twig',[
            
            'activites'=>$activites
        ]);
    }


    #[Route('/salle/actualite', name: 'show_actualite', methods: ['GET'])]
    public function Actualite(): Response
    {

        return $this->render('pages/actualites/show_actualite.html.twig');
    }
    #[Route('/salle/article1', name: 'article1', methods: ['GET'])]
    public function Article1(): Response
    {

        return $this->render('pages/actualites/article1.html.twig');
    }
    #[Route('/salle/article2', name: 'article2', methods: ['GET'])]
    public function Article2(): Response
    {

        return $this->render('pages/actualites/article2.html.twig');
    }
    #[Route('/salle/article3', name: 'article3', methods: ['GET'])]
    public function Article3(): Response
    {

        return $this->render('pages/actualites/article3.html.twig');
    }
    #[Route('/salle/article4', name: 'article4', methods: ['GET'])]
    public function Article4(): Response
    {

        return $this->render('pages/actualites/article4.html.twig');
    }
    #[Route('/mentions-legales/mention', name: 'mention', methods: ['GET'])]
    public function Mention(): Response
    {

        return $this->render('pages/mentions-legales/mention.html.twig');
    }
    #[Route('/salle/concept', name: 'concept', methods: ['GET'])]
    public function Concept(): Response
    {

        return $this->render('salle/concept.html.twig');
    }
    #[Route('/salle/Apropos', name: 'apropos', methods: ['GET'])]
    public function Apropos(): Response
    {

        return $this->render('salle/Apropos.html.twig');
    }
    #[Route('/Confidentialite', name: 'Confidentialite', methods: ['GET'])]
    public function Confidentialite(): Response
    {

        return $this->render('pages/Confidentialite/Confidentialite.html.twig');
    }
    #[Route('/Carte-abonnement', name: 'Carte-abonnement', methods: ['GET'])]
    public function Carte(): Response
    {

        return $this->render('pages/Carte-abonnement/carte.html.twig');
    }
    #[Route('/Carte1-abonnement', name: 'Carte1-abonnement', methods: ['GET'])]
    public function Carte1(): Response
    {

        return $this->render('pages/Carte-abonnement/carte1.html.twig');
    }
}
