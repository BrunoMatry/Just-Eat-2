<?php

namespace ETS\CommandeBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SelectionType extends AbstractType
{
    public function __construct($restaurant) {
        $this->restaurant = $restaurant;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('menu', 'entity', array(
                  'class' => 'ETSMenuBundle:Menu',
                  'query_builder' => function(EntityRepository $er) {
                      return $er->createQueryBuilder('v')
                         ->select('m')
                         ->from('ETSMenuBundle:Menu', 'm')
                         ->where('m.restaurant = :restaurant')
                         ->setParameter('restaurant', $this->restaurant);
                  },
                  'property' => 'name'
            ))
            ->add('quantity')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ETS\CommandeBundle\Entity\Selection'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ets_commandebundle_selection';
    }
}
