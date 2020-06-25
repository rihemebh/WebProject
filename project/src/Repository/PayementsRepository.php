<?php

namespace App\Repository;

use App\Entity\Payements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payements[]    findAll()
 * @method Payements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payements::class);
    }

    // /**
    //  * @return Payements[] Returns an array of Payements objects
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
    public function findOneBySomeField($value): ?Payements
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
