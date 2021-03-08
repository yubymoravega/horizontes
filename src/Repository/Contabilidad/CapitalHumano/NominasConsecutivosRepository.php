<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\NominasConsecutivos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NominasConsecutivos|null find($id, $lockMode = null, $lockVersion = null)
 * @method NominasConsecutivos|null findOneBy(array $criteria, array $orderBy = null)
 * @method NominasConsecutivos[]    findAll()
 * @method NominasConsecutivos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NominasConsecutivosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NominasConsecutivos::class);
    }

    // /**
    //  * @return NominasConsecutivos[] Returns an array of NominasConsecutivos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NominasConsecutivos
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
