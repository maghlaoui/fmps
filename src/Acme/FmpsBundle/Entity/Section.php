<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Acme\FmpsBundle\Entity\Section
 *
 * @ORM\Table(name="section_ecole")
 * @ORM\Entity
 * @UniqueEntity("libelleSection")
 * @ORM\HasLifecycleCallbacks()
 */
class Section
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
     * @var string $libelleSection
     *
     * @ORM\Column(name="libelle_section", type="string", length=125, nullable=false, unique=true)
     */
    private $libelleSection;

    /**
     * @var string $dimSection
     *
     * @ORM\Column(name="dim_section", type="string", length=45, nullable=true)
     */
    private $dimSection;
    
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
     * Set libelleSection
     *
     * @param string $libelleSectionSection
     */
    public function setLibelleSection($libelleSection)
    {
        $this->libelleSection = $libelleSection;
    }

    /**
     * Get libelleSection
     *
     * @return string 
     */
    public function getLibelleSection()
    {
        return $this->libelleSection;
    }

    /**
     * Set dimSection
     *
     * @param string $dimSection
     */
    public function setDimSection($dimSection)
    {
        $this->dimSection = $dimSection;
    }

    /**
     * Get dimSection
     *
     * @return string 
     */
    public function getDimSection()
    {
        return $this->dimSection;
    }
    
    public function __toString()
    {
        return $this->libelleSection;
    }

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="section")
     */
    protected $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity="Classe", mappedBy="section")
     */
    protected $classes;

    /**
     * @ORM\OneToMany(targetEntity="Preinscription", mappedBy="section", cascade={"persist", "remove"})
     */
    private $preinscriptions;

		public function __construct()
    {
        $this->inscriptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
				$this->preinscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add inscription
     *
     * @param Acme\FmpsBundle\Entity\Inscription $inscription
     */
    public function addInscription(\Acme\FmpsBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;
    }

    /**
     * Get inscriptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * Add classe
     *
     * @param Acme\FmpsBundle\Entity\Classe $classe
     */
    public function addClasse(\Acme\FmpsBundle\Entity\Classe $classe)
    {
        $this->classes[] = $classe;
    }

    /**
     * Get classes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getClasses()
    {
        return $this->classes;
    }

   /**
     * Add preinscription
     *
     * @param Acme\FmpsBundle\Entity\Preinscription $preinscription
     */
    public function addPreinscription(\Acme\FmpsBundle\Entity\Preinscription $preinscription)
    {
        $this->preinscriptions[] = $preinscription;
    }

    /**
     * Get preinscriptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPreinscriptions()
    {
        return $this->preinscriptions;
    }
}