<?php

namespace App\Repository;

use App\Entity\RentalLines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentalLines|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalLines|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalLines[]    findAll()
 * @method RentalLines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalLinesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalLines::class);
    }

    // /**
    //  * @return RentalLines[] Returns an array of RentalLines objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentalLines
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
