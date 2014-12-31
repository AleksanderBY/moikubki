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
    private $administrative_area_level_1;

    /**
     * @var string
     *
     * @ORM\Column(name="adminarea2", type="string", length=50)
     */
    private $administrative_area_level_2;

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
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=40)
     */
    private $google_id;

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

    /**
     * Set administrative_area_level_1
     *
     * @param string $administrativeAreaLevel1
     * @return AdminUnit
     */
    public function setAdministrativeAreaLevel1($administrativeAreaLevel1)
    {
        $this->administrative_area_level_1 = $administrativeAreaLevel1;
    
        return $this;
    }

    /**
     * Get administrative_area_level_1
     *
     * @return string 
     */
    public function getAdministrativeAreaLevel1()
    {
        return $this->administrative_area_level_1;
    }

    /**
     * Set administrative_area_level_2
     *
     * @param string $administrativeAreaLevel2
     * @return AdminUnit
     */
    public function setAdministrativeAreaLevel2($administrativeAreaLevel2)
    {
        $this->administrative_area_level_2 = $administrativeAreaLevel2;
    
        return $this;
    }

    /**
     * Get administrative_area_level_2
     *
     * @return string 
     */
    public function getAdministrativeAreaLevel2()
    {
        return $this->administrative_area_level_2;
    }

    /**
     * Set google_id
     *
     * @param string $googleId
     * @return AdminUnit
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;
    
        return $this;
    }

    /**
     * Get google_id
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }
}
