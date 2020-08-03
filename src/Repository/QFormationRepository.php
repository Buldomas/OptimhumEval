<?php

namespace App\Repository;

use App\Entity\QFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method QFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method QFormation[]    findAll()
 * @method QFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QFormation::class);
    }

    // /**
    //  * @return QFormation[] Returns an array of QFormation objects
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
    public function findOneBySomeField($value): ?QFormation
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
