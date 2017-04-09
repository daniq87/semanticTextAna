<?php

namespace AppBundle\Services;

use AppBundle\Entity\PositiveAttribute;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of PositiveAttributeService
 *
 * @author Daniel
 */
class PositiveAttributeService {

    const ENTITY_NAME = 'AppBundle:PositiveAttribute';

    private $em;
    protected $requestStack;

    public function __construct(EntityManager $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * Get positiveAttribute by id
     * @param integer $id
     */
    public function findById($id) {
        return $this->em->getRepository(self::ENTITY_NAME)->find($id);
    }

    /**
     * Get positiveAttributes filtering by attributeName
     * @param string $attributeName
     * @return array PositiveAttribute
     */
    public function findLikeName($attributeName) {
        return $this->em->getRepository(self::ENTITY_NAME)->findLikeName($attributeName);
    }

    /**
     * Get All positive attributes ordered DESC by Id
     * @return array PositiveAttribute
     */
    public function findAllOrderedByName() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedByName();
    }

    /**
     * insert PositiveAttribute into table positive_attribute
     * @param PositiveAttribute $attribute
     */
    public function create(PositiveAttribute $attribute) {
        $this->em->persist($attribute);
        $this->em->flush($attribute);
    }

    /**
     * Update PositiveAttribute from table positive_attribute
     * @param PositiveAttribute $attribute
     */
    public function update(PositiveAttribute $attribute) {
        $this->em->flush($attribute);
    }

    /**
     * Delete positiveAttribute from table positive_attribute
     * @param PositiveAttribute $attribute
     */
    public function delete(PositiveAttribute $attribute) {
        $this->em->remove($attribute);
        $this->em->flush();
    }

}
