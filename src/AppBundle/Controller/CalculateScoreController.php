<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalculateScoreController extends Controller {

    /**
     * @Route("/calculate/index", name="app_calculate_index")
     */
    public function indexAction(Request $request) {
        $reviewDescription = "Across the road from Santa Monica Pier is exactly where you want to be when visiting Santa Monica, as well as not far from lots of shops and restaurants/bars.Hotel itself is very new & modern, rooms were great. Comfortable beds & possibly the best shower ever!";
        $pattern = "/comfortable|easy|excellent|fantastic|friendly/i";


        if (preg_match_all($pattern, $reviewDescription, $matches)) {
            print_r($matches);
        }


//        $sentence="Comfortable beds";
//        $sentence2="rooms were great";
////        $patt="/good.*he|he.*good/i";
//        $patt="/\bcomfortable.*\bbed|bed.*comfortable/i";
//        if (preg_match($patt, $sentence, $matchesAttribute)) {
//            print_r($matchesAttribute);
//        }
//        
//        $patt="/\bgreat.*\broom|\broom.*\bgreat/i";
//        if (preg_match($patt, $sentence2, $matchesAttribute)) {
//            print_r($matchesAttribute);
//        }
        //matches=good price by the
//        $reviewDescription = "Found this hotel by reading over tripadvisor while planning a little beach getaway. Really good price by the beach. James the front desk manager was really fun, he made our stay more fun than we thought it would be. We are going to come back with our friends soon.";
//        $criteria = "he";
//        $attribute = "made our stay";
////        $patt = "/" . $attribute . ".*" . $criteria . "|" . $criteria . ".*" . $attribute . "/i";
//        
//        $patt = "/\b" . $attribute . "\b.*\b" . $criteria . "\b|\b" . $criteria . "\b.*\b" . $attribute . "\b/i";
//
//
//        $reviewSplit = preg_split("/\.|,/", $reviewDescription);
//
//        foreach ($reviewSplit as $review) {
//            if (preg_match($patt, $review, $matchesAttribute)) {
//                print_r($matchesAttribute);
//            }
//        }
//        $reviewDescription = "Across the road from Santa Monica Pier is exactly where you want to be when visiting Santa Monica, as well as not far from lots of shops and restaurants/bars.Hotel itself is very new & modern, rooms were great. Comfortable beds & possibly the best shower ever!";
//        $pattern = "/not far from|great/";
//        
//        if(preg_match_all($pattern, $reviewDescription, $matches)) {
//            foreach ($matches[0] as $match){
//                print_r($match);    
//            }
//            
//            
//        }

        $em = $this->getDoctrine()->getManager();

        $searchQuery = $request->get("filterDescription");
        $filterId = $request->get("filterId");

        if (!empty($searchQuery)) {
            $dql = "SELECT r FROM AppBundle:Review r WHERE  r.description LIKE :filter AND r.id =:id ORDER BY r.id ASC";
            $reviews = $em->createQuery($dql)
                    ->setParameter('filter', '%' . $searchQuery . '%')
                    ->setParameter('id', '4');
        } else {
            $dql = "SELECT r FROM AppBundle:Review r ORDER BY r.id ASC";
            $reviews = $em->createQuery($dql);
        }

        // Pagination with knp bundle 
        $paginator = $this->get("knp_paginator");
        $pagination = $paginator->paginate(
                $reviews, $request->query->getInt("page", 1), 3
        );


        return $this->render('Calculate/index.html.twig', array('pagination' => $pagination));
    }

    /**
     * @Route("/calculate/score", name="app_calculate_score")
     */
    public function calculateAction(Request $request) {


        $reviews = $this->get('app.review')->findAllOrderedById();
        $criterias = $this->get('app.criteria')->findAllOrderedByName();

        $positiveAttributes = $this->get('app.positive')->findAllOrderedByName();
        $negativeAttributes = $this->get('app.negative')->findAllOrderedByName();


        $arrayPositiveRegEx = $this->getRegEx($positiveAttributes);
        $arrayNegativeRegEx = $this->getRegEx($negativeAttributes);

        foreach ($reviews as $review) {
            $score = 0;
            $score = $this->calculateScore($score, $criterias, $arrayPositiveRegEx, $review, true);
            $review->setScore($this->calculateScore($score, $criterias, $arrayNegativeRegEx, $review, false));
            $this->get('app.review')->update($review);
        }

        // Pagination with knp bundle 
        $pagination = $this->get('app.paginator')->getPagination($reviews, $request->query->getInt("page", 1), 3);

        return $this->render('Calculate/index.html.twig', array('pagination' => $pagination));
    }

    private function getRegEx($positiveAttributes) {

        $subArray = array_chunk($positiveAttributes, 5);
        $i = 0;
        $arrayRegEx = array();
        foreach ($subArray as $attributes) {
            $regEx = "/";

            foreach ($attributes as $attribute) {
                if (strlen($regEx) == 1) {
                    $regEx .= $attribute->getName();
                } else {
                    $regEx .= "|" . $attribute->getName();
                }
            }
            $arrayRegEx[$i] = $regEx . "/i";
            $i++;
        }

        return $arrayRegEx;
    }

    private function splitReviewDescription($reviewDescription) {

        $separators = $this->get('app.separator')->findAllOrderedById();

        $pattern = "~";
        $first = true;
        foreach ($separators as $separator) {
            $valueSeparator = $separator->getSeparator();

            if ($valueSeparator == ".") {
                $pattern .= "\\";
            }
            if ($first) {
                $first = false;
                $pattern .= $separator->getIsSymbol() ? $valueSeparator : "\b" . $valueSeparator . "\b";
            } else {
                $pattern .= $separator->getIsSymbol() ? ("|" . $valueSeparator) : ("|" . "\b" . $valueSeparator . "\b");
            }
        }

        $pattern .= "~";

        return preg_split($pattern, $reviewDescription);
    }

    private function setReviewPositiveWords($review, $word) {
        if (empty($review->getPositiveWords())) {
            $review->setPositiveWords($word);
        } else {
            $review->setPositiveWords($review->getPositiveWords() . ", " . $word);
        }
    }

    private function deleteDuplicate($matches) {
        $result = array();
        $i = 0;
        foreach ($matches as $attribute) {
            if (!in_array($attribute, $result)) {
                $result[$i] = strtolower($attribute);
                $i++;
            }
        }
        return $result;
    }

    private function calculateScore($score, $criterias, array $arrayPositiveRegEx, $review, $calculatePositive) {

        $reviewDescription = str_replace(PHP_EOL, '', $review->getDescription());
        $reviewSplit = $this->splitReviewDescription($reviewDescription);

        foreach ($arrayPositiveRegEx as $pattern) {

            if (preg_match_all($pattern, $reviewDescription, $matches)) {

                foreach ($this->deleteDuplicate($matches[0]) as $attribute) {
                    $attributeCriteriaFound = false;

                    foreach ($criterias as $criteria) {
                        $criteriaName = $criteria->getName();
                        foreach ($reviewSplit as $reviewSentence) {

                            //$patt = "/" . $attribute . ".*" . $criteriaName . "|" . $criteriaName . ".*" . $attribute . "/i";
                            $patt = "/\b" . $attribute . ".*\b" . $criteriaName . "|\b" . $criteriaName . ".*\b" . $attribute . "/i";

                            if (preg_match($patt, $reviewSentence, $matchesAttribute)) {

//                                if (str_word_count($matchesAttribute[0]) <= 8) {
                                    $this->setReviewPositiveWords($review, $matchesAttribute[0]);
                                    $attributeCriteriaFound = true;
                                    if ($calculatePositive) {
                                        $score++;
                                    } else {
                                        $score--;
                                    }
//                                }
                            }
                        }
                    }

                    if (!$attributeCriteriaFound) {
                        $x = strrpos($reviewDescription, $attribute);
                        if (strpos($attribute, ' ') !== false && strrpos($reviewDescription, $attribute) !== false) {
                            $this->setReviewPositiveWords($review, $attribute);
                            if ($calculatePositive) {
                                $score++;
                            } else {
                                $score--;
                            }
                        }
                    }
                }
            }
        }


        return $score;
    }

}
