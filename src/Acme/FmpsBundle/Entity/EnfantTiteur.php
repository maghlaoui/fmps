<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\EnfantTiteur
 *
 * @ORM\Table(name="enfant_titeur")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EnfantTiteurRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EnfantTiteur
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $enfantId
     *
     * @ORM\Column(name="enfant_id", type="integer", nullable=false)
     */
    private $enfantId;

    /**
     * @var integer $titeurId
     *
     * @ORM\Column(name="titeur_id", type="integer", nullable=false)
     */
    private $titeurId;

  	/**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    protected $updatedAt;

	/**
     * @ORM\ManyToOne(targetEntity="Enfant", inversedBy="enfants_titeurs")
     * @ORM\JoinColumn(name="enfant_id", referencedColumnName="id")
     */
    protected $enfant;

	/**
     * @ORM\ManyToOne(targetEntity="Titeur", inversedBy="enfants_titeurs")
     * @ORM\JoinColumn(name="titeur_id", referencedColumnName="id")
     */
    protected $titeur;

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
     * Set enfantId
     *
     * @param integer $enfantId
     */
    public function setEnfantId($enfantId)
    {
        $this->enfantId = $enfantId;
    }

    /**
     * Get enfantId
     *
     * @return integer 
     */
    public function getEnfantId()
    {
        return $this->enfantId;
    }

    /**
     * Set titeurId
     *
     * @param integer $titeurId
     */
    public function setTiteurId($titeurId)
    {
        $this->titeurId = $titeurId;
    }

    /**
     * Get titeurId
     *
     * @return integer 
     */
    public function getTiteurId()
    {
        return $this->titeurId;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

		/**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
      $this->setCreatedAt(new \DateTime());
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

	  /**
     * Set enfant
     *
     * @param Acme\FmpsBundle\Entity\Enfant $enfant
     */
    public function setEnfant(\Acme\FmpsBundle\Entity\Enfant $enfant)
    {
      $this->enfant = $enfant;
    }

    /**
     * Get enfant
     *
     * @return Acme\FmpsBundle\Entity\Enfant 
     */
    public function getEnfant()
    {
      return $this->enfant;
    }

	  /**
     * Set titeur
     *
     * @param Acme\FmpsBundle\Entity\Titeur $titeur
     */
    public function setTiteur(\Acme\FmpsBundle\Entity\Titeur $titeur)
    {
      $this->titeur = $titeur;
    }

    /**
     * Get titeur
     *
     * @return Acme\FmpsBundle\Entity\Titeur 
     */
    public function getTiteur()
    {
      return $this->titeur;
    }

}