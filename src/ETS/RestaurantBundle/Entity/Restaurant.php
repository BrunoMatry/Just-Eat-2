<?php

namespace ETS\RestaurantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Restaurant
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ETS\RestaurantBundle\Entity\RestaurantRepository")
 */
class Restaurant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;
    
    /**
     * @var string
     * 
     * @ORM\ManyToOne(targetEntity="ETS\UserBundle\Entity\User", inversedBy="restaurants")
     * @ORM\JoinColumn(name="restaurateur_id", referencedColumnName="id")
     */
    private $restaurateur;
    
    /**
     * @var string
     * 
     * @ORM\ManyToOne(targetEntity="ETS\UserBundle\Entity\User")
     */
    private $entrepreneur;
    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set name
     *
     * @param string $name
     * @return Restaurant
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set address
     *
     * @param string $address
     * @return Restaurant
     */
    public function setAddress($address)
    {
        $this->address = $address;
        
        return $this;
    }
    
    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return Restaurant
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        
        return $this;
    }
    
    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    
    /**
     * Set restaurateur
     *
     * @param string $restaurateur
     * @return Restaurant
     */
    public function setRestaurateur($restaurateur)
    {
        $this->restaurateur = $restaurateur;
        
        return $this;
    }
    
    /**
     * Get restaurateur
     *
     * @return string 
     */
    public function getRestaurateur()
    {
        return $this->restaurateur;
    }
    
    /**
     * Set entrepreneur
     *
     * @param ETS\UserBundle\Entity\User $entrepreneur
     * @return Restaurant
     */
    public function setEntrepreneur($entrepreneur)
    {
        $this->entrepreneur = $entrepreneur;
        
        return $this;
    }
    
    /**
     * Get entrepreneur
     *
     * @return ETS\UserBundle\Entity\User 
     */
    public function getEntrepreneur()
    {
        return $this->entrepreneur;
    }
}