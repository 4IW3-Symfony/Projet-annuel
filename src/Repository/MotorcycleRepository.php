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

    public function findPriceMin()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select min(m.price) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function findPriceMax()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select max(m.price) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function findYearMin()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select min(m.year) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function findYearMax()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select max(m.year) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function findPowerMin()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select min(m.power) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function findPowerMax()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
        Select max(m.power) 
        FROM App\Entity\Motorcycle m
        Where m.status = 1');
        return $query->getResult();
    }

    public function searchMotorcycle($condition)
    {
        $qb = $this->createQueryBuilder('m')->join('m.model','md')->join('md.brand','d')->join('m.licenceType','lt')->where('m.status != 3');
        foreach( $condition as $key => $value)
        {
            switch($key){
                case "marque":
                    $qb->andWhere('d.name = :marque');
                    $qb->setParameter('marque',$value);
                    break;
                case "prix_min":
                    $qb->andWhere('m.price >= :prix_min');
                    $qb->setParameter('prix_min', $value);
                    break;
                case "prix_max":
                    $qb->andWhere('m.price <= :prix_max');
                    $qb->setParameter('prix_max', $value);
                    break;
                case "year_min":
                    $qb->andWhere('m.year >= :year_min');
                    $qb->setParameter('year_min', $value);
                    break;
                case "year_max":
                    $qb->andWhere('m.year <= :year_max');
                    $qb->setParameter('year_max', $value);
                    break;
                case "power_min":
                    $qb->andWhere('m.power >= :power_min');
                    $qb->setParameter('power_min', $value);
                    break;
                case "power_max":
                    $qb->andWhere('m.power <= :power_max');
                    $qb->setParameter('power_max', $value);
                    break;
                case "A2":
                    $qb->andWhere('lt.type = :A2');
                    $qb->setParameter('A2','A2');
                    break;
                case "A":
                    $qb->andWhere('lt.type = :A');
                    $qb->setParameter('A','A');
                    break;
                case "ville":
                    $qb->andWhere('m.City = :ville ');
                    $qb->setParameter('ville', $value);
                    break;
                
            }
        }
        $qb->andWhere('m.status = 1');
        $query = $qb->getQuery();
        return $query->execute();
    }
}
