<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\Documento;
use App\Entity\Contabilidad\Inventario\InformeRecepcion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InformeRecepcion|null find($id, $lockMode = null, $lockVersion = null)
 * @method InformeRecepcion|null findOneBy(array $criteria, array $orderBy = null)
 * @method InformeRecepcion[]    findAll()
 * @method InformeRecepcion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InformeRecepcionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InformeRecepcion::class);
    }

     /**
      * @return InformeRecepcion[] Returns an array of InformeRecepcion objects
      */

    public function findByIdUnidad($id_unidad,$year,$id_almacen)
    {
        $query = $this->createQueryBuilder('i')
            ->join(Documento::class, 'd','d.id = i.id_documento')
            ->andWhere('d.id_unidad = :val')
            ->setParameter('val', $id_unidad)
            ->andWhere('d.id_almacen = :val')
            ->setParameter('val', $id_almacen)
            ->andWhere('i.anno = :val')
            ->setParameter('val', $year)
            ->orderBy('i.id', 'ASC')
            ->getQuery();
        return $query->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?InformeRecepcion
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
