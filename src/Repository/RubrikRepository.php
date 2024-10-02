<?php

namespace App\Repository;

use App\Entity\Rubrik;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rubrik>
 */
class RubrikRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rubrik::class);
    }

    /**
     * @return array
     */
    public function findAllNamesAndIds()
    {
        return $this->createQueryBuilder('r')
            ->select('r.id', 'r.name')
            ->getQuery()
            ->getResult();
    }
}
