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
            ->add('username', 'text')
            ->add('birth_date', 'date')
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
    
    public function addRestaurateurAction(Request $request) {
        
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR')) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        $user = new User();
        
        $formBuilder = $this->get('form.factory')->createBuilder('form', $user);
        
        $formBuilder
            ->add('username', 'text')
            ->add('birth_date', 'date')
            ->add('phone_number', 'text')
            ->add('address', 'text')
            ->add('password', 'password')
            ->add('save', 'submit')
        ;
       
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user->addRole('ROLE_RESTAURATEUR');
            
            $entrepreneur = $this->get('security.context')->getToken()->getUser();

            $user->setEntrepreneur($entrepreneur);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Restaurateur bien enregistré');

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSUserBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function editRestaurateurAction(Request $request, User $restaurateur)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR') || 
            $restaurateur->getEntrepreneur() !== $this->get('security.context')->getToken()->getUser()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        $form = $this->createForm(new UserType, $restaurateur);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurateur);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Restaurateur bien enregistré');

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSUserBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));     
        
    }
    
    public function deleteRestaurateurAction(Request $request, User $restaurateur)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR') || 
            $restaurateur->getEntrepreneur() !== $this->get('security.context')->getToken()->getUser()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        if ($restaurateur != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($restaurateur);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
    }
}
