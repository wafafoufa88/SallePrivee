<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Contact;
use App\Entity\Abonnement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
         // Contact
         for ($i = 0; $i < 5; $i++) {
            $contact = new Contact();
            $contact->setNom($this->faker->firstName())
            
                ->setPrenom($this->faker->lastName())

                ->setEmail($this->faker->email())
                ->setSujet('Demande n°' . ($i + 1))
                ->setMessage($this->faker->text());

                $contact->setCreatedAt(new DateTime());
                $contact->setUpdatedAt(new DateTime());

            $manager->persist($contact);
        }

        $manager->flush();

    }
}
