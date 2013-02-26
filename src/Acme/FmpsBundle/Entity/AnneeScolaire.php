<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\AnneeScolaire
 *
 * @ORM\Table(name="annee_scolaire")
 * @ORM\Entity
 * @UniqueEntity("libelleAnneeScolaire")
 * @ORM\HasLifecycleCallbacks()
 */
class AnneeScolaire
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
     * @var string $libelleAnneeScolaire
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle_annee_scolaire", type="string", length=45, nullable=false, unique=true)
     */
    private $libelleAnneeScolaire;

    /**
     * @var date $dateDebutAnneeScolaire
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(name="date_debut_annee_scolaire", type="date", nullable=true)
     */
    private $dateDebutAnneeScolaire;

    /**
     * @var date $dateFinAnneeScolaire
     * @Assert\NotBlank
     * @Assert\Date
     * @ORM\Column(name="date_fin_annee_scolaire", type="date", nullable=true)
     */
    private $dateFinAnneeScolaire;

		/**
     * @var boolean $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;
    
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
     * Set libelleAnneeScolaire
     *
     * @param string $libelleAnneeScolaire
     */
    public function setLibelleAnneeScolaire($libelleAnneeScolaire)
    {
        $this->libelleAnneeScolaire = $libelleAnneeScolaire;
    }

    /**
     * Get libelleAnneeScolaire
     *
     * @return string 
     */
    public function getLibelleAnneeScolaire()
    {
        return $this->libelleAnneeScolaire;
    }

    /**
     * Set dateDebutAnneeScolaire
     *
     * @param date $dateDebutAnneeScolaire
     */
    public function setDateDebutAnneeScolaire($dateDebutAnneeScolaire)
    {
        $this->dateDebutAnneeScolaire = $dateDebutAnneeScolaire;
    }

    /**
     * Get dateDebutAnneeScolaire
     *
     * @return date 
     */
    public function getDateDebutAnneeScolaire()
    {
        return $this->dateDebutAnneeScolaire;
    }

    /**
     * Set dateFinAnneeScolaire
     *
     * @param date $dateFinAnneeScolaire
     */
    public function setDateFinAnneeScolaire($dateFinAnneeScolaire)
    {
        $this->dateFinAnneeScolaire = $dateFinAnneeScolaire;
    }

    /**
     * Get dateFinAnneeScolaire
     *
     * @return date 
     */
    public function getDateFinAnneeScolaire()
    {
        return $this->dateFinAnneeScolaire;
    }

		/**
     * Set active
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
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
     * @ORM\OneToMany(targetEntity="OffreService", mappedBy="anneeScolaire", cascade={"persist"})
     */
    protected $offresServices;

    /**
     * @ORM\OneToMany(targetEntity="Classe", mappedBy="anneeScolaire", cascade={"persist"})
     */
    protected $classes;

		/**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="section")
     */

		/**
     * @ORM\OneToMany(targetEntity="EmployeClasse", mappedBy="employe")
     */
    protected $employeClasses;

    /**
     * @ORM\OneToMany(targetEntity="Preinscription", mappedBy="anneeScolaire", cascade={"persist", "remove"})
     */
    private $preinscriptions;
    
    public function __construct()
    {
        $this->offresServices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
				$this->preinscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add offresServices
     *
     * @param Acme\FmpsBundle\Entity\OffreService $offresServices
     */
    public function addOffreService(\Acme\FmpsBundle\Entity\OffreService $offresServices)
    {
        $this->offresServices[] = $offresServices;
    }

    /**
     * Get offresServices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOffresServices()
    {
        return $this->offresServices;
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

    public function __toString()
    {
        return $this->libelleAnneeScolaire;
    }
}