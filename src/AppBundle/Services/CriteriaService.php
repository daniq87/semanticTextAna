<?php

namespace AppBundle\Services;

use AppBundle\Entity\Criteria;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of CriteriaService
 *
 * @author Daniel
 */
class CriteriaService {
const ENTITY_NAME = 'AppBundle:Criteria';

    private $em;
    protected $requestStack;

    public function __construct(EntityManager $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * Get criteria by id
     * @param integer $id
     */
    public function findById($id) {
        return $this->em->getRepository(self::ENTITY_NAME)->find($id);
    }

    /**
     * Get criterias filtering by criteriaName
     * @param string $criteriaName
     * @return array Criteria
     */
    public function findLike($criteriaName) {
        return $this->em->getRepository(self::ENTITY_NAME)->findLike($criteriaName);
    }

    /**
     * Get All criterias ordered ASC name
     * @return array Criteria
     */
    public function findAllOrderedByName() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedByName();
    }
    
    /**
     * Get All criterias ordered ASC by topic and name
     * @return array Criteria
     */
    public function findAllOrderedByTopicName() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedByTopicName();
    }

    /**
     * insert Criteria into table criterias
     * @param Criteria $criteria
     */
    public function create(Criteria $criteria) {
        $this->em->persist($criteria);
        $this->em->flush($criteria);
    }

    /**
     * Update Criteria from table criterias
     * @param Criteria $criteria
     */
    public function update(Criteria $criteria) {
        $this->em->flush($criteria);
    }

    /**
     * Delete criteria from table criteria
     * @param Criteria $criteria
     */
    public function delete(Criteria $criteria) {

        $this->em->remove($criteria);
        $this->em->flush();
    }
}
