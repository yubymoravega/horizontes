<?php

namespace App\Repository\TurismoModule\Traslado;

use App\Entity\TurismoModule\Traslado\TipoTraslado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoTraslado|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoTraslado|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoTraslado[]    findAll()
 * @method TipoTraslado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoTrasladoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoTraslado::class);
    }

    // /**
    //  * @return TipoTraslado[] Returns an array of TipoTraslado objects
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
    public function findOneBySomeField($value): ?TipoTraslado
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
