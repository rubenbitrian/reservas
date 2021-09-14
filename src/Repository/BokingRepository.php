<?php

namespace App\Repository;

use App\Entity\Boking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Boking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boking[]    findAll()
 * @method Boking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BokingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boking::class);
    }

    // /**
    //  * @return Boking[] Returns an array of Boking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Boking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
