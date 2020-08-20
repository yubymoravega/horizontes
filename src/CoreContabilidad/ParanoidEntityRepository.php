<?php


namespace App\CoreContabilidad;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LogicException;

/**
 * Class ParanoidEntityRepository - Incorporate de paranoid concept to @EntityRepository
 * width Boolean value, not Date
 * @package App\CoreContabilidad
 */
class ParanoidEntityRepository extends EntityRepository implements ServiceEntityRepositoryInterface
{
    private ManagerRegistry $registry;
    private $entityClass;

    /**
     * @return ManagerRegistry
     */
    public function getRegistry(): ManagerRegistry
    {
        return $this->registry;
    }

    /**
     * @param ManagerRegistry $registry
     */
    public function setRegistry(ManagerRegistry $registry): void
    {
        $this->registry = $registry;
    }

    /**
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param mixed $entityClass
     */
    public function setEntityClass($entityClass): void
    {
        $this->entityClass = $entityClass;
    }

    public function __construct()
    {
        $manager = $this->registry->getManagerForClass($this->getEntityClass());

        if ($manager === null) {
            throw new LogicException(sprintf(
                'Could not find the entity manager for class "%s". Check your Doctrine configuration to make sure it is configured to load this entity’s metadata.',
                $this->getEntityClass()
            ));
        }
        parent::__construct($manager, $manager->getClassMetadata($this->getEntityClass()));
    }


    /**
     * find by id. width **paranoid**
     * @param mixed $id
     * @param bool $paranoid
     * @return object|void|null
     */
    public function find($id, $lockMode = null, $lockVersion = null, $paranoid = true)
    {
        $params = ['id' => $id];
        return $this->findOneBy($params, null, $paranoid);
    }

    /**
     * Finds all entities in the repository. width **paranoid**
     * @param bool $paranoid
     * @return array The entities.
     */
    public function findAll($paranoid = true)
    {
        $params = [];
        if ($paranoid) $params['activo'] = true;
        return parent::findBy($params);
    }


    /**
     * Finds entities by a set of criteria. width **paranoid**
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @param bool $paranoid
     *
     * @return array The objects.
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null, $paranoid = true)
    {
        if ($paranoid) $criteria['activo'] = true;
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria. width **paranoid**
     *
     * @param array $criteria
     * @param array|null
     * @param bool $paranoid
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     */
    public function findOneBy(array $criteria, array $orderBy = null, $paranoid = true)
    {
        if ($paranoid) $criteria['activo'] = true;
        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * Counts entities by a set of criteria. width **paranoid**
     *
     * @param array $criteria
     * @param bool $paranoid
     *
     * @return int The cardinality of the objects that match the given criteria.
     */
    public function count(array $criteria, $paranoid = true)
    {
        if ($paranoid) $criteria['activo'] = true;
        return parent::count($criteria);
    }
}