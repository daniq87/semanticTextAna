<?php

namespace AppBundle\Services;

use AppBundle\Entity\Review;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of ReviewService
 *
 * @author Daniel
 */
class ReviewService {

    const ENTITY_NAME = 'AppBundle:Review';

    private $em;
    protected $requestStack;

    public function __construct(EntityManager $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function ajax(&$template) {

        if ($this->requestStack->getCurrentRequest()->isXmlHttpRequest()) {
            $template = "Review/reviews_list.html.twig";
            $x = $_GET['reviewName'];
            $reviews = $this->findLikeName($x);
        } else {
            $reviews = $this->findAllOrderedById();
        }

        return $reviews;
    }

    /**
     * Get review by id
     * @param integer $id
     */
    public function findById($id) {
        return $this->em->getRepository(self::ENTITY_NAME)->find($id);
    }

    /**
     * Get reviews filtering by reviewName
     * @param string $reviewName
     * @return array Review
     */
    public function findLikeName($reviewName) {
        return $this->em->getRepository(self::ENTITY_NAME)->findLikeName($reviewName);
    }

    /**
     * Get All reviews ordered DESC by Id
     * @return array Review
     */
    public function findAllOrderedById() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedById();
    }

    /**
     * insert Review into table reviews
     * @param Review $review
     */
    public function create(Review $review) {
        $this->em->persist($review);
        $this->em->flush($review);
    }

    /**
     * Update Review from table reviews
     * @param Review $review
     */
    public function update(Review $review) {
        $this->em->flush($review);
    }

    /**
     * Delete review from table review
     * @param Review $review
     */
    public function delete(Review $review) {

        $this->em->remove($review);
        $this->em->flush();
    }

}
