<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * SeparatorRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeparatorRepository extends EntityRepository {

    public function findAllOrderedById() {
        return $this->getEntityManager()
                        ->createQuery(
                                'SELECT s FROM AppBundle:Separator s ORDER BY s.id ASC'
                        )
                        ->getResult();
    }

}
