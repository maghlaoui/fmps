<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;


/**
 * Acme\FmpsBundle\Entity\Affectation
 *
 * @ORM\Table(name="affectation")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\AffectationRepository")
 * @Assert\Callback(methods={"validateDate"})
 * @ORM\HasLifecycleCallbacks()
 */
class Affectation
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
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

    /**
     * @var date $dateDebutAffectation
     * 
     * @ORM\Column(name="date_debut_affectation", type="date", nullable=true)
     */
    private $dateDebutAffectation;

    /**
     * @var date $dateFinAffectation
     *
     * @ORM\Column(name="date_fin_affectation", type="date", nullable=true)
     */
    private $dateFinAffectation;
    
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
     * Set dateDebutAffectation
     *
     * @param date $dateDebutAffectation
     */
    public function setDateDebutAffectation($dateDebutAffectation)
    {
        $this->dateDebutAffectation = $dateDebutAffectation;
    }

    /**
     * Get dateDebutAffectation
     *
     * @return date 
     */
    public function getDateDebutAffectation()
    {
        return $this->dateDebutAffectation;
    }

    /**
     * Set dateFinAffectation
     *
     * @param date $dateFinAffectation
     */
    public function setDateFinAffectation($dateFinAffectation)
    {
        $this->dateFinAffectation = $dateFinAffectation;
    }

    /**
     * Get dateFinAffectation
     *
     * @return date 
     */
    public function getDateFinAffectation()
    {
        return $this->dateFinAffectation;
    }
	
   /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="affectations", cascade={"persist"})
     * @ORM\JoinColumn(name="employe_id", referencedColumnName="id")
     */
    protected $employe;
	
    /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="affectations", cascade={"persist"})
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

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

		public function ValidateDate(ExecutionContext $context)
		{
    if ( !empty($this->dateDebutAffectation) && !empty($this->dateFinAffectation)  ){
	    $format = 'Y-m-d';
			if( $this->dateFinAffectation->format($format) < $this->dateDebutAffectation->format($format) ) {
			  $propertyPath = $context->getPropertyPath() . '.dateFinAffectation';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de fin doit être supérieur à la date de début', array(), null);
			}
    }
		
		}
}