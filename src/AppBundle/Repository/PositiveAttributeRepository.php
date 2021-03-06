<?php

namespace AppBundle\Repository;

/**
 * PositiveAttributeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PositiveAttributeRepository extends \Doctrine\ORM\EntityRepository {

    public function findAllOrderedByName() {
        return $this->getEntityManager()
                        ->createQuery(
                                'SELECT p FROM AppBundle:PositiveAttribute p ORDER BY p.name ASC'
                        )
                        ->getResult();
    }

    /**
     * Return reviews filtered by name(like)
     * @param String $name
     * @return Review
     */
    public function findLikeName($name) {

        return $this->getEntityManager()
                        ->createQuery(
                                'SELECT p FROM AppBundle:PositiveAttribute p WHERE p.name LIKE :filter ORDER BY p.name ASC'
                        )->setParameter('filter', '%' . $name . '%')
                        ->getResult();
    }

}
