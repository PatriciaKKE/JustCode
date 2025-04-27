<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
 dev_marte
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;


use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Candidature>
 */
 dev
class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

 dev_marte
    public function createQueryBuilderWithFilters(array $filters = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c')
            ->leftJoin('c.offre', 'o')
            ->addSelect('o')
            ->orderBy('c.dateCandidature', 'DESC');

        if ($filters) {
            if (!empty($filters['status'])) {
                $qb->andWhere('c.status = :status')
                   ->setParameter('status', $filters['status']);
            }
            
            if (!empty($filters['offre'])) {
                $qb->andWhere('o.id = :offreId')
                   ->setParameter('offreId', $filters['offre']);
            }
        }

        return $qb;
    }
}

    //    /**
    //     * @return Candidature[] Returns an array of Candidature objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Candidature
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
 dev
