<?php

namespace App\Repository\Contabilidad\Inventario;

use App\Entity\Contabilidad\Inventario\MovimientoMercancia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovimientoMercancia|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoMercancia|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoMercancia[]    findAll()
 * @method MovimientoMercancia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntradaMercanciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoMercancia::class);
    }

    /*public function movimientosInMoth($moth, $alamcen)
    {
        return $this->getEntityManager()
            ->createQuery('
        SELECT COUNT(a)
        FROM App\Entity\Contabilidad\Inventario\MovimientoMercancia a
        WHERE a.id_almacen = :alamcen AND DATE_SUB(a.fecha, ) BETWEEN
')
            ->setParameters([
                'alamcen' => $alamcen,
                'fecha'
            ]);
    }*/

    // /**
    //  * @return MovimientoMercancia[] Returns an array of MovimientoMercancia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MovimientoMercancia
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
