<?php

namespace ETS\UserBundle\Controller;

use ETS\UserBundle\Entity\User;
use ETS\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{ 
    public function addAction(Request $request) {
        $user = new User();
        
        $formBuilder = $this->get('form.factory')->createBuilder('form', $user);
        
        $formBuilder
            ->add('username', 'email')
            ->add('birth_date', 'date', array('years' => range(1900, 2014)))
            ->add('phone_number', 'text')
            ->add('address', 'text')
            ->add('password', 'password')
            ->add('entrepreneur', 'checkbox', array(
                'label' => 'Entrepreneur?',
                'required' => false,
                'mapped' => false
            ))
            ->add('save', 'submit')
        ;
        
        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            if($form['entrepreneur']->getData()) {
                $user->addRole('ROLE_ENTREPRENEUR');
            } else {
                $user->addRole('ROLE_USER');
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'User bien enregistré');

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSUserBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function editAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createForm(new UserType, $user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'User bien enregistré');

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSUserBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function privateAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        
        if($this->get('security.context')->isGranted('ROLE_ENTREPRENEUR')) {
            $restaurants = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('ETSRestaurantBundle:Restaurant')
                                ->findByEntrepreneur($user);
            $restaurateurs = $this->getDoctrine()
                                  ->getManager()
                                  ->getRepository('ETSUserBundle:User')
                                  ->findByEntrepreneur($user);       
        } else if($this->get('security.context')->isGranted('ROLE_RESTAURATEUR')) {
            $restaurants = $this->getDoctrine()
                                ->getManager()
                                ->getRepository('ETSRestaurantBundle:Restaurant')
                                ->findByRestaurateur($user);  
            $restaurateurs = array();
        }
        else {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSUserBundle:Default:private.html.twig', array(
          'restaurants' => $restaurants,
          'restaurateurs' => $restaurateurs,
        ));
    }
}
