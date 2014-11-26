<?php

namespace ETS\MenuBundle\Controller;

use ETS\MenuBundle\Entity\Menu;
use ETS\MenuBundle\Form\MenuType;
use ETS\RestaurantBundle\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function addAction(Request $request, Restaurant $restaurant)
    {
        if ($this->get('security.context')->getToken()->getUser() != $restaurant->getRestaurateur()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        $menu = new Menu();
        
        $form = $this->createForm(new MenuType(), $menu);
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $menu->setRestaurant($restaurant);

                $em = $this->getDoctrine()->getManager();
                $em->persist($menu);
                $em->flush();

                $message = "Menu bien ajouté.";

                $request->getSession()->getFlashBag()->add('notice', $message);

                return $this->redirect($this->generateUrl('ets_restaurant_index', array('restaurant' => $restaurant->getId())));
            }
        }
        
        return $this->render('ETSMenuBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
        
    }
}
