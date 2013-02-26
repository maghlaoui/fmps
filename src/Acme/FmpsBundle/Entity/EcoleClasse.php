<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\EcoleClasse
 *
 * @ORM\Table(name="ecole_classe")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EcoleClasseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EcoleClasse
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
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

    /**
     * @var integer $classesCount
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/", message="Veuillez saisir un chiffre")
     * @ORM\Column(name="classes_count", type="integer", nullable=true)
     */
    private $classesCount;

		/**
     * @var integer $placesCount
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/", message="Veuillez saisir un chiffre")
     * @ORM\Column(name="places_count", type="integer", nullable=true)
     */
    private $placesCount;
    
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
     * Set classes_count
     *
     * @param integer $classes_count
     */
    public function setClassesCount($classesCount)
    {
        $this->classesCount = $classesCount;
    }

    /**
     * Get classes_count
     *
     * @return integer 
     */
    public function getClassesCount()
    {
        return $this->classesCount;
    }

		/**
     * Set placesCount
     *
     * @param integer $placesCount
     */
    public function setPlacesCount($placesCount)
    {
        $this->placesCount = $placesCount;
    }

    /**
     * Get placesCount
     *
     * @return integer 
     */
    public function getPlacesCount()
    {
        return $this->placesCount;
    }
	
   /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="classes")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;
    
	 /**
	   * @ORM\ManyToOne(targetEntity="AnneeScolaire", inversedBy="classes")
	   * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
	   */
	  protected $anneeScolaire;
    
    
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
        return (string)$this->id;
    }

}