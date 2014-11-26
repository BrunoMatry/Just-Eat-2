<?php

namespace ETS\CommandeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Selection
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ETS\CommandeBundle\Entity\SelectionRepository")
 */
class Selection
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
     * @ORM\ManyToOne(targetEntity="ETS\MenuBundle\Entity\Menu")
     */
    private $menu;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="selection")
     */
    private $commande;

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
     * Set menu
     *
     * @param string $menu
     * @return Selection
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return string 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Selection
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    /**
     * Set commande
     *
     * @param Commande $commande
     * @return Selection
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return Commande 
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
