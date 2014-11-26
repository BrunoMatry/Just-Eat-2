<?php

namespace ETS\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ETS\MenuBundle\Entity\MenuRepository")
 */
class Menu
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
     * @ORM\ManyToOne(targetEntity="ETS\RestaurantBundle\Entity\Restaurant")
     */
    private $restaurant;

    /**
    * @ORM\OneToMany(targetEntity="Plat", mappedBy="menu", cascade={"persist"})
    */
    private $plats = array();


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
     * @return Menu
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
     * Set restaurant
     *
     * @param string $restaurant
     * @return Menu
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return string 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set plats
     *
     * @param Plat $plats
     * @return Menu
     */
    public function setPlats($plats)
    {
        foreach ($plats as $plat) {
            $plat->setMenu($this);
        }

        $this->plats = $plats;

        return $this;
    }

    /**
     * Get plats
     *
     * @return Plat 
     */
    public function getPlats()
    {
        return $this->plats;
    }
}
