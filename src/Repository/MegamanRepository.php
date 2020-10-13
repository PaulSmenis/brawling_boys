<?php

namespace App\Repository;

use App\Entity\Megaman;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

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
}
