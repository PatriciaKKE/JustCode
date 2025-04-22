<?php
//Rôle :Cette classe représente une offre d'emploi dans votre projet.

//Elle sert à stocker les informations liées à une offre d'emploi (titre, date de publication, statut, etc.) dans la base de données.
//C'est une entité Doctrine, ce qui signifie qu'elle sera automatiquement liée à une table dans la base de données grâce au mapping ORM.
//Détails des propriétés :

//id : Identifiant unique pour chaque offre. Doctrine le génère automatiquement.
//titre : Le titre du poste, comme "Développeur Symfony", "Assistant RH", etc.
//datePublication : La date à laquelle l'offre a été publiée.
//candidatures : Le nombre de candidatures reçues pour cette offre (initialisé à 0).
//statut : Le statut actuel de l'offre, par exemple "Publié", "Brouillon", ou "Clôturé".
//Pourquoi c'est important ?

//Cette entité permet de gérer les offres d'emploi dans votre tableau de bord RH. Elle est la base pour afficher, modifier, ou archiver les offres.
//2. Entité Candidature
//Fichier : src/Entity/Candidature.php

//Rôle :

//Cette classe représente une candidature soumise par un visiteur pour un poste.
//Elle stocke les informations d'un candidat (nom, prénom, CV, lettre de motivation, etc.) ainsi que son lien avec une offre d'emploi.
//Détails des propriétés :
//
//id : Identifiant unique pour chaque candidature.
//nom et prenom : Le nom et le prénom du candidat.
//email : L'adresse e-mail du candidat.
//cv et lettreMotivation : Les chemins des fichiers uploadés par le candidat (CV et lettre de motivation).
//telephone et adresse : Les informations de contact du candidat.
//offre : Relation avec l'entité Offre. Cela signifie qu'une candidature est toujours liée à une offre spécifique.
//etat : Le statut de la candidature (par exemple "reçue", "en cours", "entretien", "refusée").
//Pourquoi c'est important ?

//Cette entité permet de gérer les candidatures associées à une offre. Par exemple, vous pouvez afficher toutes les candidatures d'une offre et suivre leur progression dans le processus de recrutement.






namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'datetime')]
    private $datePublication;

    #[ORM\Column(type: 'integer')]
    private $candidatures = 0;

    #[ORM\Column(type: 'string', length: 50)]
    private $statut;

    // Getters and Setters...
}