dev_marte
<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[Vich\Uploadable]
class Candidature
{
    public const STATUS_RECEIVED = 'reçue';
    public const STATUS_IN_REVIEW = 'en cours';
    public const STATUS_INTERVIEW = 'entretien';
    public const STATUS_REJECTED = 'refusée';
    public const STATUS_ACCEPTED = 'acceptée';

    public const STATUS_CHOICES = [
        'Reçue' => self::STATUS_RECEIVED,
        'En cours' => self::STATUS_IN_REVIEW,
        'Entretien' => self::STATUS_INTERVIEW,
        'Refusée' => self::STATUS_REJECTED,
        'Acceptée' => self::STATUS_ACCEPTED,
    ];

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
    #[Assert\NotBlank(message: "L'email est requis.")]
    #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateCandidature = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[Vich\UploadableField(mapping: 'candidature_file', fileNameProperty: 'cv')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['application/pdf'],
        mimeTypesMessage: 'Veuillez uploader un fichier PDF valide (max 2Mo)'
    )]
    private ?File $cvFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lettreMotivation = null;

    #[Vich\UploadableField(mapping: 'candidature_file', fileNameProperty: 'lettreMotivation')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['application/pdf'],
        mimeTypesMessage: 'Veuillez uploader un fichier PDF valide (max 2Mo)'
    )]
    private ?File $lettreMotivationFile = null;

    #[ORM\Column(length: 20)]
    private string $status = self::STATUS_RECEIVED;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $noteInterne = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->dateCandidature = new \DateTime();
    }

    // Getters/Setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getDateCandidature(): ?\DateTimeInterface
    {
        return $this->dateCandidature;
    }

    public function setDateCandidature(\DateTimeInterface $dateCandidature): static
    {
        $this->dateCandidature = $dateCandidature;
        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;
        return $this;
    }

    public function getLettreMotivation(): ?string
    {
        return $this->lettreMotivation;
    }

    public function setLettreMotivation(?string $lettreMotivation): static
    {
        $this->lettreMotivation = $lettreMotivation;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        if (!in_array($status, array_values(self::STATUS_CHOICES))) {
            throw new \InvalidArgumentException("Statut invalide");
        }
        $this->status = $status;
        return $this;
    }

    public function getStatusLabel(): string
    {
        return array_flip(self::STATUS_CHOICES)[$this->status] ?? $this->status;
    }

    public function getNoteInterne(): ?string
    {
        return $this->noteInterne;
    }

    public function setNoteInterne(?string $noteInterne): static
    {
        $this->noteInterne = $noteInterne;
        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getCvFile(): ?File
    {
        return $this->cvFile;
    }

    public function setCvFile(?File $cvFile = null): void
    {
        $this->cvFile = $cvFile;
        if (null !== $cvFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getLettreMotivationFile(): ?File
    {
        return $this->lettreMotivationFile;
    }

    public function setLettreMotivationFile(?File $lettreMotivationFile = null): void
    {
        $this->lettreMotivationFile = $lettreMotivationFile;
        if (null !== $lettreMotivationFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

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
    private $email;

    #[ORM\Column(type: 'string', length: 50)]
    private $statut;

    #[ORM\ManyToOne(targetEntity: Offre::class, inversedBy: 'candidatures')]
    private $offre;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

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
dev
}