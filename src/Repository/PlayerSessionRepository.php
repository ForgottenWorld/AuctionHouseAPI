<?php

namespace App\Repository;

use App\Entity\PlayerSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PlayerSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerSession[]    findAll()
 * @method PlayerSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerSession::class);
    }

    // /**
    //  * @return PlayerSession[] Returns an array of PlayerSession objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlayerSession
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
