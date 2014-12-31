<?php

namespace MoiKubki\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stage
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MoiKubki\FootballBundle\Entity\StageRepository")
 */
class Stage
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
     * @ORM\OneToOne(targetEntity="Stage")
     *
     */
    private $prev;

    /**
     *
     * @ORM\OneToOne(targetEntity="Stage")
     *
     */
    private $next;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="stages")
     */
    private $tournament;

    /**
     *
     * @ORM\OneToMany(targetEntity="Group", mappedBy="stage")
     *
     */
    private $groups;

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
     * @return Stage
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
     * Set tournament
     *
     * @param \MoiKubki\FootballBundle\Entity\Tournament $tournament
     * @return Stage
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add groups
     *
     * @param \MoiKubki\FootballBundle\Entity\Group $groups
     * @return Stage
     */
    public function addGroup(\MoiKubki\FootballBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \MoiKubki\FootballBundle\Entity\Group $groups
     */
    public function removeGroup(\MoiKubki\FootballBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set prev
     *
     * @param \MoiKubki\FootballBundle\Entity\Stage $prev
     * @return Stage
     */
    public function setPrev(\MoiKubki\FootballBundle\Entity\Stage $prev = null)
    {
        $this->prev = $prev;
    
        return $this;
    }

    /**
     * Get prev
     *
     * @return \MoiKubki\FootballBundle\Entity\Stage 
     */
    public function getPrev()
    {
        return $this->prev;
    }

    /**
     * Set next
     *
     * @param \MoiKubki\FootballBundle\Entity\Stage $next
     * @return Stage
     */
    public function setNext(\MoiKubki\FootballBundle\Entity\Stage $next = null)
    {
        $this->next = $next;
    
        return $this;
    }

    /**
     * Get next
     *
     * @return \MoiKubki\FootballBundle\Entity\Stage 
     */
    public function getNext()
    {
        return $this->next;
    }
}
