<?php

namespace App\Repository\Contabilidad\Config;

use App\Entity\Contabilidad\Config\TipoDocumentoActivoFijo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoDocumentoActivoFijo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoDocumentoActivoFijo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoDocumentoActivoFijo[]    findAll()
 * @method TipoDocumentoActivoFijo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoDocumentoActivoFijoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoDocumentoActivoFijo::class);
    }

    // /**
    //  * @return TipoDocumentoActivoFijo[] Returns an array of TipoDocumentoActivoFijo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoDocumentoActivoFijo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
