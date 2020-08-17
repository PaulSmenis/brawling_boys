<?php

namespace App\Repository;

use App\Entity\Megaman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Megaman|null find($id, $lockMode = null, $lockVersion = null)
 * @method Megaman|null findOneBy(array $criteria, array $orderBy = null)
 * @method Megaman[]    findAll()
 * @method Megaman[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MegamanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Megaman::class);
    }

    // /**
    //  * @return Megaman[] Returns an array of Megaman objects
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
    public function findOneBySomeField($value): ?Megaman
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
