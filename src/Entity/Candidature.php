<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    // 1. Liste des statuts possibles
    public const STATUSES = ['reçue', 'en cours', 'entretien', 'refusée'];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom est requis.")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prénom est requis.")]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L’email est requis.")]
    #[Assert\Email(message: "L’email '{{ value }}' n’est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCandidature = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['application/pdf'],
        mimeTypesMessage: 'Le CV doit être un fichier PDF de maximum 2 Mo.'
    )]
    private ?string $cv = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['application/pdf'],
        mimeTypesMessage: 'La lettre de motivation doit être un fichier PDF de maximum 2 Mo.'
    )]
    private ?string $lettreMotivation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Choice(
        choices: self::STATUSES,
        message: 'Le statut doit être l’un des suivants : {{ choices }}.'
    )]
    private ?string $status = 'reçue';

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $noteInterne = null;

    #[ORM\ManyToOne(targetEntity: Offre::class, inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: true)]  // nullable pour candidatures anonymes si besoin
    private ?User $user = null;

    public function __construct()
    {
        $this->dateCandidature = new \DateTime();
        $this->status = 'reçue';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->dateCandidature;
    }

    public function setDateCandidature(\DateTimeInterface $dateCandidature): self
    {
        $this->dateCandidature = $dateCandidature;
        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;
        return $this;
    }

    public function getLettreMotivation(): ?string
    {
        return $this->lettreMotivation;
    }

    public function setLettreMotivation(?string $lettreMotivation): self
    {
        $this->lettreMotivation = $lettreMotivation;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getNoteInterne(): ?string
    {
        return $this->noteInterne;
    }

    public function setNoteInterne(?string $noteInterne): self
    {
        $this->noteInterne = $noteInterne;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
