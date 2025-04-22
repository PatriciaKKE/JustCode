<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $cv;

    #[ORM\Column(type: 'string', length: 255)]
    private $lettreMotivation;

    #[ORM\Column(type: 'string', length: 20)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[ORM\ManyToOne(targetEntity: Offre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $offre;

    #[ORM\Column(type: 'string', length: 50)]
    private $etat;

    // Getters and Setters...
}