<?php

namespace App\Repository;

use App\Entity\Agglomeration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Agglomeration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Agglomeration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Agglomeration[]    findAll()
 * @method Agglomeration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgglomerationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Agglomeration::class);
    }

    // /**
    //  * @return Agglomeration[] Returns an array of Agglomeration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Agglomeration
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
