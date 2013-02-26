<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;

/**
 * Acme\FmpsBundle\Entity\Eauelectricite
 *
 * @ORM\Table(name="ecole_eauelectricite")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EauelectriciteRepository")
 * @UniqueEntity("numfacture")
 * @Assert\Callback(methods={"checkDate"})
 * @ORM\HasLifecycleCallbacks()
 */
class Eauelectricite
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
     * @var string $fournisseur
     *
     * @ORM\Column(name="fournisseur", type="string", length=125, nullable=false)
     */
    private $fournisseur;

    /**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

    /**
     * @var integer $budgetId
     *
     * @ORM\Column(name="budget_id", type="integer", nullable=false)
     */
    private $budgetId;

    /**
     * @var string $service
     *
     * @ORM\Column(name="service", type="string", nullable=false)
     */
    private $service;

    /**
     * @var string $numfacture
     *
     * @ORM\Column(name="numfacture", type="string", nullable=false)
     */
    private $numfacture;

    /**
     * @var date $datefacture
     *
     * @ORM\Column(name="datefacture", type="date", nullable=false)
     */
    private $datefacture;

    /**
     * @var string $modefacturation
     *
     * @ORM\Column(name="modefacturation", type="string", nullable=false)
     */
    private $modefacturation;

    /**
     * @var date $periodedebut
     *
     * @ORM\Column(name="periodedebut", type="date", nullable=false)
     */
    private $periodedebut;

    /**
     * @var date $periodefin
     *
     * @ORM\Column(name="periodefin", type="date", nullable=false)
     */
    private $periodefin;

    /**
     * @var decimal $montant
     *
     * @ORM\Column(name="montant", type="decimal", scale="2", nullable=false)
     */
    private $montant;

    /**
     * @var decimal $penalite
     *
     * @ORM\Column(name="penalite", type="decimal", scale="2", nullable=false)
     */
    private $penalite;

    /**
     * @var date $datepaiement
     *
     * @ORM\Column(name="datePaiement", type="date", nullable=true)
     */
    private $datepaiement;

    /**
     * @var string $typepaiement
     *
     * @ORM\Column(name="typePaiement", type="string", nullable=true)
     */
    private $typepaiement;

    /**
     * @var string $numcheque
     *
     * @ORM\Column(name="numCheque", type="string", nullable=true)
     */
    private $numcheque;

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
     * @ORM\Column(name="path", type="string", length=125, nullable=false)
     */
    private $path;


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
     * Set ecoleId
     *
     * @param integer $ecoleId
     */
    public function setEcoleId($ecoleId)
    {
        $this->ecoleId = $ecoleId;
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
     * Get ecoleId
     *
     * @return integer 
     */
    public function getEcoleId()
    {
        return $this->ecoleId;
    }

    /**
     * Set service
     *
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set numfacture
     *
     * @param string $numfacture
     */
    public function setNumfacture($numfacture)
    {
        $this->numfacture = $numfacture;
    }

    /**
     * Get numfacture
     *
     * @return string 
     */
    public function getNumfacture()
    {
        return $this->numfacture;
    }

    /**
     * Set datefacture
     *
     * @param date $datefacture
     */
    public function setDatefacture($datefacture)
    {
        $this->datefacture = $datefacture;
    }

    /**
     * Get datefacture
     *
     * @return date 
     */
    public function getDatefacture()
    {
        return $this->datefacture;
    }

    /**
     * Set modefacturation
     *
     * @param string $modefacturation
     */
    public function setModefacturation($modefacturation)
    {
        $this->modefacturation = $modefacturation;
    }

    /**
     * Get modefacturation
     *
     * @return string 
     */
    public function getModefacturation()
    {
        return $this->modefacturation;
    }

    /**
     * Set periodedebut
     *
     * @param date $periodedebut
     */
    public function setPeriodedebut($periodedebut)
    {
        $this->periodedebut = $periodedebut;
    }

    /**
     * Get periodedebut
     *
     * @return date 
     */
    public function getPeriodedebut()
    {
        return $this->periodedebut;
    }

    /**
     * Set periodefin
     *
     * @param date $periodefin
     */
    public function setPeriodefin($periodefin)
    {
        $this->periodefin = $periodefin;
    }

    /**
     * Get periodefin
     *
     * @return date 
     */
    public function getPeriodefin()
    {
        return $this->periodefin;
    }

    /**
     * Set montant
     *
     * @param decimal $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return decimal 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set penalite
     *
     * @param decimal $penalite
     */
    public function setPenalite($penalite)
    {
        $this->penalite = $penalite;
    }

    /**
     * Get penalite
     *
     * @return decimal 
     */
    public function getPenalite()
    {
        return $this->penalite;
    }

    /**
     * Get total
     *
     * @return decimal 
     */
    public function getTotal()
    {
        return $this->getMontant() + $this->getPenalite();
    }

    /**
     * Set datepaiement
     *
     * @param date $datepaiement
     */
    public function setDatepaiement($datepaiement)
    {
        $this->datepaiement = $datepaiement;
    }

    /**
     * Get datepaiement
     *
     * @return date 
     */
    public function getDatepaiement()
    {
        return $this->datepaiement;
    }

    /**
     * Set typepaiement
     *
     * @param string $typepaiement
     */
    public function setTypepaiement($typepaiement)
    {
        $this->typepaiement = $typepaiement;
    }

    /**
     * Get typepaiement
     *
     * @return string 
     */
    public function getTypepaiement()
    {
        return $this->typepaiement;
    }

    /**
     * Set numcheque
     *
     * @param string $numcheque
     */
    public function setNumcheque($numcheque)
    {
        $this->numcheque = $numcheque;
    }

    /**
     * Get numcheque
     *
     * @return string 
     */
    public function getNumcheque()
    {
        return $this->numcheque;
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
	   * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="factures_eaux_electricite")
	   * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
	   */
	  protected $ecole;
	
		/**
     * @ORM\ManyToOne(targetEntity="Budget")
     * @ORM\JoinColumn(name="budget_id", referencedColumnName="id")
     */
    protected $budget;
	
	  /**
     * @ORM\ManyToOne(targetEntity="SituationCaisse")
     * @ORM\JoinColumn(name="situation_caisse_id", referencedColumnName="id")
     */
    protected $situationCaisse;
	
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

		public function checkDate(ExecutionContext $context)

		{
    if ( !empty($this->periodedebut) && !empty($this->periodefin)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->periodedebut->format($format));
			$dateComparator->setOperator("<=");
			if($dateComparator->test($this->periodefin->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.periodefin';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('Début de période doit être inférieur à la fin de période', array(), null);
			}
    }
		
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
        return 'uploads/eau_electricite';
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
		
}