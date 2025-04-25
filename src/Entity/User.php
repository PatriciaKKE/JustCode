<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "L’email est requis.")]
    #[Assert\Email(message: "L’email '{{ value }}' n’est pas valide.")]
    private ?string $email = null;

    #[ORM\Column]
    private ?string $password = null;

    /**
     * Pour la saisie et la validation du mot de passe en clair.
     * Non mappé en base.
     */
    #[Assert\NotBlank(message: "Le mot de passe est requis.")]
    #[Assert\Length(
        min: 8,
        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères."
    )]
    private ?string $plainPassword = null;

    #[ORM\Column]
    #[Assert\All([
        new Assert\Choice([
            'choices' => ['ROLE_USER', 'ROLE_ADMIN'],
            'message' => 'Le rôle "{{ value }}" n’est pas valide.'
        ])
    ])]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Candidature::class)]
    private Collection $candidatures;

    public function __construct()
    {
        $this->candidatures = new ArrayCollection();
        // Par défaut, tout utilisateur a au moins ce rôle
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * Utilisé par Symfony pour l’authentification.
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated Depuis Symfony 5.3, utiliser getUserIdentifier()
     */
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * Récupère le mot de passe haché stocké en base.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Définit le mot de passe haché.
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Champ non persisté pour la saisie et validation avant hash.
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * Retourne les rôles de l’utilisateur, en s’assurant qu’il y ait au moins ROLE_USER.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if (!in_array('ROLE_USER', $roles, true)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Non utilisé avec bcrypt/sodium mais nécessaire à l’interface.
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Efface les données sensibles temporaires.
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
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
            $candidature->setUser($this);
        }
        return $this;
    }

    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            if ($candidature->getUser() === $this) {
                $candidature->setUser(null);
            }
        }
        return $this;
    }
}
