<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\FactureRepository")
 * @UniqueEntity("numero")
 * @ORM\HasLifecycleCallbacks
 */
class Facture
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
     * @var string $numero
     * @Assert\NotBlank
     * @ORM\Column(name="numero", type="string", length=45, nullable=true)
     */
    private $numero;

    /**
     * @var date $dateCreation
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @var string $montant
     *
     * @ORM\Column(name="montant", type="decimal", nullable=false)
     */
    private $montant;

    /**
     * @var string $etat
     *
     * @ORM\Column(name="etat", type="string", length=45, nullable=true)
     */
    private $etat;

    /**
     * @var date $datePaiement
     *
     * @ORM\Column(name="date_paiement", type="date", nullable=true)
     */
    private $datePaiement;

    /**
     * @var date $datePrevisionPaiement
     *
     * @ORM\Column(name="date_prevision_paiement", type="date", nullable=true)
     */
    private $datePrevisionPaiement;

    /**
     * @var string $typePaiement
     *
     * @ORM\Column(name="type_paiement", type="string", length=45, nullable=true)
     */
    private $typePaiement;

    /**
     * @var integer $bonCommandeId
     *
     * @ORM\Column(name="bon_commande_id", type="integer", nullable=true)
     */
    private $bonCommandeId;
    
    /**
     * @var string $fichier
     * @ORM\Column(name="fichier", type="string", length=125, nullable=true)
     */
    private $fichier;
    
     /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", nullable=true)
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
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set dateCreation
     *
     * @param date $dateCreation
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Get dateCreation
     *
     * @return date 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
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
     * Set etat
     *
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set datePaiement
     *
     * @param date $datePaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;
    }

    /**
     * Get datePaiement
     *
     * @return date 
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set datePrevisionPaiement
     *
     * @param date $datePrevisionPaiement
     */
    public function setDatePrevisionPaiement($datePrevisionPaiement)
    {
        $this->datePrevisionPaiement = $datePrevisionPaiement;
    }

    /**
     * Get datePrevisionPaiement
     *
     * @return date 
     */
    public function getDatePrevisionPaiement()
    {
        return $this->datePrevisionPaiement;
    }

    /**
     * Set typePaiement
     *
     * @param string $typePaiement
     */
    public function setTypePaiement($typePaiement)
    {
        $this->typePaiement = $typePaiement;
    }

    /**
     * Get typePaiement
     *
     * @return string 
     */
    public function getTypePaiement()
    {
        return $this->typePaiement;
    }

    /**
     * Set bonCommandeId
     *
     * @param integer $bonCommandeId
     */
    public function setBonCommandeId($bonCommandeId)
    {
        $this->bonCommandeId = $bonCommandeId;
    }

    /**
     * Get bonCommandeId
     *
     * @return integer 
     */
    public function getBonCommandeId()
    {
        return $this->bonCommandeId;
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
     * @ORM\ManyToOne(targetEntity="BonCommande")
     * @ORM\JoinColumn(name="bon_commande_id", referencedColumnName="id")
     */
    protected $bonCommande;

    /**
     * Set bonCommande
     *
     * @param Acme\FmpsBundle\Entity\BonCommande $bonCommande
     */
    public function setBonCommande(\Acme\FmpsBundle\Entity\BonCommande $bonCommande)
    {
        $this->bonCommande = $bonCommande;
    }

    /**
     * Get bonCommande
     *
     * @return Acme\FmpsBundle\Entity\BonCommande 
     */
    public function getBonCommande()
    {
        return $this->bonCommande;
    }
    
    public static function getDefaultPaymentTypes()
	  {
		    return array(
           'chèque' => 'Chèque',
           'virement' => 'Virement',
           'espèce' => 'Espèce');
	  }
    
    public static function getDefaultStatus()
	  {
		    return array(
           'non reçu' => 'Non reçu',
           'reçu' => 'Reçu',
           'payée' => 'Payée');
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
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        if ($this->getBonCommande()){
            return 'uploads/'.$this->getBonCommande()->getFolderName();
        }
        else {
            return 'uploads/factures';
        }
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
