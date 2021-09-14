<?php

namespace App\Repository;

use App\Entity\MobileHome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MobileHome|null find($id, $lockMode = null, $lockVersion = null)
 * @method MobileHome|null findOneBy(array $criteria, array $orderBy = null)
 * @method MobileHome[]    findAll()
 * @method MobileHome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MobileHomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MobileHome::class);
    }

    // /**
    //  * @return MobileHome[] Returns an array of MobileHome objects
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
    public function findOneBySomeField($value): ?MobileHome
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
