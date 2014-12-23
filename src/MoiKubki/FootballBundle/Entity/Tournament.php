<?php

namespace MoiKubki\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MoiKubki\FootballBundle\Entity\TournamentRepository")
 */
class Tournament
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
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sezon", type="string", length=50)
     */
    private $sezon;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="creator", type="integer")
     */
    private $creator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreate", type="date")
     */
    private $dateCreate;

    /**
     * @var array
     *
     * @ORM\Column(name="settings", type="json_array")
     */
    private $settings;

    /**
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="tournament")
     */

    private $stages;

    /**
     * @ORM\OneToMany(targetEntity="TeamFC", mappedBy="tournament")
     */

    private $teams;


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
     * @return Tournament
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
     * Set sezon
     *
     * @param string $sezon
     * @return Tournament
     */
    public function setSezon($sezon)
    {
        $this->sezon = $sezon;
    
        return $this;
    }

    /**
     * Get sezon
     *
     * @return string 
     */
    public function getSezon()
    {
        return $this->sezon;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Tournament
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set creator
     *
     * @param integer $creator
     * @return Tournament
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return integer 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Tournament
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    
        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set settings
     *
     * @param array $settings
     * @return Tournament
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    
        return $this;
    }

    /**
     * Get settings
     *
     * @return array 
     */
    public function getSettings()
    {
        return $this->settings;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->settings = new Settings();
    }

    /**
     * Add stages
     *
     * @param \MoiKubki\FootballBundle\Entity\Stage $stages
     * @return Tournament
     */
    public function addStage(\MoiKubki\FootballBundle\Entity\Stage $stages)
    {
        $this->stages[] = $stages;
    
        return $this;
    }

    /**
     * Remove stages
     *
     * @param \MoiKubki\FootballBundle\Entity\Stage $stages
     */
    public function removeStage(\MoiKubki\FootballBundle\Entity\Stage $stages)
    {
        $this->stages->removeElement($stages);
    }

    /**
     * Get stages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * Add teams
     *
     * @param \MoiKubki\FootballBundle\Entity\TeamsFC $teams
     * @return Tournament
     */
    public function addTeam(\MoiKubki\FootballBundle\Entity\TeamsFC $teams)
    {
        $this->teams[] = $teams;
    
        return $this;
    }

    /**
     * Remove teams
     *
     * @param \MoiKubki\FootballBundle\Entity\TeamsFC $teams
     */
    public function removeTeam(\MoiKubki\FootballBundle\Entity\TeamsFC $teams)
    {
        $this->teams->removeElement($teams);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeams()
    {
        return $this->teams;
    }
}
