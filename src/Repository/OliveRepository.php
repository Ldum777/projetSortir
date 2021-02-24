<?php

namespace App\Repository;

use App\Entity\Olive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Olive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Olive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Olive[]    findAll()
 * @method Olive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OliveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Olive::class);
    }

    // /**
    //  * @return Olive[] Returns an array of Olive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Olive
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
