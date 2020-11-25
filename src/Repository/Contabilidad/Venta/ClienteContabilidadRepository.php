<?php

namespace App\Repository\Contabilidad\Venta;

use App\Entity\Contabilidad\Venta\ClienteContabilidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClienteContabilidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClienteContabilidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClienteContabilidad[]    findAll()
 * @method ClienteContabilidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteContabilidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClienteContabilidad::class);
    }

    // /**
    //  * @return ClienteContabilidad[] Returns an array of ClienteContabilidad objects
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
    public function findOneBySomeField($value): ?ClienteContabilidad
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
