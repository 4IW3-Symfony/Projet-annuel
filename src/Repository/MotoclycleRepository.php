<?php

namespace App\Repository;

use App\Entity\Motoclycle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Motoclycle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motoclycle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motoclycle[]    findAll()
 * @method Motoclycle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotoclycleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motoclycle::class);
    }

    // /**
    //  * @return Motoclycle[] Returns an array of Motoclycle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Motoclycle
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
