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
                $commande->setState("En attente");
                $commande->setUser($this->get('security.context')->getToken()->getUser());

                $em = $this->getDoctrine()->getManager();
                $em->persist($commande);
                $em->flush();

                $message = "La commande (numéro de commande ".$commande->getId().") a bien été prise en compte.";

                $request->getSession()->getFlashBag()->add('notice', $message);
                
                $message = \Swift_Message::newInstance()
                    ->setSubject('Commande numero '.$commande->getId())
                    ->setFrom('noreplys@justeat2.com')
                    ->setTo($commande->getUser()->getUsername())
                    ->setBody('Votre commande a été enregistrée. Numéro de commande : '.$commande->getId().'. Etat de la commande : '.$commande->getState());
                ;
                $this->get('mailer')->send($message);

                return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
            }
        }
        
        return $this->render('ETSCommandeBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    } 
    
    public function changeStateAction(Commande $commande)
    {
        if ($this->get('security.context')->getToken()->getUser() != $commande->getRestaurant()->getRestaurateur()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        if ($commande->getState() == 'En attente') {
            $commande->setState('En preparation');
        } else if ($commande->getState() == 'En preparation') {
            $commande->setState('Prete');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        
        $message = \Swift_Message::newInstance()
            ->setSubject('Commande numero '.$commande->getId())
            ->setFrom('noreplys@justeat2.com')
            ->setTo($commande->getUser()->getUsername())
            ->setBody('L\'état de votre commande (numéro de commande : '.$commande->getId().') est passé à : '.$commande->getState());
        ;
        $this->get('mailer')->send($message);
    
        return $this->redirect($this->generateUrl('ets_commande_index', array('commande' => $commande->getId())));
    } 
    
    public function indexAction(Commande $commande)
    {
        if ($this->get('security.context')->getToken()->getUser() != $commande->getRestaurant()->getRestaurateur()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }

        return $this->render('ETSCommandeBundle:Default:index.html.twig', array(
          'commande' => $commande
        ));
    } 
}
