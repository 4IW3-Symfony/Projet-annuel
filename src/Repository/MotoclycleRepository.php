<?php

namespace App\Repository;

use App\Entity\Motorcycle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Motorcycle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Motorcycle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Motorcycle[]    findAll()
 * @method Motorcycle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MotorcycleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Motorcycle::class);
    }

    // /**
    //  * @return Motorcycle[] Returns an array of Motorcycle objects
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
    public function findOneBySomeField($value): ?Motorcycle
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
