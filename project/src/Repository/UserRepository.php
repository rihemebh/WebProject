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
     * @return Query
     */
    public function findAllVisibleQuery(PropertySearch $search=null): Query
    {
        $query= $this->createQueryBuilder('u')
            ->select('c')
        ;


        if($search->getUserName()){
            $query=$query->andWhere('u.UserName LIKE :username')
                ->setParameter('username','%'.$search->getUserName().'%');
        }


        return $query->getQuery();
    }




//    public function findUsers(): Query
//    {
//        $query= $this->createQueryBuilder('u')
//            ->select('u')
//        ;
//
//            $query=$query->andWhere('u.Roles IN :role')
//                ->setParameter('role',array('ROLE_USER'));
//
////        $query=$query->andWhere('u.Roles LIKE :role')
////            ->setParameter('role','%'.'ROLE_USER'.'%');
//        return $query->getQuery();
//    }
}
