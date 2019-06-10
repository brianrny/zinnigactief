<?php

namespace App\Repository;

use App\Entity\Attend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Attend|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attend|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attend[]    findAll()
 * @method Attend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Attend::class);
    }

    // /**
    //  * @return Attend[] Returns an array of Attend objects
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
    public function findOneBySomeField($value): ?Attend
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
