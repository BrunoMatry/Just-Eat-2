<?php

namespace ETS\GestionDeLivraisonsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction() {
        
        return $this->render('ETSGestionDeLivraisonsBundle:Default:index.html.twig', array());
        
    }
         
}
