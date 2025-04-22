namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?Offre $offre = null;

    #[ORM\Column(length: 255)]
    private ?string $cv = null;

    #[ORM\Column(length: 255)]
    private ?string $lettre = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaireInterne = null;

    // Getters & setters...
}
