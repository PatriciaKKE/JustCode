// src/Repository/CandidatureStatutRepository.php
namespace App\Repository;

use App\Entity\CandidatureStatut;
use App\Entity\User;
use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidatureStatut>
 *
 * @method CandidatureStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatureStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatureStatut[]    findAll()
 * @method CandidatureStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatureStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry
