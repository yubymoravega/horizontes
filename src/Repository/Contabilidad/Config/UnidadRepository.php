<?php

namespace App\Repository\Contabilidad\Config;

use App\CoreContabilidad\ParanoidEntityRepository;
use App\Entity\Contabilidad\Config\Unidad;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class
 * @method Unidad|null find($id, $paranoid = true)
 * @method Unidad|null findOneBy(array $criteria, $paranoid = true, array $orderBy = null)
 * @method Unidad[]    findAll($paranoid = true)
 * @method Unidad[]    findBy(array $criteria, $paranoid = true, array $orderBy = null, $limit = null, $offset = null)
 */
class UnidadRepository extends ParanoidEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->setEntityClass(Unidad::class);
        $this->setRegistry($registry);
        parent::__construct();
    }

    // /**
    //  * @return Unidad[] Returns an array of Unidad objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Unidad
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
