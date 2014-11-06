<?php

namespace ETS\GestionDeLivraisonsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        
        $retaurants = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('ETSRestaurantBundle:Restaurant')
                           ->getAllRestaurants();
        
        $retaurateurs = $this->getDoctrine()
                             ->getManager()
                             ->getRepository('ETSUserBundle:User')
                             ->findByRole('ROLE_RESTAURATEUR');
        
        return $this->render('ETSGestionDeLivraisonsBundle:Default:index.html.twig', array(
            'restaurants' => $retaurants,
            'restaurateurs' => $retaurateurs
        ));
        
    }
         
}
