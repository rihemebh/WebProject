<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\PropertySearch;
use App\Entity\SearchCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search=null): Query
    {
        $query= $this->createQueryBuilder('p')
            ->select('c', 'p', 'l')
            ->join('p.categories', 'c')
            ->join('p.language', 'l')
        ;


        if($search->getAuthor()){
            $query=$query->andWhere('p.auteur LIKE :author')
            ->setParameter('author','%'.$search->getAuthor().'%');
        }

        if ($search->getMaxPrice()) {
            $query = $query->andWhere('p.prix <= :price')
                ->setParameter('price', $search->getMaxPrice());
        }
        if (!empty($search->categories)) {
            $query = $query->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }
        if (!empty($search->languages)) {
            $query = $query->andWhere('l.id IN (:languages)')
                ->setParameter('languages', $search->languages);
        }

        return $query->getQuery();
    }


    /**
     * @param Collection $value
     * @return Livre[] Returns an array of Livre objects
     */
    public function findBookBy(Collection $value, $id)
    {
        return $this->createQueryBuilder('l')
            ->join('l.categories', 'c')
            ->andWhere('c.id IN (:val)')
            ->andWhere('l.id != :id')
            ->setParameter('val', $value)
            ->setParameter('id', $id)
            ->setMaxResults(12)
            ->getQuery()
            ->getResult();
    }


//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
//    */
}
