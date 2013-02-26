<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;

/**
 * Acme\FmpsBundle\Entity\Versement
 *
 * @ORM\Table(name="versement")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\VersementRepository")
 * @UniqueEntity("refVirement")
 * @Assert\Callback(methods={"validateDateOperation"})
 * @Assert\Callback(methods={"validateDateValeur"})
 * @ORM\HasLifecycleCallbacks()
 */
class Versement
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
     * @var string $refVirement
     * @Assert\NotBlank
     * @Assert\MinLength(2)
     * @ORM\Column(name="ref_virement", type="string", length=255, nullable=false, unique=true)
     */
    private $refVirement;

    /**
     * @var date $dateOperation
     *
     * @ORM\Column(name="date_operation", type="date", nullable=true)
     */
    private $dateOperation;

    /**
     * @var date $dateValeur
     *
     * @ORM\Column(name="date_valeur", type="date", nullable=true)
     */
    private $dateValeur;  //TODO validate 5 jour de différence entre les deux date

    /**
     * @var integer $montantVirement
     *
     * @ORM\Column(name="montant_virement", type="integer", nullable=true)
     */
    private $montantVirement;

    /**
     * @var decimal $credit
     *
     * @ORM\Column(name="credit", type="decimal", nullable=false)
     */
    private $credit;

    /**
     * @var string $personnePaiement
     *
     * @ORM\Column(name="personne_paiement", type="string", length=250, nullable=true)
     */
    private $personnePaiement;

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
     * Set refVirement
     *
     * @param string $refVirement
     */
    public function setRefVirement($refVirement)
    {
        $this->refVirement = $refVirement;
    }

    /**
     * Get refVirement
     *
     * @return string 
     */
    public function getRefVirement()
    {
        return $this->refVirement;
    }

    /**
     * Set dateOperation
     *
     * @param date $dateOperation
     */
    public function setDateOperation($dateOperation)
    {
        $this->dateOperation = $dateOperation;
    }

    /**
     * Get dateOperation
     *
     * @return date 
     */
    public function getDateOperation()
    {
        return $this->dateOperation;
    }

    /**
     * Set dateValeur
     *
     * @param date $dateValeur
     */
    public function setDateValeur($dateValeur)
    {
        $this->dateValeur = $dateValeur;
    }

    /**
     * Get dateValeur
     *
     * @return date 
     */
    public function getDateValeur()
    {
        return $this->dateValeur;
    }

    /**
     * Set montantVirement
     *
     * @param integer $montantVirement
     */
    public function setMontantVirement($montantVirement)
    {
        $this->montantVirement = $montantVirement;
    }

    /**
     * Get montantVirement
     *
     * @return integer 
     */
    public function getMontantVirement()
    {
        return $this->montantVirement;
    }

    /**
     * Set credit
     *
     * @param decimal $credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }

    /**
     * Get credit
     *
     * @return decimal 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set personnePaiement
     *
     * @param string $personnePaiement
     */
    public function setPersonnePaiement($personnePaiement)
    {
        $this->personnePaiement = $personnePaiement;
    }

    /**
     * Get personnePaiement
     *
     * @return string 
     */
    public function getPersonnePaiement()
    {
        return $this->personnePaiement;
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

		public function validateDateOperation(ExecutionContext $context)
		{
    if ( !empty($this->dateOperation)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->dateOperation->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.dateOperation';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date d\'opération doit être inférieur ou égale à la date d\'aujourd\'hui', array(), null);
			}
    }
		
		}
		
		public function validateDateValeur(ExecutionContext $context)
		{
    if ( !empty($this->dateValeur)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->dateValeur->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.dateValeur';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de valeur doit être inférieur ou égale à la date d\'aujourd\'hui', array(), null);
			}
    }
		
		}
}