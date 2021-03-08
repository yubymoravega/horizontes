<?php

namespace App\Repository\RemesasModule\Configuracion;

use App\Entity\RemesasModule\Configuracion\ConfiguracionReglasRemesas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConfiguracionReglasRemesas|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfiguracionReglasRemesas|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfiguracionReglasRemesas[]    findAll()
 * @method ConfiguracionReglasRemesas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfiguracionReglasRemesasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConfiguracionReglasRemesas::class);
    }

     /**
      * @return ConfiguracionReglasRemesas[] Returns an array of ConfiguracionReglasRemesas objects
      **/
    public function findByMontoPais($pais,$monto,$unidad)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.minimo <= :val')
            ->setParameter('val', $monto)
            ->andWhere('c.maximo >= :val')
            ->setParameter('val', $monto)
            ->andWhere('c.id_pais = :pais')
            ->setParameter('pais', $pais)
            ->andWhere('c.id_unidad = :unidad')
            ->setParameter('unidad', $unidad)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?ConfiguracionReglasRemesas
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
