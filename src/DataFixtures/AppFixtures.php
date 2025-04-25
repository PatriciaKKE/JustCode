<?php

namespace App\DataFixtures;

use App\Entity\Offre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de la première offre : Développeur Symfony
        $offre = new Offre();
        $offre->setTitre('Développeur Symfony');
        $offre->setDescription('Nous recherchons un développeur Symfony expérimenté pour rejoindre notre équipe.');
        $offre->setDatePublication(new \DateTime());
        $offre->setStatut('Publié'); // Ajout du statut "Publié"
        $manager->persist($offre);

        // Création de la deuxième offre : Chef de Projet
        $offre2 = new Offre();
        $offre2->setTitre('Chef de Projet');
        $offre2->setDescription('Nous recherchons un chef de projet expérimenté pour rejoindre notre équipe.');
        $offre2->setDatePublication(new \DateTime());
        $offre2->setStatut('Brouillon'); // Ajout du statut "Brouillon"
        $manager->persist($offre2);

        // Flusher les données dans la base de données
        $manager->flush();
    }
}