<?php

namespace MoiKubki\FootballBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupt
 *
 * @ORM\Table(name="Groupt")
 * @ORM\Entity(repositoryClass="MoiKubki\FootballBundle\Entity\GroupRepository")
 */
class Group
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
     * @ORM\ManyToOne(targetEntity="Stage", inversedBy="groups")
     *
     */
    private $stage;


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
     * @return Group
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
     * Set stage
     *
     * @param \MoiKubki\FootballBundle\Entity\Stage $stage
     * @return Group
     */
    public function setStage(\MoiKubki\FootballBundle\Entity\Stage $stage = null)
    {
        $this->stage = $stage;
    
        return $this;
    }

    /**
     * Get stage
     *
     * @return \MoiKubki\FootballBundle\Entity\Stage 
     */
    public function getStage()
    {
        return $this->stage;
    }
}
