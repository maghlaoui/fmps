<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\FmpsBundle\Util\FmpsLists;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\EmployeClasse
 *
 * @ORM\Table(name="employe_classe")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EmployeClasseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EmployeClasse
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
     * @var integer $employeId
     *
     * @ORM\Column(name="employe_id", type="integer", nullable=false)
     */
    private $employeId;

    /**
     * @var integer $classeId
     *
     * @ORM\Column(name="classe_id", type="integer", nullable=false)
     */
    private $classeId;

    /**
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

		/**
	    * @var integer $langues
	    *
	    * @ORM\Column(name="langues", type="integer", nullable=false)
	    */
	   private $langues;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * Set employeId
     *
     * @param integer $employeId
     */
    public function setEmployeId($employeId)
    {
        $this->employeId = $employeId;
    }

    /**
     * Get employeId
     *
     * @return integer 
     */
    public function getEmployeId()
    {
        return $this->employeId;
    }

    /**
     * Set classeId
     *
     * @param integer $classeId
     */
    public function setClasseId($classeId)
    {
        $this->classeId = $classeId;
    }

    /**
     * Get classeId
     *
     * @return integer 
     */
    public function getClasseId()
    {
        return $this->classeId;
    }


    /**
     * Set langues
     *
     * @param integer $langues
     */
    public function setLangues($langues)
    {
        $this->langues = $langues;
    }

    /**
     * Get langues
     *
     * @return integer 
     */
    public function getLangues()
    {
        return $this->langues;
    }

    /**
     * Get languesStr
     *
     * @return string 
     */
    public function getLanguesStr()
    {
				$languages = FmpsLists::getDefaultLanguages();
				
        return $languages[$this->langues];
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
	     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="employeClasses", cascade={"persist"})
	     * @ORM\JoinColumn(name="employe_id", referencedColumnName="id")
	     */
	    protected $employe;

	  /**
	    * @ORM\ManyToOne(targetEntity="Classe", inversedBy="employeClasses", cascade={"persist"})
	    * @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
	    */
	   protected $classe;
	
	  /**
	    * @ORM\ManyToOne(targetEntity="AnneeScolaire", inversedBy="employeClasses", cascade={"persist"})
	    * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
	    */
	   protected $anneeScolaire;

	    /**
	     * Set employe
	     *
	     * @param Acme\FmpsBundle\Entity\Employe $employe
	     */
	    public function setEmploye(\Acme\FmpsBundle\Entity\Employe $employe)
	    {
	        $this->employe = $employe;
	    }

	    /**
	     * Get employe
	     *
	     * @return Acme\FmpsBundle\Entity\Employe
	     */
	    public function getEmploye()
	    {
	        return $this->employe;
	    }

	    /**
	     * Set classe
	     *
	     * @param Acme\FmpsBundle\Entity\Classe $classe
	     */
	    public function setClasse(\Acme\FmpsBundle\Entity\Classe $classe)
	    {
	        $this->classe = $classe;
	    }

	    /**
	     * Get classe
	     *
	     * @return Acme\FmpsBundle\Entity\Classe 
	     */
	    public function getClasse()
	    {
	        return $this->classe;
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
}