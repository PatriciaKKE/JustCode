<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre est requis.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Le titre doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le titre ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $titre = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "La description est requise.")]
    private ?string $description = null;

    #[ORM\Column(type: "datetime")]
    #[Assert\NotNull(message: "La date de publication est requise.")]
    private ?\DateTimeInterface $datePublication = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    #[Assert\GreaterThan(
        propertyPath: "datePublication",
        message: "La date de fin doit être postérieure à la date de publication."
    )]
    private ?\DateTimeInterface $dateFinPublication = null;

    #[ORM\OneToMany(mappedBy: 'offre', targetEntity: Candidature::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
        $this->datePublication = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;
        return $this;
    }

    public function getDateFinPublication(): ?\DateTimeInterface
    {
        return $this->dateFinPublication;
    }

    public function setDateFinPublication(?\DateTimeInterface $dateFinPublication): self
    {
        $this->dateFinPublication = $dateFinPublication;
        return $this;
    }

    /**
     * @return Collection<int, Candidature>
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures[] = $candidature;
            $candidature->setOffre($this);
        }
        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            if ($candidature->getOffre() === $this) {
                $candidature->setOffre(null);
            }
        }
        return $this;
    }
}
