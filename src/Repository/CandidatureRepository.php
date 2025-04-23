<?php

namespace App\Repository;

use App\Entity\Candidature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class CandidatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidature::class);
    }

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