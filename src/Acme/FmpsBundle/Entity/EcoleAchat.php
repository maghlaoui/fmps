<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;

/**
 * Acme\FmpsBundle\Entity\EcoleAchat
 *
 * @ORM\Table(name="ecole_achat")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EcoleAchatRepository")
 * @Assert\Callback(methods={"validateDate"})
 * @Assert\Callback(methods={"validateDatePaiement"})
 * @ORM\HasLifecycleCallbacks()
 */
class EcoleAchat
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
     * @var string $modePayement
     *
     * @ORM\Column(name="mode_payement", type="string", length=125, nullable=false)
     */
    private $modePayement;

		/**
     * @var string $numeroCheque
     *
     * @ORM\Column(name="numero_cheque", type="string", length=125, nullable=false)
     */
    private $numeroCheque;

    /**
     * @var date $date
     * @Assert\Date
     * @ORM\Column(name="date_facture", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string $objet
     *
     * @ORM\Column(name="objet", type="string", nullable=true)
     */
    private $objet;

    /**
     * @var float $montant
     *
     * @ORM\Column(name="montant", type="float", nullable=false)
     */
    private $montant;

    /**
     * @var string $fournisseur
     *
     * @ORM\Column(name="fournisseur", type="string", length=45, nullable=true)
     */
    private $fournisseur;

    /**
     * @var integer $budgetId
     *
     * @ORM\Column(name="budget_id", type="integer", nullable=false)
     */
    private $budgetId;

    /**
     * @var string $numFacture
     *
     * @ORM\Column(name="num_facture", type="string", length=45, nullable=true)
     */
    private $numFacture;

    /**
     * @var string $etatFacture
     *
     * @ORM\Column(name="etat_facture", type="string", length=45, nullable=false)
     */
    private $etatFacture;

    /**
     * @var date $datePaiementFacture
     *
     * @ORM\Column(name="date_paiement_facture", type="date", nullable=true)
     */
    private $datePaiementFacture; //TODO validate if etat facture chèque ou virement

    /**
     * @var integer $situationCaisseId
     *
     * @ORM\Column(name="situation_caisse_id", type="integer", nullable=true)
     */
    private $situationCaisseId;

    /**
     * @var string $fichier
     *
     * @ORM\Column(name="fichier", type="string", length=125, nullable=true)
     */
    private $fichier;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=125, nullable=true)
     */
    private $path;

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
     * Set modePayement
     *
     * @param string $modePayement
     */
    public function setModePayement($modePayement)
    {
        $this->modePayement = $modePayement;
    }

    /**
     * Get modePayement
     *
     * @return string 
     */
    public function getModePayement()
    {
        return $this->modePayement;
    }

		/**
     * Set numeroCheque
     *
     * @param string $numeroCheque
     */
    public function setNumeroCheque($numeroCheque)
    {
        $this->numeroCheque = $numeroCheque;
    }

    /**
     * Get numeroCheque
     *
     * @return string 
     */
    public function getNumeroCheque()
    {
        return $this->numeroCheque;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set objet
     *
     * @param string $objet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
    }

    /**
     * Get objet
     *
     * @return string 
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set montant
     *
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set fournisseur
     *
     * @param string $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * Get fournisseur
     *
     * @return string 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set budgetId
     *
     * @param integer $budgetId
     */
    public function setBudgetId($budgetId)
    {
        $this->budgetId = $budgetId;
    }

    /**
     * Get budgetId
     *
     * @return integer 
     */
    public function getBudgetId()
    {
        return $this->budgetId;
    }

    /**
     * Set numFacture
     *
     * @param string $numFacture
     */
    public function setNumFacture($numFacture)
    {
        $this->numFacture = $numFacture;
    }

    /**
     * Get numFacture
     *
     * @return string 
     */
    public function getNumFacture()
    {
        return $this->numFacture;
    }

    /**
     * Set etatFacture
     *
     * @param string $etatFacture
     */
    public function setEtatFacture($etatFacture)
    {
        $this->etatFacture = $etatFacture;
    }

    /**
     * Get etatFacture
     *
     * @return string 
     */
    public function getEtatFacture()
    {
        return $this->etatFacture;
    }

    /**
     * Set datePaiementFacture
     *
     * @param date $datePaiementFacture
     */
    public function setDatePaiementFacture($datePaiementFacture)
    {
        $this->datePaiementFacture = $datePaiementFacture;
    }

    /**
     * Get datePaiementFacture
     *
     * @return date 
     */
    public function getDatePaiementFacture()
    {
        return $this->datePaiementFacture;
    }

    /**
     * Set situationCaisseId
     *
     * @param integer $situationCaisseId
     */
    public function setSituationCaisseId($situationCaisseId)
    {
        $this->situationCaisseId = $situationCaisseId;
    }

    /**
     * Get cloturerFacture
     *
     * @return integer 
     */
    public function getSituationCaisseId()
    {
        return $this->situationCaisseId;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * Get fichier
     *
     * @return string 
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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

		public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return  __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/achat';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'facture_'.uniqid().'.'.$this->fichier->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->fichier) {
            return;
        }

        $this->fichier->move($this->getUploadRootDir(), $this->path);
        unset($this->fichier);
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fichier = $this->getAbsolutePath();
        if ( file_exists($fichier)) unlink($fichier);
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
     * @ORM\ManyToOne(targetEntity="Budget")
     * @ORM\JoinColumn(name="budget_id", referencedColumnName="id")
     */
    protected $budget;

		  /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="factures")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

    /**
     * @ORM\ManyToOne(targetEntity="SituationCaisse")
     * @ORM\JoinColumn(name="situation_caisse_id", referencedColumnName="id")
     */
    protected $situationCaisse;

		/**
     * Set budget
     *
     * @param Acme\FmpsBundle\Entity\Budget $budget
     */
    public function setBudget(\Acme\FmpsBundle\Entity\Budget $budget)
    {
        $this->budget = $budget;
    }

   /**
     * Get budget
     *
     * @return Acme\FmpsBundle\Entity\Budget 
     */
    public function getBudget()
    {
        return $this->budget;
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
	   * Set situationCaisse
	   *
	   * @param Acme\FmpsBundle\Entity\SituationCaisse $situationCaisse
	   */
    public function setSituationCaisse(\Acme\FmpsBundle\Entity\SituationCaisse $situationCaisse = null)
    {
        $this->situationCaisse = $situationCaisse;
    }

    /**
     * Get situationCaisse
     *
     * @return Acme\FmpsBundle\Entity\SituationCaisse
     */
    public function getSituationCaisse()
    {
        return $this->situationCaisse;
    }

		public function ValidateDate(ExecutionContext $context)

		{
    if ( !empty($this->date)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->date->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.date';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date doit être inférieur ou égale à celle d\'aujourd\'hui', array(), null);
			}
    }
		
		}
		
		public function ValidateDatePaiement(ExecutionContext $context)

		{
    if ( !empty($this->datePaiement)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->datePaiement->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.datePaiement';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de paiement doit être inférieur ou égale à celle d\'aujourd\'hui', array(), null);
			}
    }
		
		}


}