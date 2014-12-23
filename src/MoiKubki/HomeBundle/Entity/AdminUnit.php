<?php

namespace MoiKubki\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AdminUnit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MoiKubki\HomeBundle\Entity\AdminUnitRepository")
 */
class AdminUnit
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
     * @ORM\Column(name="country", type="string", length=50)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="adminarea1", type="string", length=50)
     */
    private $adminarea1;

    /**
     * @var string
     *
     * @ORM\Column(name="adminarea2", type="string", length=50)
     */
    private $adminarea2;

    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=50)
     */
    private $locality;

    /**
     * @var string
     *
     * @ORM\Column(name="sublocality", type="string", length=50)
     */
    private $sublocality;

    /**
     * @ORM\OneToMany(targetEntity="MoiKubki\FootballBundle\Entity\TeamFC", mappedBy="adminUnit")
     */
    private $teamsFC;

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
     * Set country
     *
     * @param string $country
     * @return AdminUnit
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set adminarea1
     *
     * @param string $adminarea1
     * @return AdminUnit
     */
    public function setAdminarea1($adminarea1)
    {
        $this->adminarea1 = $adminarea1;
    
        return $this;
    }

    /**
     * Get adminarea1
     *
     * @return string 
     */
    public function getAdminarea1()
    {
        return $this->adminarea1;
    }

    /**
     * Set adminarea2
     *
     * @param string $adminarea2
     * @return AdminUnit
     */
    public function setAdminarea2($adminarea2)
    {
        $this->adminarea2 = $adminarea2;
    
        return $this;
    }

    /**
     * Get adminarea2
     *
     * @return string 
     */
    public function getAdminarea2()
    {
        return $this->adminarea2;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return AdminUnit
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;
    
        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set sublocality
     *
     * @param string $sublocality
     * @return AdminUnit
     */
    public function setSublocality($sublocality)
    {
        $this->sublocality = $sublocality;
    
        return $this;
    }

    /**
     * Get sublocality
     *
     * @return string 
     */
    public function getSublocality()
    {
        return $this->sublocality;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teamsFC = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add teamsFC
     *
     * @param \MoiKubki\FootballBundle\Entity\TeamFC $teamsFC
     * @return AdminUnit
     */
    public function addTeamsFC(\MoiKubki\FootballBundle\Entity\TeamFC $teamsFC)
    {
        $this->teamsFC[] = $teamsFC;
    
        return $this;
    }

    /**
     * Remove teamsFC
     *
     * @param \MoiKubki\FootballBundle\Entity\TeamFC $teamsFC
     */
    public function removeTeamsFC(\MoiKubki\FootballBundle\Entity\TeamFC $teamsFC)
    {
        $this->teamsFC->removeElement($teamsFC);
    }

    /**
     * Get teamsFC
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeamsFC()
    {
        return $this->teamsFC;
    }
}
