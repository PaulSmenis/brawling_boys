<?php

namespace App\Repository;

use App\Entity\Medkit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medkit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medkit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medkit[]    findAll()
 * @method Medkit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedkitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medkit::class);
    }

    // /**
    //  * @return Medkit[] Returns an array of Medkit objects
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
    public function findOneBySomeField($value): ?Medkit
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
