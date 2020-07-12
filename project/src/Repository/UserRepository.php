<?php

namespace App\Repository;

use App\Entity\Livre;
use App\Entity\PropertySearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param PropertySearch|null $search
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search=null): Query
    {
        $query= $this->createQueryBuilder('u')
            ->select('u')
        ;
        if($search->getUserName()){
            $query=$query->andWhere('u.User_Name LIKE :username')
                ->setParameter('username','%'.$search->getUserName().'%');
        }

        return $query->getQuery();
    }

}
