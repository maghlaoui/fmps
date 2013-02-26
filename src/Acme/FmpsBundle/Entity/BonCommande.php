<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;

/**
 * Acme\FmpsBundle\Entity\BonCommande
 *
 * @ORM\Table(name="bon_commande")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\BonCommandeRepository")
 * @UniqueEntity("numero")
 * @ORM\HasLifecycleCallbacks
 */
class BonCommande
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
     * @ORM\Column(name="numero", type="string", length=125, nullable=true)
     */
    private $numero;
    
    /**
     * @var string $objet
     * @Assert\NotBlank
     * @ORM\Column(name="objet", type="string", length=255, nullable=true)
     */
    private $objet;

    /**
     * @var integer $rubriqueId
     *
     * @ORM\Column(name="rubrique_id", type="integer", nullable=false)
     */
    private $rubriqueId;

    /**
     * @var integer $fournisseurId
     *
     * @ORM\Column(name="fournisseur_id", type="integer", nullable=false)
     */
    private $fournisseurId;
    
    /**
     * @var float $montant
     *
     * @ORM\Column(name="montant", type="float", nullable=false)
     */
    private $montant;
    
    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;
    
    /**
     * @var date $dateBc
     * @ORM\Column(name="date_bc", type="date")
     */
    private $dateBc;
    
    /**
     * @var string $anneeBc
     * @ORM\Column(name="annee_bc", type="string", nullable=true)
     */
    private $anneeBc;
    
    /**
     * @var string $fichierDa
     * @ORM\Column(name="fichier_da", type="string", nullable=true)
     */
    private $fichierDa;
    
    /**
     * @var string $fichierBc
     * @ORM\Column(name="fichier_bc", type="string", nullable=true)
     */
    private $fichierBc;
    
    /**
     * @var string $pathDa
     *
     * @ORM\Column(name="path_da", type="string", nullable=true)
     */
    private $pathDa;
    
    /**
     * @var string $pathBc
     *
     * @ORM\Column(name="path_bc", type="string", nullable=true)
     */
    private $pathBc;

    /**
     * @var boolean $ttc
     *
     * @ORM\Column(name="ttc", type="boolean", nullable=true)
     */
    private $ttc;

	  /**
     * @var boolean $affectation
     *
     * @ORM\Column(name="affectation", type="string", nullable=true)
     */
    private $affectation;

    /**
     * @var boolean $remise
     *
     * @ORM\Column(name="remise", type="integer", nullable=true)
     */
    private $remise;

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
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
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
     * Set rubriqueId
     *
     * @param integer $rubriqueId
     */
    public function setRubriqueId($rubriqueId)
    {
        $this->rubriqueId = $rubriqueId;
    }

    /**
     * Get rubriqueId
     *
     * @return integer 
     */
    public function getRubriqueId()
    {
        return $this->rubriqueId;
    }

    /**
     * Set fournisseurId
     *
     * @param integer $fournisseurId
     */
    public function setFournisseurId($fournisseurId)
    {
        $this->fournisseurId = $fournisseurId;
    }

    /**
     * Get fournisseurId
     *
     * @return integer 
     */
    public function getFournisseurId()
    {
        return $this->fournisseurId;
    }
    
    /**
     * Set montant
     *
     * @param float $montant
     */
    public function setMontant($montant = 0)
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
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set dateBc
     *
     * @param datetime $dateBc
     */
    public function setDateBc($dateBc)
    {
        $this->dateBc = $dateBc;
    }
    
    /**
     * Get dateBc
     *
     * @return date
     */
    public function getDateBc()
    {
        return $this->dateBc;
    }
    
      
    /**
     * Set anneeBc
     *
     * @param string $anneeBc
     */
    public function setAnneeBc($anneeBc)
    {
        $this->anneeBc = $anneeBc;
    }
    
    /**
     * Get anneeBc
     *
     * @return string
     */
    public function getAnneeBc()
    {
        return $this->anneeBc;
    }
    
    /**
     * Set fichierBc
     *
     * @param string $fichierBc
     */
    public function setFichierBc($fichierBc)
    {
        $this->fichierBc = $fichierBc;
    }
    
    /**
     * Get fichierBc
     *
     * @return string
     */
    public function getFichierBc()
    {
        return $this->fichierBc;
    }
    
    /**
     * Set fichierDa
     *
     * @param string $fichierDa
     */
    public function setFichierDa($fichierDa)
    {
        $this->fichierDa = $fichierDa;
    }
    
    /**
     * Get fichierDa
     *
     * @return string
     */
    public function getFichierDa()
    {
        return $this->fichierDa;
    }
    
    /**
     * Set pathDa
     *
     * @param string $pathDa
     */
    public function setPath($pathDa)
    {
        $this->pathDa = $pathDa;
    }

    /**
     * Get pathDa
     *
     * @return string 
     */
    public function getPathDa()
    {
        return $this->pathDa;
    }
    
    /**
     * Set pathBc
     *
     * @param string $pathBc
     */
    public function setPathBc($pathBc)
    {
        $this->pathBc = $pathBc;
    }

    /**
     * Get pathBc
     *
     * @return string 
     */
    public function getPathBc()
    {
        return $this->pathBc;
    }

    /**
     * Set ttc
     *
     * @param boolean $ttc
     */
    public function setTtc($ttc)
    {
        $this->ttc = $ttc;
    }

    /**
     * Get ttc
     *
     * @return boolean 
     */
    public function getTtc()
    {
        return $this->ttc;
    }

	 /**
     * Set affectation
     *
     * @param string $affectation
     */
    public function setAffectation($affectation)
    {
        $this->affectation = $affectation;
    }

    /**
     * Get affectation
     *
     * @return string 
     */
    public function getAffectation()
    {
        return $this->affectation;
    }

		/**
	    * Set remise
	    *
	    * @param integer $remise
	    */
	  public function setRemise($remise)
	  {
	     $this->remise = $remise;
	  }

	  /**
	   * Get remise
	   *
	   * @return integer 
	   */
	  public function getRemise()
	  {
	     return $this->remise;
	  }
	 /**
		 * Get remiseFor
		 *
		 * @return integer 
		 */
	 public function getRemiseFor()
	 {
		   if ( $this->remise == 0 ){
			   return 1;
		   }
		   else{
			   return (100-$this->remise)/100;
		   }
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
     * Get yearsAgo
     *
     * @return integer
     */
    public function getYearsAgo()
    {
        return date('Y') - (int)$this->anneeBc;
    }
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Rubrique", inversedBy="bonCommande")
     * @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     */
    protected $rubrique;
    //@OrderBy({"nom" = "ASC"})
    /**
     * @ORM\ManyToOne(targetEntity="Fournisseur", inversedBy="bonCommande")
     * @ORM\JoinColumn(name="fournisseur_id", referencedColumnName="id")
     */

    protected $fournisseur;
    
    /**
     * @ORM\OneToMany(targetEntity="ArticleBonCommande", mappedBy="bonCommande", cascade={"persist", "remove"})
     */
    protected $articles_bons_commande;
    
    /**
     * @ORM\OneToMany(targetEntity="BonLivraison", mappedBy="bonCommande", cascade={"persist", "remove"})
     */
    protected $bons_livraison;
    
    /**
     * @ORM\OneToMany(targetEntity="Devis", mappedBy="bonCommande", cascade={"persist", "remove"})
     */
    protected $devis;
    
    public function __construct()
    {
        $this->devis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->articles_bons_commande = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bons_livraison = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = 'engagé';
        $this->montant = 0;
        $this->anneeBc = date('Y');
    }
    
    /**
     * Add bons_livraison
     *
     * @param Acme\FmpsBundle\Entity\BonLivraison $bons_livraison
     */
    public function addBonsLivraison(\Acme\FmpsBundle\Entity\BonLivraison $bons_livraison)
    {
        $this->bons_livraison[] = $bons_livraison;
    }

    /**
     * Get bons_livraison
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getBonsLivraison()
    {
        return $this->bons_livraison;
    }
    
    /**
     * Add devis
     *
     * @param Acme\FmpsBundle\Entity\Devis $devis
     */
    public function addDevis(\Acme\FmpsBundle\Entity\Devis $devis)
    {
        $this->devis[] = $devis;
    }

    /**
     * Get devis
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDevis()
    {
        return $this->devis;
    }

   /**
     * Set rubrique
     *
     * @param Acme\FmpsBundle\Entity\Rubrique $rubrique
     */
    public function setRubrique(\Acme\FmpsBundle\Entity\Rubrique $rubrique)
    {
        $this->rubrique = $rubrique;
    }

    /**
     * Get rubrique
     *
     * @return Acme\FmpsBundle\Entity\Rubrique 
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }
    
    /**
     * Set fournisseur
     *
     * @param Acme\FmpsBundle\Entity\Fournisseur $fournisseur
     */
    public function setFournisseur(\Acme\FmpsBundle\Entity\Fournisseur $fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * Get fournisseur
     *
     * @return Acme\FmpsBundle\Entity\Fournisseur 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
    
    /**
     * Add 
     *
     * @param Acme\FmpsBundle\Entity\ArticleBonCommande $articles_bons_commande
     */
    public function addArticlesBonsCommande(\Acme\FmpsBundle\Entity\ArticleBonCommande $articles_bons_commande)
    {
        $this->articles_bons_commande[] = $articles_bons_commande;
    }

    /**
     * Get articles_bons_commande
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getArticlesBonsCommande()
    {
        return $this->articles_bons_commande;
    }
    
    public function __toString()
    {
        return $this->numero . '::' . $this->objet;
    }
    
    public static function getDefaultStatus()
	  {
		    return array(
           'engagé' => 'Engagé',
           'estimé' => 'Estimé',
           'annulé' => 'Annulé',
           'payé'   => 'Payé');
	  }
    
    public function getAbsolutePath($file = 'da')
    {
        if ($file == 'da'){
           return null === $this->pathDa ? null : $this->getUploadRootDir().'/'.$this->pathDa;
        }
        else{
           return null === $this->pathBc ? null : $this->getUploadRootDir().'/'.$this->pathBc;
        }
    }

    public function getWebPath($file = 'da')
    {
        if ($file == 'da'){
           return null === $this->pathDa ? null : $this->getUploadDir().'/'.$this->pathDa;
        }
        else{
           return null === $this->pathBc ? null : $this->getUploadDir().'/'.$this->pathBc; 
        }
    }

    protected function getUploadRootDir()
    {
       return  __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
       return 'uploads/'.$this->getFolderName();
    }
    
    public function getFolderName(){
        $folder_name = str_replace('/', '_', $this->getNumero());
        $root_dir =  __DIR__.'/../../../../web/uploads/'.$folder_name;
        if (!is_dir($root_dir)) mkdir($root_dir);
        return $folder_name;
    }

    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        try{
           if (null !== $this->fichierDa) $this->pathDa = 'demande_achat.'.$this->fichierDa->guessExtension();
           if (null !== $this->fichierBc) $this->pathBc = 'bon_commande.'.$this->fichierBc->guessExtension();
        }
        catch (Exception $e) {
            echo $e->getMessage(); exit;
        }
        
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null !== $this->fichierDa) {
            $this->fichierDa->move($this->getUploadRootDir(), $this->pathDa);
            unset($this->fichierDa);
        }
        
        if (null !== $this->fichierBc) {
            $this->fichierBc->move($this->getUploadRootDir(), $this->pathBc);
            unset($this->fichierBc);
        }
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fichier = $this->getAbsolutePath('da');
        if ( file_exists($fichier)) unlink($fichier);
        
        $fichier = $this->getAbsolutePath('bc');
        if ( file_exists($fichier)) unlink($fichier);
    }
    
}