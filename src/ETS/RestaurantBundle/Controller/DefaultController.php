<?php

namespace ETS\RestaurantBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ETS\RestaurantBundle\Entity\Restaurant;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    public function addAction(Request $request) {
        
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR')) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        $restaurant = new Restaurant();
        
        $formBuilder = $this->get('form.factory')->createBuilder('form', $restaurant);
        
        $formBuilder
            ->add('name')
            ->add('address')
            ->add('phoneNumber')
            ->add('restaurateur', 'entity', array(
                'class' => 'ETSUserBundle:User',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                       ->select('u')
                       ->from('ETSUserBundle:User', 'u')
                       ->where('u.roles LIKE :role AND u.entrepreneur = :ent')
                       ->setParameter('role', '%"ROLE_RESTAURATEUR"%')
                       ->setParameter('ent', $this->get('security.context')->getToken()->getUser());
                },
                'property' => 'username',
                'required' => false
            ))
            ->add('save', 'submit')
        ;
        
        $form = $formBuilder->getForm();
       
        $form->handleRequest($request);

        if ($form->isValid()) {

            $entrepreneur = $this->get('security.context')->getToken()->getUser();

            $restaurant->setEntrepreneur($entrepreneur);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurant);
            $em->flush();
            
            $message = "Restaurant bien ajouté.";
            if($form['restaurateur']->getData() == '') {
                $message .= " Attention, vous n'avez pas assigné de restaurateur.";
            }

            $request->getSession()->getFlashBag()->add('notice', $message);

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSRestaurantBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function editAction(Request $request, Restaurant $restaurant)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR') || 
            $restaurant->getEntrepreneur() !== $this->get('security.context')->getToken()->getUser()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        $formBuilder = $this->get('form.factory')->createBuilder('form', $restaurant);
        
        $formBuilder
            ->add('name')
            ->add('address')
            ->add('phoneNumber')
            ->add('restaurateur', 'entity', array(
                'class' => 'ETSUserBundle:User',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('v')
                       ->select('u')
                       ->from('ETSUserBundle:User', 'u')
                       ->where('u.roles LIKE :role AND u.entrepreneur = :ent')
                       ->setParameter('role', '%"ROLE_RESTAURATEUR"%')
                       ->setParameter('ent', $this->get('security.context')->getToken()->getUser());
                },
                'property' => 'username',
                'required' => false
            ))
            ->add('save', 'submit')
        ;
        
        $form = $formBuilder->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($restaurant);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Restaurant bien enregistré');

            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        return $this->render('ETSRestaurantBundle:Default:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    public function deleteAction(Request $request, Restaurant $restaurant)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ENTREPRENEUR') || 
            $restaurant->getEntrepreneur() !== $this->get('security.context')->getToken()->getUser()) {
            return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
        }
        
        if ($restaurant != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($restaurant);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('ets_gestion_de_livraisons_index'));
    }
}
