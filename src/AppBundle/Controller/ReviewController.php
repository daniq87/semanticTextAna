<?php

namespace AppBundle\Controller;

use AppBundle\Controller\DefaultController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;

class ReviewController extends DefaultController {

    /**
     * @Route("/review/index", name="app_review_index")
     */
    public function indexAction(Request $request) {
        
        $fileHandle = fopen("C:\\Datos\\Daniel\\Desarrollo\\symfony\\semantictextanalysis\\src\\AppBundle\\Controller\\Reviews.csv", "r");
                
        while (($row = fgetcsv($fileHandle, 0, ",")) !== FALSE) {
            //Print out my column data.
            print_r($row[0]);
        }

        $template = "Review/index.html.twig";
        $reviews = $this->get('app.review')->ajax($template);

        // Pagination with knp bundle 
        $pag = $request->isXmlHttpRequest() ? $_GET['pag'] : $request->query->getInt("page", 1);
        $pagination = $this->get('app.paginator')->getPagination($reviews, $pag, 3);
        // get deleteFormAjax
        $deleteFormAjax = $this->createCustomForm("app_review_delete", array('id' => ":OBJECT_ID"), "DELETE");

        return $this->render($template, array('pagination' => $pagination,
                    "delete_form_ajax" => $deleteFormAjax->createView()));
    }

    /**
     * @Route("/review/add", name="app_review_add")
     */
    public function addAction() {
        $form = $this->getCreateForm(new ReviewType(), new Review(), 'app_review_create', null, 'POST');

        return $this->render('Review/review_form.html.twig', array(
                    'title' => "New review",
                    'actionButton' => "Create review",
                    'form' => $form->createView()));
    }

    /**
     * @Route("/review/create", name="app_review_create")
     */
    public function createAction(Request $request) {
        $review = new Review();
        $form = $this->getCreateForm(new ReviewType(), $review, 'app_review_create', null, 'POST');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('app.review')->create($review);
            $this->addFlash('successMessage', 'The review has been created.');
            return $this->redirectToRoute('app_review_index');
        }

        return $this->render('Review/review_form.html.twig', array(
                    'title' => "New review",
                    'actionButton' => "Create review",
                    'form' => $form->createView()));
    }

    /**
     * @Route("review/edit/{id}", name="app_review_edit")
     */
    public function editAction($id) {

        $review = $this->get('app.review')->findById($id);
        $this->checkExistEntity($review, "Review");
        $form = $this->getCreateForm(new ReviewType(), $review, 'app_review_update', array('id' => $review->getId()), 'POST');

        return $this->render('Review/review_form.html.twig', array(
                    'title' => "Edit review",
                    'actionButton' => "Update review",
                    'form' => $form->createView()));
    }

    /**
     * @Route("review/update/{id}", name="app_review_update" )
     */
    public function updateAction($id, Request $request) {
        $review = $this->get('app.review')->findById($id);
        $this->checkExistEntity($review, "Review");

        $form = $this->getCreateForm(new ReviewType(), $review, 'app_review_update', array('id' => $review->getId()), 'POST');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('app.review')->update($review);
            $this->addFlash('successMessage', 'The review has been modified.');
            return $this->redirectToRoute('app_review_edit', array('id' => $review->getId()));
        }
        
        return $this->render('Review/review_form.html.twig', array(
                    'title' => "Edit review",
                    'actionButton' => "Update review",
                    'form' => $form->createView()));
    }

    /**
     * @Route("review/delete/{id}", name="app_review_delete")
     */
    public function deleteAction($id, Request $request) {
        $review = $this->get('app.review')->findById($id);
        $this->checkExistEntity($review, "Review");

        $form = $this->createCustomForm("app_review_delete", array('id' => $review->getId()), "DELETE");
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isXMLHttpRequest()) {
                $this->get('app.review')->delete($review);
                return new Response(
                        json_encode(array(
                            "notification" => "The review has been deleted.")), 200, array("Content-Type" => "application/json")
                );
            }
        }
    }

}
