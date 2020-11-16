<?php

namespace App\Repository;

use App\Entity\SolicitudTurismoComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SolicitudTurismoComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitudTurismoComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitudTurismoComentario[]    findAll()
 * @method SolicitudTurismoComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitudTurismoComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitudTurismoComentario::class);
    }

    // /**
    //  * @return SolicitudTurismoComentario[] Returns an array of SolicitudTurismoComentario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SolicitudTurismoComentario
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
