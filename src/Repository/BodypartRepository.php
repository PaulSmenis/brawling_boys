<?php

namespace App\Repository;

use App\Entity\Bodypart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bodypart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bodypart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bodypart[]    findAll()
 * @method Bodypart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BodypartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bodypart::class);
    }

    // /**
    //  * @return Bodypart[] Returns an array of Bodypart objects
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
    public function findOneBySomeField($value): ?Bodypart
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
