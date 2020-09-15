<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\CierreDiario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CierreDiario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CierreDiario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CierreDiario[]    findAll()
 * @method CierreDiario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CierreDiarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CierreDiario::class);
    }

    // /**
    //  * @return CierreDiario[] Returns an array of CierreDiario objects
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
    public function findOneBySomeField($value): ?CierreDiario
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
