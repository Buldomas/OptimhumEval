<?php

namespace App\Repository;

use App\Entity\QModule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QModule|null find($id, $lockMode = null, $lockVersion = null)
 * @method QModule|null findOneBy(array $criteria, array $orderBy = null)
 * @method QModule[]    findAll()
 * @method QModule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QModuleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QModule::class);
    }

    // /**
    //  * @return QModule[] Returns an array of QModule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QModule
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
