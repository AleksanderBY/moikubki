<?php

namespace MoiKubki\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MoiKubki\HomeBundle\Entity\AdminUnit;

/**
 * TeamFC
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MoiKubki\FootballBundle\Entity\TeamFCRepository")
 */
class TeamFC
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     *
     * @ORM\ManyToOne(targetEntity="MoiKubki\HomeBundle\Entity\AdminUnit", inversedBy="TeamsFC")
     *
     */
    private $adminUnit;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="teams")
     *
     */
    private $tournament;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->adminUnit = new AdminUnit();
    }

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
     * @return TeamFC
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
     * Set adminUnit
     *
     * @param \MoiKubki\HomeBundle\Entity\AdminUnit $adminUnit
     * @return TeamFC
     */
    public function setAdminUnit(\MoiKubki\HomeBundle\Entity\AdminUnit $adminUnit = null)
    {
        $this->adminUnit = $adminUnit;
    
        return $this;
    }

    /**
     * Get adminUnit
     *
     * @return \MoiKubki\HomeBundle\Entity\AdminUnit 
     */
    public function getAdminUnit()
    {
        return $this->adminUnit;
    }

    /**
     * Set tournament
     *
     * @param \MoiKubki\FootballBundle\Entity\Tournament $tournament
     * @return TeamFC
     */
    public function setTournament(\MoiKubki\FootballBundle\Entity\Tournament $tournament = null)
    {
        $this->tournament = $tournament;
    
        return $this;
    }

    /**
     * Get tournament
     *
     * @return \MoiKubki\FootballBundle\Entity\Tournament 
     */
    public function getTournament()
    {
        return $this->tournament;
    }
}
