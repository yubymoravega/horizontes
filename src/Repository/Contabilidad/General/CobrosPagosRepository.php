<?php

namespace App\Repository\Contabilidad\General;

use App\Entity\Contabilidad\General\CobrosPagos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CobrosPagos|null find($id, $lockMode = null, $lockVersion = null)
 * @method CobrosPagos|null findOneBy(array $criteria, array $orderBy = null)
 * @method CobrosPagos[]    findAll()
 * @method CobrosPagos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CobrosPagosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CobrosPagos::class);
    }

    // /**
    //  * @return CobrosPagos[] Returns an array of CobrosPagos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CobrosPagos
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
