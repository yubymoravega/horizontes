<?php

namespace App\Repository\Contabilidad\General;

use App\Entity\Contabilidad\General\Asiento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Asiento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asiento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asiento[]    findAll()
 * @method Asiento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AsientoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Asiento::class);
    }

    public function GroupForBalanceComprobacion($anno, $unidad)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT sum(a.credito) as credito, sum(a.debito) as debito, a AS asiento               
                 FROM App\Entity\Contabilidad\General\Asiento a
                 WHERE a.anno = :panno AND a.id_unidad = :punidad
                 GROUP BY a.id_cuenta, a.id_subcuenta, a.id_almacen,
                  a.id_centro_costo, a.id_elemento_gasto, a.id_orden_trabajo, a.id_expediente, a.id_cliente, a.tipo_cliente
                 ORDER BY a.id_cuenta , a.id_subcuenta      
           ')
            ->setParameters(['panno' => $anno, 'punidad' => $unidad])
            ->getResult();
        /*return $this->createQueryBuilder('a')
            ->where('a.anno = :panno')
            ->andWhere('a.id_unidad = :punidad')
            ->setParameters(['panno' => $anno, 'punidad' => $unidad])
            ->groupBy('a.id_cuenta')
            ->addGroupBy('a.id_subcuenta')
            ->addGroupBy('a.id_almacen')
            ->addGroupBy('a.id_centro_costo')
            ->addGroupBy('a.id_elemento_gasto')
            ->addGroupBy('a.id_orden_trabajo')
            ->addGroupBy('a.id_expediente')
            ->getQuery()
            ;*/

    }

    // /**
    //  * @return Asiento[] Returns an array of Asiento objects
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
    public function findOneBySomeField($value): ?Asiento
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
