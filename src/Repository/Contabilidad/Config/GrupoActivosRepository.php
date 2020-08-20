<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\GrupoActivos;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method GrupoActivos|null find($id, $paranoid = true)
 * @method GrupoActivos|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method GrupoActivos[]    findAll($paranoid = true)
 * @method GrupoActivos[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class GrupoActivosRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setRegistry($registry);
        $this->setEntityClass(GrupoActivos::class);
        parent::__construct();
    }

    // /**
    //  * @return GrupoActivos[] Returns an array of GrupoActivos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GrupoActivos
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
