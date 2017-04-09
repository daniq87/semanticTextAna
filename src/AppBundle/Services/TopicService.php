<?php

namespace AppBundle\Services;

use AppBundle\Entity\Topic;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Description of TopicService
 *
 * @author Daniel
 */
class TopicService {

    const ENTITY_NAME = 'AppBundle:Topic';

    private $em;
    protected $requestStack;

    public function __construct(EntityManager $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function getTopics(&$template) {

        if ($this->requestStack->getCurrentRequest()->isXmlHttpRequest()) {
            $template = "Topic/topicsList.html.twig";
            $topics = $this->findLikeName($_GET['topicName']);
        } else {
            $topics = $this->findAllOrderedByName();
        }

        return $topics;
    }

    /**
     * Get topic by id
     * @param integer $id
     */
    public function findById($id) {
        return $this->em->getRepository(self::ENTITY_NAME)->find($id);
    }

    /**
     * Get topics filtering by topicName
     * @param string $topicName
     * @return array Topic
     */
    public function findLikeName($topicName) {
        return $this->em->getRepository(self::ENTITY_NAME)->findLikeName($topicName);
    }

    /**
     * Get All topics ordered DESC by Id
     * @return array Topic
     */
    public function findAllOrderedByName() {
        return $this->em->getRepository(self::ENTITY_NAME)->findAllOrderedByName();
    }

    /**
     * insert Topic into table topics
     * @param Topic $topic
     */
    public function create(Topic $topic) {
        $this->em->persist($topic);
        $this->em->flush($topic);
    }

    /**
     * Update Topic from table topics
     * @param Topic $topic
     */
    public function update(Topic $topic) {
        $this->em->flush($topic);
    }

    /**
     * Delete topic from table topic
     * @param Topic $topic
     */
    public function delete(Topic $topic) {

        $this->em->remove($topic);
        $this->em->flush();
    }
}
