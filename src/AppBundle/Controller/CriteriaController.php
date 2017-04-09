<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Criteria;
use AppBundle\Form\CriteriaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CriteriaController extends DefaultController {
//    /**
//     * @Route("/criteria/index", name="app_criteria_index")
//     */
//    public function indexAction(Request $request) {
//        $em = $this->getDoctrine()->getManager();
//
//        $template = "Criteria/index.html.twig";
//
//        if ($request->isXMLHttpRequest()) {
//            $template = "Criteria/criterias_list.html.twig";
//            $criteriaName = $_GET['criteriaName'];
//            $attribute = $_GET['attribute'];
//            $topic = $_GET['topic'];
//            $pag = $_GET['pag'];
//            $criterias = $em->getRepository('AppBundle:Criteria')->findLike($topic, $criteriaName, $attribute);
//        } else {
//            $criterias = $em->getRepository('AppBundle:Criteria')->findAllOrderedByTopicName();
//            $pag = $request->query->getInt("page", 1);
//        }
//
//
//
//        // Pagination with knp bundle 
//        $paginator = $this->get("knp_paginator");
//        $pagination = $paginator->paginate(
//                $criterias, $pag, 4
//        );
//
//        $deleteFormAjax = $this->createCustomForm(":OBJECT_ID", "DELETE", "app_criteria_delete");
//
//        return $this->render($template, array('pagination' => $pagination,
//                    "delete_form_ajax" => $deleteFormAjax->createView()));
//    }

    /**
     * @Route("/criteria/add/{topicId}", name="app_criteria_add")
     * @return type
     */
    public function addAction($topicId) {
        $form = $this->getCreateForm(new CriteriaType(), new Criteria(), 'app_criteria_create', array('topicId' => $topicId), 'POST');

        return $this->render('Criteria/criteria_form.html.twig', array(
                    'title' => "New criteria",
                    'actionButton' => "Create criteria",
                    'form' => $form->createView(),
                    'topicId' => $topicId));
    }

    /**
     * @Route("/criteria/create/{topicId}", name="app_criteria_create")
     */
    public function createAction($topicId, Request $request) {
        $criteria = new Criteria();
        $form = $this->getCreateForm(new CriteriaType(), $criteria, 'app_criteria_create', array('topicId' => $topicId), 'POST');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $topic = $this->get('app.topic')->findById($topicId);
            $criteria->setTopic($topic);

            $this->get('app.criteria')->create($criteria);
            $this->addFlash('mensaje', 'The criteria has been created.');

            return $this->redirectToRoute('app_topic_edit', array('id' => $topicId));
        }

        return $this->render('Criteria/criteria_form.html.twig', array(
                    'title' => "New criteria",
                    'actionButton' => "Create criteria",
                    'form' => $form->createView(),
                    'topicId' => $topicId));
    }

    /**
     * @Route("criteria/edit/{id}/{topicId}", name="app_criteria_edit")
     */
    public function editAction($id, $topicId) {

        $criteria = $this->get('app.criteria')->findById($id);
        $this->checkExistEntity($criteria, "Criteria");

        $form = $this->getCreateForm(new CriteriaType(), $criteria, 'app_citeria_update', array('id' => $criteria->getId(), 'topicId' => $topicId), 'POST');
        return $this->render('Criteria/criteria_form.html.twig', array(
                    'title' => "Edit criteria",
                    'actionButton' => "Update criteria",
                    'form' => $form->createView()));
    }

    /**
     * @Route("criteria/update/{id}/{topicId}", name="app_citeria_update" )
     */
    public function updateAction($id, $topicId, Request $request) {
        $criteria = $this->get('app.criteria')->findById($id);

        $this->checkExistEntity($criteria, "Criteria");

        $form = $this->getCreateForm(new CriteriaType(), $criteria, 'app_citeria_update', array('id' => $criteria->getId(), 'topicId' => $topicId), 'POST');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.criteria')->update($criteria);
            $this->addFlash('successMessage', 'The criteria has been modified.');
            return $this->redirectToRoute('app_topic_edit', array('id' => $topicId));
        }
        return $this->render('Criteria/criteria_form.html.twig', array(
                    'title' => "Edit criteria",
                    'actionButton' => "Update criteria",
                    'form' => $form->createView()));
    }

    /**
     * @Route("criteria/delete/{id}", name="app_criteria_delete")
     */
    public function deleteAction($id, Request $request) {
        $criteria = $this->get('app.criteria')->findById($id);
        $this->checkExistEntity($criteria, "Criteria");

        $form = $this->createCustomForm("app_criteria_delete", array('id' => $criteria->getId()), "DELETE");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $request->isXMLHttpRequest()) {
            $this->get('app.criteria')->delete($criteria);

            return new Response(
                    json_encode(array(
                        "notification" => "The criteria has been deleted.")), 200, array("Content-Type" => "application/json")
            );
        }
    }

//    private function getEditForm(Criteria $entity, $topicId) {
//        $form = $this->createForm(new CriteriaType(), $entity, array(
//            'action' => $this->generateUrl('app_citeria_update', array('id' => $entity->getId(), 'topicId' => $topicId )),
//            'method' => 'PUT'));
//
//        return $form;
//    }
//
//    private function createCreateForm(Criteria $entity, $topicId) {
//        $form = $this->createForm(new CriteriaType(), $entity, array(
//            'action' => $this->generateUrl('app_criteria_create', array('topicId' => $topicId)),
//            'method' => 'POST'
//        ));
//
//        return $form;
//    }
//
//    private function createCustomForm($id, $method, $route) {
//        return $this->createFormBuilder()
//                        ->setAction($this->generateUrl($route, array('id' => $id)))
//                        ->setMethod($method)
//                        ->getForm();
//    }
//
//    private function checkExistCriteria(Criteria $criteria) {
//        if (!$criteria) {
//            throw $this->createNotFoundException("Criteria not found");
//        }
//    }
}
