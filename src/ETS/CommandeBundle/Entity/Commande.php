<?php

namespace ETS\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ETS\CommandeBundle\Entity\CommandeRepository")
 */
class Commande
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
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="ETS\RestaurantBundle\Entity\Restaurant")
     */
    private $restaurant;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="ETS\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Selection", mappedBy="commande", cascade={"persist"})
     */
    private $selection = array();

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;


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
     * Set restaurant
     *
     * @param \stdClass $restaurant
     * @return Commande
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \stdClass 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     * @return Commande
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set selection
     *
     * @param array $selection
     * @return Commande
     */
    public function setSelection($selection)
    {
        foreach ($selection as $s) {
            $s->setCommande($this);
        }

        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return array 
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Commande
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Commande
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
}
