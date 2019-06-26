<?php

namespace App\Repository;

use App\Entity\EventHasActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventHasActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventHasActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventHasActivity[]    findAll()
 * @method EventHasActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventHasActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventHasActivity::class);
    }

    // /**
    //  * @return EventHasActivity[] Returns an array of EventHasActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventHasActivity
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
