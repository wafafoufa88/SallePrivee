<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Activite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $activites =[
            'CARDIO',
            'FITNESS POUR MAIGRIR',
            'RENFORCEMENT MUSCULAIRE',
            'YOGA ET RELAXATION',

        ];

        foreach($activites as $titre) {
            $activite = new Activite();

            $activite->setTitre($titre);

            $activite->setAlias($this->slugger->slug($titre));

            $activite->setCreatedAt(new DateTime());
            $activite->setUpdatedAt(new DateTime());
            
            $manager->persist($activite);
        }

        $manager->flush();
    }
}
