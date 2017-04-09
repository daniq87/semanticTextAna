<?php

namespace AppBundle\Services;

use AppBundle\Entity\NegativeAttribute;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of NegativeAttributeService
 *
 * @author Daniel
 */
class NegativeAttributeService {

    const ENTITY_NAME = 'AppBundle:NegativeAttribute';

    private $em;
    protected $requestStack;

    public function __construct(EntityManager $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * Get negativeAttribute by id
     * @param integer $id
     */
    public function findById($id) {
        return $this->em->getRepository(self::ENTITY_NAME)->find($id);
    }

    /**
     * Get negativeAttributes filtering by attributeName
     * @param string $attributeName
     * @return array NegativeAttribute
     */
    public function findLikeName($attributeName) {
        return $this->em->getRepository(self::ENTITY_NAME)->findLikeName($attributeName);
    }

    /**
     * Get All negative attributes ordered DESC by name
     * @return array NegativeAttribute
     */
    public function findAllOrderedByName() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedByName();
    }

    /**
     * insert NegativeAttribute into table negative_attribute
     * @param NegativeAttribute $attribute
     */
    public function create(NegativeAttribute $attribute) {
        $this->em->persist($attribute);
        $this->em->flush($attribute);
    }

    /**
     * Update NegativeAttribute from table negative_attribute
     * @param NegativeAttribute $attribute
     */
    public function update(NegativeAttribute $attribute) {
        $this->em->flush($attribute);
    }

    /**
     * Delete negativeAttribute from table negative_attribute
     * @param NegativeAttribute $attribute
     */
    public function delete(NegativeAttribute $attribute) {
        $this->em->remove($attribute);
        $this->em->flush();
    }

}
