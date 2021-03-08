<?php

namespace App\Repository\TurismoModule\Utils;

use App\Entity\TurismoModule\Utils\UserClientTmp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserClientTmp|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserClientTmp|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserClientTmp[]    findAll()
 * @method UserClientTmp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserClientTmpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserClientTmp::class);
    }

    // /**
    //  * @return UserClientTmp[] Returns an array of UserClientTmp objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserClientTmp
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
