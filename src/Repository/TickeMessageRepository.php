<?php

namespace App\Repository;

use App\Entity\TickeMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TickeMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TickeMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TickeMessage[]    findAll()
 * @method TickeMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TickeMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TickeMessage::class);
    }

    // /**
    //  * @return TickeMessage[] Returns an array of TickeMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TickeMessage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
