<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;
/**
 * Description of SeparatorService
 *
 * @author Daniel
 */
class SeparatorService {

    const ENTITY_NAME = 'AppBundle:Separator';

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Get topic by id
     * @param integer $id
     */
    public function findAllOrderedById() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedById();
    }
}
