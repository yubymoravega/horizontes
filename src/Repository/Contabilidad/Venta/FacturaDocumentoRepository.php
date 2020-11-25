<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\FacturaDocumento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FacturaDocumento|null find($id, $lockMode = null, $lockVersion = null)
 * @method FacturaDocumento|null findOneBy(array $criteria, array $orderBy = null)
 * @method FacturaDocumento[]    findAll()
 * @method FacturaDocumento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FacturaDocumentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FacturaDocumento::class);
    }

    // /**
    //  * @return FacturaDocumento[] Returns an array of FacturaDocumento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FacturaDocumento
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
