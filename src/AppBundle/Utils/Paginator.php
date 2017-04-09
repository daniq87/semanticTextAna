<?php

namespace AppBundle\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;

/**
 * Description of Paginator
 *
 * @author Daniel
 */
class Paginator {

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * Return Pagination
     * @param type $list
     * @param integer $numberPag
     * @param integer $numberElementsPerPage
     * @return Pagination
     */
    public function getPagination($list, $numberPag, $numberElementsPerPage) {
       $knpPaginator = $this->container->get("knp_paginator");
        return $pagination = $knpPaginator->paginate(
                $list, $numberPag, $numberElementsPerPage
        );
    }

}
