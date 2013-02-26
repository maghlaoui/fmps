<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Ecole
 *
 * @ORM\Table(name="ecole")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EcoleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Ecole
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
     * @var string $nom
     * @Assert\NotBlank
     * @ORM\Column(name="nom", type="string", length=145, nullable=true)
     */
    private $nom;

    /**
     * @var text $adresse
     *
     * @ORM\Column(name="adresse", type="text", nullable=true)
     */
    private $adresse;

    /**
     * @var integer $villeId
     *
     * @ORM\Column(name="ville_id", type="integer", nullable=false)
     */
    private $villeId;

    /**
     * @var integer $reseauPrescolaireId
     *
     * @ORM\Column(name="reseau_prescolaire_id", type="integer", nullable=false)
     */
    private $reseauPrescolaireId;

    /**
     * @var string $tel1
     *
     * @ORM\Column(name="tel1", type="string", length=45, nullable=true)
     */
    private $tel1;

    /**
     * @var string $tel2
     *
     * @ORM\Column(name="tel2", type="string", length=45, nullable=true)
     */
    private $tel2;

    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax", type="string", length=45, nullable=true)
     */
    private $fax;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=125, nullable=true)
     */
    private $email;

    /**
     * @var string $lattitude
     *
     * @ORM\Column(name="lattitude", type="string", length=45, nullable=true)
     */
    private $lattitude;

    /**
     * @var string $longitude
     *
     * @ORM\Column(name="longitude", type="string", length=45, nullable=true)
     */
    private $longitude;

    /**
     * @var string $superficie
     *
     * @ORM\Column(name="superficie", type="string", length=45, nullable=true)
     */
    private $superficie;

    /**
     * @var string $nomCompteBancaire
     *
     * @ORM\Column(name="nom_compte_bancaire", type="string", length=245, nullable=true)
     */
    private $nomCompteBancaire;

    /**
     * @var string $numeroCompte
     *
     * @ORM\Column(name="numero_compte", type="string", length=245, nullable=true)
     */
    private $numeroCompte;

    /**
     * @var string $numeroRib
     *
     * @ORM\Column(name="numero_rib", type="string", length=245, nullable=true)
     */
    private $numeroRib;

    /**
     * @var date $dateOuverture
     *
     * @ORM\Column(name="date_ouverture", type="date", nullable=true)
     */
    private $dateOuverture;

    /**
     * @var string $fichier
     *
     * @ORM\Column(name="fichier", type="string", length=45, nullable=true)
     */
    private $fichier;
    
    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=45, nullable=true)
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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param text $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get adresse
     *
     * @return text 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set villeId
     *
     * @param integer $villeId
     */
    public function setVilleId($villeId)
    {
        $this->villeId = $villeId;
    }

    /**
     * Get villeId
     *
     * @return integer 
     */
    public function getVilleId()
    {
        return $this->villeId;
    }

    /**
     * Set reseauPrescolaireId
     *
     * @param integer $reseauPrescolaireId
     */
    public function setReseauPrescolaireId($reseauPrescolaireId)
    {
        $this->reseauPrescolaireId = $reseauPrescolaireId;
    }

    /**
     * Get reseauPrescolaireId
     *
     * @return integer 
     */
    public function getReseauPrescolaireId()
    {
        return $this->reseauPrescolaireId;
    }

    /**
     * Set tel1
     *
     * @param string $tel1
     */
    public function setTel1($tel1)
    {
        $this->tel1 = $tel1;
    }

    /**
     * Get tel1
     *
     * @return string 
     */
    public function getTel1()
    {
        return $this->tel1;
    }

    /**
     * Set tel2
     *
     * @param string $tel2
     */
    public function setTel2($tel2)
    {
        $this->tel2 = $tel2;
    }

    /**
     * Get tel2
     *
     * @return string 
     */
    public function getTel2()
    {
        return $this->tel2;
    }

    /**
     * Set fax
     *
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set lattitude
     *
     * @param string $lattitude
     */
    public function setLattitude($lattitude)
    {
        $this->lattitude = $lattitude;
    }

    /**
     * Get lattitude
     *
     * @return string 
     */
    public function getLattitude()
    {
        return $this->lattitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set superficie
     *
     * @param string $superficie
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;
    }

    /**
     * Get superficie
     *
     * @return string 
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set nomCompteBancaire
     *
     * @param string $nomCompteBancaire
     */
    public function setNomCompteBancaire($nomCompteBancaire)
    {
        $this->nomCompteBancaire = $nomCompteBancaire;
    }

    /**
     * Get nomCompteBancaire
     *
     * @return string 
     */
    public function getNomCompteBancaire()
    {
        return $this->nomCompteBancaire;
    }

    /**
     * Set numeroCompte
     *
     * @param string $numeroCompte
     */
    public function setNumeroCompte($numeroCompte)
    {
        $this->numeroCompte = $numeroCompte;
    }

    /**
     * Get numeroCompte
     *
     * @return string 
     */
    public function getNumeroCompte()
    {
        return $this->numeroCompte;
    }

    /**
     * Set numeroRib
     *
     * @param string $numeroRib
     */
    public function setNumeroRib($numeroRib)
    {
        $this->numeroRib = $numeroRib;
    }

    /**
     * Get numeroRib
     *
     * @return string 
     */
    public function getNumeroRib()
    {
        return $this->numeroRib;
    }

    /**
     * Set dateOuverture
     *
     * @param date $dateOuverture
     */
    public function setDateOuverture($dateOuverture)
    {
        $this->dateOuverture = $dateOuverture;
    }

    /**
     * Get dateOuverture
     *
     * @return date 
     */
    public function getDateOuverture()
    {
        return $this->dateOuverture;
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
     * @ORM\OneToMany(targetEntity="Classe", mappedBy="ecole")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity="OffreService", mappedBy="ecole")
     */
    private $offresServices;

    /**
     * @ORM\OneToMany(targetEntity="Affectation", mappedBy="ecole", cascade={"persist", "remove"})
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="Inscription", mappedBy="ecole", cascade={"persist", "remove"})
     */
    private $inscriptions;

    /**
     * @ORM\OneToMany(targetEntity="Preinscription", mappedBy="ecole", cascade={"persist", "remove"})
     */
    private $preinscriptions;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="ecoles")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    protected $ville;
    
     /**
     * @ORM\ManyToOne(targetEntity="ReseauPrescolaire", inversedBy="ecoles")
     * @ORM\JoinColumn(name="reseau_prescolaire_id", referencedColumnName="id")
     */
    protected $reseau_prescolaire;

		 /**
	     * @ORM\OneToMany(targetEntity="EcoleCaisse", mappedBy="ecole", cascade={"persist", "remove"})
	     */
	  private $caisses;
	
	  /**
     * @ORM\OneToMany(targetEntity="Alimentation", mappedBy="ecole", cascade={"persist", "remove"})
     */
    private $alimentations;

    /**
     * @ORM\OneToMany(targetEntity="Employe", mappedBy="ecole")
     */
    protected $employes;

    /**
     * @ORM\OneToMany(targetEntity="Bon", mappedBy="ecole")
     */
    protected $bons;

    /**
     * @ORM\OneToMany(targetEntity="EcoleAchat", mappedBy="ecole")
     */
    protected $factures;

    /**
     * @ORM\OneToMany(targetEntity="Decharge", mappedBy="ecole")
     */
    protected $decharges;

    /**
     * @ORM\OneToMany(targetEntity="Eauelectricite", mappedBy="ecole")
     */
    protected $factures_eaux_electricite;

    /**
	   * @ORM\OneToMany(targetEntity="Enfant", mappedBy="ville", cascade={"persist"})
	   */
	  protected $enfants;

   
    public function __construct()
    {
        $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offresServices = new \Doctrine\Common\Collections\ArrayCollection();
        $this->affectations = new \Doctrine\Common\Collections\ArrayCollection();
				$this->inscriptions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->caisses = new \Doctrine\Common\Collections\ArrayCollection();
				$this->alimentations = new \Doctrine\Common\Collections\ArrayCollection();
				$this->employes = new \Doctrine\Common\Collections\ArrayCollection();
				$this->preinscriptions = new \Doctrine\Common\Collections\ArrayCollection();
				$this->bons = new \Doctrine\Common\Collections\ArrayCollection();
				$this->factures = new \Doctrine\Common\Collections\ArrayCollection();
				$this->decharges = new \Doctrine\Common\Collections\ArrayCollection();
				$this->factures_eaux_electricite = new \Doctrine\Common\Collections\ArrayCollection();
				$this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add classes
     *
     * @param Acme\FmpsBundle\Entity\Classe $classes
     */
    public function addClasse(\Acme\FmpsBundle\Entity\Classe $classes)
    {
        $this->classes[] = $classes;
    }

    /**
     * Get classes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getClasses()
    {
        return $this->classes;
    }

    /**
     * Set ville
     *
     * @param Acme\FmpsBundle\Entity\Ville $ville
     */
    public function setVille(\Acme\FmpsBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;
    }

    /**
     * Get ville
     *
     * @return Acme\FmpsBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set reseau_prescolaire
     *
     * @param Acme\FmpsBundle\Entity\ReseauPrescolaire $reseauPrescolaire
     */
    public function setReseauPrescolaire(\Acme\FmpsBundle\Entity\ReseauPrescolaire $reseauPrescolaire)
    {
        $this->reseau_prescolaire = $reseauPrescolaire;
    }

    /**
     * Get reseau_prescolaire
     *
     * @return Acme\FmpsBundle\Entity\ReseauPrescolaire 
     */
    public function getReseauPrescolaire()
    {
        return $this->reseau_prescolaire;
    }

    /**
     * Add offresServices
     *
     * @param Acme\FmpsBundle\Entity\OffreService $offresServices
     */
    public function addOffreService(\Acme\FmpsBundle\Entity\OffreService $offresServices)
    {
        $this->offresServices[] = $offresServices;
    }

    /**
     * Get offresServices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOffresServices()
    {
        return $this->offresServices;
    }

    /**
     * Add Affectation
     *
     * @param Acme\FmpsBundle\Entity\Affectation $affectation
     */
    public function addAffectations(\Acme\FmpsBundle\Entity\Affectation $affectation)
    {
        $this->affectations[] = $affectation;
    }

    /**
     * Get affectations
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAffectations()
    {
        return $this->affectations;
    }

    /**
     * Add inscription
     *
     * @param Acme\FmpsBundle\Entity\Inscription $inscription
     */
    public function addInscriptions(\Acme\FmpsBundle\Entity\Inscription $inscription)
    {
        $this->inscriptions[] = $inscription;
    }

    /**
     * Get inscriptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getInscriptions()
    {
        return $this->inscriptions;
    }

    /**
     * Add employes
     *
     * @param Acme\FmpsBundle\Entity\Employe $employe
     */
    public function addEmploye(\Acme\FmpsBundle\Entity\Employe $employes)
    {
        $this->employes[] = $employes;
    }


    /**
     * Get employes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmployes()
    {
        return $this->employes;
    }

   /**
     * Add preinscription
     *
     * @param Acme\FmpsBundle\Entity\Preinscription $preinscription
     */
    public function addPreinscription(\Acme\FmpsBundle\Entity\Preinscription $preinscription)
    {
        $this->preinscriptions[] = $preinscription;
    }

    /**
     * Get preinscriptions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPreinscriptions()
    {
        return $this->preinscriptions;
    }

    /**
     * Add enfant
     *
     * @param Acme\FmpsBundle\Entity\Enfant $enfant
     */
    public function addEnfant(\Acme\FmpsBundle\Entity\Enfant $enfant)
    {
        $this->enfants[] = $enfant;
    }

    /**
     * Get enfants
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEnfants()
    {
        return $this->enfants;
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
        return 'uploads/ecoles';
    }

	 /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'ecole_'.uniqid().'.'.$this->fichier->guessExtension();
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
    
     public function __toString()
    {
        return $this->nom;
    }
}