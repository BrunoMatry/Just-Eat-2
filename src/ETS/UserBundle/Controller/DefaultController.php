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
}
