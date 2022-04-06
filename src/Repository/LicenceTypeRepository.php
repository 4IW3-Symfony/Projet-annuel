<?php

namespace App\Repository;

use App\Entity\LicenceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LicenceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LicenceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LicenceType[]    findAll()
 * @method LicenceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenceTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicenceType::class);
    }

    // /**
    //  * @return LicenceType[] Returns an array of LicenceType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LicenceType
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
