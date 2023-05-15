<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'show_home',methods:['GET'])]
    public function showHome(): Response
    {
        return $this->render('default/show_home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
    #[Route('/contact/contactez-nous', name: 'show_contact', methods: ['GET', 'POST'])]
    public function Contact(): Response
    {

        $contact = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);

        $this->addFlash('success', "Votre message a bien été envoyé, nous reviendrons vers vous dans les plus brefs délais.");


        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView()
        ]);
    } 
}
