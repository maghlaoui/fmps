<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\EmployeFonction
 *
 * @ORM\Table(name="employe_fonction")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EmployeFonctionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EmployeFonction
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
     * @var integer $fonctionId
     *
     * @ORM\Column(name="fonction_id", type="integer", nullable=false)
     */
    private $fonctionId;

    /**
     * @var date $dateDebutFonction
     * 
     * @ORM\Column(name="date_debut_fonction", type="date", nullable=true)
     */
    private $dateDebutFonction;

    /**
     * @var date $dateFinFonction
     *
     * @ORM\Column(name="date_fin_fonction", type="date", nullable=true)
     */
    private $dateFinFonction;
    
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
     * Set fonctionId
     *
     * @param integer $fonctionId
     */
    public function setFonctionId($fonctionId)
    {
        $this->fonctionId = $fonctionId;
    }

    /**
     * Get fonctionId
     *
     * @return integer 
     */
    public function getFonctionId()
    {
        return $this->fonctionId;
    }

    /**
     * Set dateDebutFonction
     *
     * @param date $dateDebutFonction
     */
    public function setDateDebutFonction($dateDebutFonction)
    {
        $this->dateDebutFonction = $dateDebutFonction;
    }

    /**
     * Get dateDebutFonction
     *
     * @return date 
     */
    public function getDateDebutFonction()
    {
        return $this->dateDebutFonction;
    }

    /**
     * Set dateFinFonction
     *
     * @param date $dateFinFonction
     */
    public function setDateFinFonction($dateFinFonction)
    {
        $this->dateFinFonction = $dateFinFonction;
    }

    /**
     * Get dateFinFonction
     *
     * @return date 
     */
    public function getDateFinFonction()
    {
        return $this->dateFinFonction;
    }
	
   /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="fonctions", cascade={"persist"})
     * @ORM\JoinColumn(name="employe_id", referencedColumnName="id")
     */
    protected $employe;
	
    /**
     * @ORM\ManyToOne(targetEntity="Fonction", inversedBy="fonctions", cascade={"persist"})
     * @ORM\JoinColumn(name="fonction_id", referencedColumnName="id")
     */
    protected $fonction;

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
     * Set fonction
     *
     * @param Acme\FmpsBundle\Entity\Fonction $fonction
     */
    public function setFonction(\Acme\FmpsBundle\Entity\Fonction $fonction)
    {
        $this->fonction = $fonction;
    }

    /**
     * Get fonction
     *
     * @return Acme\FmpsBundle\Entity\Fonction 
     */
    public function getFonction()
    {
        return $this->fonction;
    }
}