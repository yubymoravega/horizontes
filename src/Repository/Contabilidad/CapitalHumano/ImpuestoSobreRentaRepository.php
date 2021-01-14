<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\ImpuestoSobreRenta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImpuestoSobreRenta|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImpuestoSobreRenta|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImpuestoSobreRenta[]    findAll()
 * @method ImpuestoSobreRenta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImpuestoSobreRentaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImpuestoSobreRenta::class);
    }

    // /**
    //  * @return ImpuestoSobreRenta[] Returns an array of ImpuestoSobreRenta objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImpuestoSobreRenta
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
