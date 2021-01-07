<?php

namespace App\Repository\Contabilidad\CapitalHumano;

use App\Entity\Contabilidad\CapitalHumano\AcumuladoVacaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcumuladoVacaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcumuladoVacaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcumuladoVacaciones[]    findAll()
 * @method AcumuladoVacaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcumuladoVacacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcumuladoVacaciones::class);
    }

    // /**
    //  * @return AcumuladoVacaciones[] Returns an array of AcumuladoVacaciones objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AcumuladoVacaciones
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
