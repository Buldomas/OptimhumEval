<?php

namespace App\Repository;

use App\Entity\QTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method QTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method QTheme[]    findAll()
 * @method QTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QTheme::class);
    }

    // /**
    //  * @return QTheme[] Returns an array of QTheme objects
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
    public function findOneBySomeField($value): ?QTheme
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
