<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\DefaultController;
use Symfony\Component\HttpFoundation\Request;

class AttributeController extends DefaultController {

    /**
     * @Route("/attribute/index/{type}", name="app_attribute_index")
     */
    public function indexAction($type = "PositiveAttribute", Request $request) {

        $em = $this->getDoctrine()->getManager();

        $template = "Attribute/index.html.twig";
        $ajaxDeleteAction = "app_positive_attribute_delete";

        if ($request->isXMLHttpRequest()) {
            
            $template = "Attribute/positive_attribute_list.html.twig";
            
            if($type == "NegativeAttribute"){
                $template = "Attribute/negative_attribute_list.html.twig";  
                $ajaxDeleteAction = "app_negative_attribute_delete";
            }

            $positiveName = $_GET['attributeName'];
            $pag = $_GET['pag'];
            $positiveAttributes = $em->getRepository('AppBundle:' . $type)->findLikeName($positiveName);
        } else {
            $positiveAttributes = $em->getRepository('AppBundle:' . $type)->findAllOrderedByName();
            $pag = $request->query->getInt("page", 1);
        }

        $pagination = $this->get('app.paginator')->getPagination($positiveAttributes, $pag, 3);

        $deleteFormAjax = $this->createCustomForm($ajaxDeleteAction, array('id' => ":OBJECT_ID"), "DELETE");

        return $this->render($template, array('pagination' => $pagination,
                    "delete_form_ajax" => $deleteFormAjax->createView()));
    }

}
