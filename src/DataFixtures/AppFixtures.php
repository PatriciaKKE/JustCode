<?php

namespace App\DataFixtures;

use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $offre = new Offre();
        $offre->setTitre('Développeur Symfony');
        $offre->setDescription('Nous recherchons un développeur Symfony expérimenté pour rejoindre notre équipe.');
        $offre->setDatePublication(new \DateTime());
        $manager->persist($offre);

        $offre2 = new Offre();
        $offre2->setTitre('Chef de Projet');
        $offre2->setDescription('Nous recherchons un chef de projet expérimenté pour rejoindre notre équipe.');
        $offre2->setDatePublication(new \DateTime());
        $manager->persist($offre2);

        $manager->flush();
    }
}
