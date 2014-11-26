<?php

namespace ETS\CommandeBundle\Controller;

use ETS\CommandeBundle\Entity\Commande;
use ETS\CommandeBundle\Form\CommandeType;
use ETS\RestaurantBundle\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function addAction(Request $request, Restaurant $restaurant)
    {
        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            return $this->redirect($this->generateUrl('login'));
        }
        
        $commande = new Commande();
        
        $form = $this->createForm(new CommandeType($restaurant), $commande);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $commande->setRestaurant($restaurant);
                $commande->setState("EN_ATTENTE");
                $commande->setUser($this->get('security.context')->getToken()->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($commande);
                $em->flush();

                $message = "La commande a bien été prise en compte.";

                $request->getSession()->getFlashBag()->add('notice', $message);

                return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
            }
        }
        
        return $this->render('ETSCommandeBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    } 
}
