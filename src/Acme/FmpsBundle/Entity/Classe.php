<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\ClasseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Classe
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
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

     /**
     * @var integer $sectionId
     *
     * @ORM\Column(name="section_id", type="integer", nullable=true)
     */
    private $sectionId;

   	/**
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

    /**
     * @var string $nomClasse
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="nom_classe", type="string", length=125, nullable=true)
     */
    private $nomClasse;

    /**
     * @var integer $nombrePlace
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/", message="Veuillez saisir un chiffre")
     * @ORM\Column(name="nombre_place", type="integer", nullable=true)
     */
    private $nombrePlace;
    
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
     * Set ecoleId
     *
     * @param integer $ecoleId
     */
    public function setEcoleId($ecoleId)
    {
        $this->ecoleId = $ecoleId;
    }

    /**
     * Get ecoleId
     *
     * @return integer 
     */
    public function getEcoleId()
    {
        return $this->ecoleId;
    }

    /**
     * Set sectionId
     *
     * @param integer $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * Get sectionId
     *
     * @return integer 
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * Set anneeScolaireId
     *
     * @param integer $anneeScolaireId
     */
    public function setAnneeScolaireId($anneeScolaireId)
    {
        $this->anneeScolaireId = $anneeScolaireId;
    }

    /**
     * Get anneeScolaireId
     *
     * @return integer 
     */
    public function getAnneeScolaireId()
    {
        return $this->anneeScolaireId;
    }

    /**
     * Set nomClasse
     *
     * @param string $nomClasse
     */
    public function setNomClasse($nomClasse)
    {
        $this->nomClasse = $nomClasse;
    }

    /**
     * Get nomClasse
     *
     * @return string 
     */
    public function getNomClasse()
    {
        return $this->nomClasse;
    }

    /**
     * Set nombrePlace
     *
     * @param integer $nombrePlace
     */
    public function setNombrePlace($nombrePlace)
    {
        $this->nombrePlace = $nombrePlace;
    }

    /**
     * Get nombrePlace
     *
     * @return integer 
     */
    public function getNombrePlace()
    {
        return $this->nombrePlace;
    }
	
   /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="classes")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;
    
    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="classes")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    protected $section;

    /**
     * @ORM\ManyToOne(targetEntity="AnneeScolaire", inversedBy="classes")
     * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
     */
    protected $anneeScolaire;

		/**
     * @ORM\OneToMany(targetEntity="EmployeClasse", mappedBy="employe", cascade={"persist"})
     */
    protected $employeClasses;

    public function __construct()
    {
			$this->setNombrePlace(25);
    }
    
    
    /**
     * Set ecole
     *
     * @param Acme\FmpsBundle\Entity\Ecole $ecole
     */
    public function setEcole(\Acme\FmpsBundle\Entity\Ecole $ecole)
    {
        $this->ecole = $ecole;
    }

    /**
     * Get ecole
     *
     * @return Acme\FmpsBundle\Entity\Ecole 
     */
    public function getEcole()
    {
        return $this->ecole;
    }

    /**
     * Set section
     *
     * @param Acme\FmpsBundle\Entity\Section $section
     */
    public function setSection(\Acme\FmpsBundle\Entity\Section $section = null)
    {
        $this->section = $section;
    }

    /**
     * Get section
     *
     * @return Acme\FmpsBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set anneeScolaire
     *
     * @param Acme\FmpsBundle\Entity\AnneeScolaire $anneeScolaire
     */
    public function setAnneeScolaire(\Acme\FmpsBundle\Entity\AnneeScolaire $anneeScolaire)
    {
        $this->anneeScolaire = $anneeScolaire;
    }

    /**
     * Get anneeScolaire
     *
     * @return Acme\FmpsBundle\Entity\AnneeScolaire 
     */
    public function getAnneeScolaire()
    {
        return $this->anneeScolaire;
    }

		public function __toString()
    {
        return $this->nomClasse;
    }

}