<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Fournisseur
 *
 * @ORM\Table(name="employe")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EmployeRepository")
 * @UniqueEntity("matricule")
 * @UniqueEntity("cin")
 * @ORM\HasLifecycleCallbacks
 */
class Employe
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
     * @var string $matricule
     * @Assert\NotBlank
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false, unique=true)
     */
    private $matricule;
    
    /**
     * @var string $nom
     * @Assert\NotBlank
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string $prenom
     * @Assert\NotBlank
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string $tel
     *
     * @ORM\Column(name="tel", type="string", length=125, nullable=true)
     */
    private $tel;

    /**
     * @var string $flote
     *
     * @ORM\Column(name="flote", type="string", length=125, nullable=true)
     */
    private $flote;
    
      /**
     * @var string $cin
     * @Assert\NotBlank
     * @ORM\Column(name="cin", type="string", length=125, nullable=false, unique=true)
     */
    private $cin;

		/**
     * @var string $cnss
     *
     * @ORM\Column(name="cnss", type="string", length=255, nullable=true)
     */
    private $cnss;

		/**
     * @var string $rib
     *
     * @ORM\Column(name="rib", type="string", length=255, nullable=true)
     */
    private $rib;

		/**
     * @var string $adresse
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

		/**
     * @var date $dateNaissance
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;
    
    /**
     * @var integer $superieurId
     *
     * @ORM\Column(name="superieur_id", type="integer", nullable=true)
     */
    private $superieurId;

    /**
     * @var integer $fonctionId
     *
     * @ORM\Column(name="fonction_id", type="integer", nullable=true)
     */
    private $fonctionId;

		/**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=true)
     */
    private $ecoleId;

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
     * Set matricule
     *
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * Get matricule
     *
     * @return string 
     */
    public function getMatricule()
    {
        return $this->matricule;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
	      //TODO uppercase
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
     * Set prenom
     *
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     */
    public function setTel($tel)
    {
        $this->tel = $tel;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set flote
     *
     * @param string $flote
     */
    public function setFlote($flote)
    {
        $this->flote = $flote;
    }

    /**
     * Get flote
     *
     * @return string 
     */
    public function getFlote()
    {
        return $this->flote;
    }

    /**
     * Get cin
     *
     * @return string 
     */
    public function getCin()
    {
        return $this->cin;
    }
    
    /**
     * Set cin
     *
     * @param string $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }

		 /**
	     * Get cnss
	     *
	     * @return string 
	     */
	    public function getCnss()
	    {
	        return $this->cnss;
	    }

	    /**
	     * Set cnss
	     *
	     * @param string $cnss
	     */
	    public function setCnss($cnss)
	    {
	        $this->cnss = $cnss;
	    }
	
		  /**
	     * Set rib
	     *
	     * @param string $rib
	     */
	    public function setRib($rib)
	    {
	        $this->rib = $rib;
	    }

	    /**
	     * Get rib
	     *
	     * @return string 
	     */
	    public function getRib()
	    {
	        return $this->rib;
	    }
	
	    /**
	     * Set adresse
	     *
	     * @param string $adresse
	     */
	    public function setAdresse($adresse)
	    {
	        $this->adresse = $adresse;
	    }

	    /**
	     * Get adresse
	     *
	     * @return string 
	     */
	    public function getAdresse()
	    {
	        return $this->adresse;
	    }
	
	    /**
	     * Set dateNaissance
	     *
	     * @param date $dateNaissance
	     */
	    public function setDateNaissance($dateNaissance)
	    {
	        $this->dateNaissance = $dateNaissance;
	    }

	    /**
	     * Get dateNaissance
	     *
	     * @return date 
	     */
	    public function getDateNaissance()
	    {
	        return $this->dateNaissance;
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
     * Set superieurId
     *
     * @param integer $superieurId
     */
    public function setSuperieurId($superieurId)
    {
        $this->superieurId = $superieurId;
    }

    /**
     * Get superieurId
     *
     * @return integer 
     */
    public function getSuperieurId()
    {
        return $this->superieurId;
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
      $this->setNom(strtoupper($this->getNom()));
			$this->setPrenom(ucfirst(strtolower($this->getPrenom())));
			$this->setCin(strtoupper(str_replace(' ', '', $this->getCin())));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
			$this->setNom(strtoupper($this->getNom()));
			$this->setPrenom(ucfirst(strtolower($this->getPrenom())));
			$this->setCin(strtoupper(str_replace(' ', '', $this->getCin())));
    }
    
    public function getUsername(){
	     $nom = str_replace(" ", "", $this->getNom());
	     $prenom = str_replace(" ", "", $this->getPrenom());
	     if ( $this->getEcoleId() > 0 && $this->getEcole()->getNom() == 'Siège' ){
		     return strtolower(substr($prenom, 0, 1) . '' . $nom);
	     }
	     else{
		     return strtolower($prenom . '.' . $nom);
	     }
    }

    public function getEmail(){
        return $this->getUsername() .'@fmps.ma';
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
        return 'uploads/employes';
    }

    public function hasPicture()
		{
			return file_exists($this->getUploadDir().'/'.$this->matricule . '.jpg');
		}
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'employe_'.uniqid().'.'.$this->fichier->guessExtension();
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
     * @ORM\OneToMany(targetEntity="Affectation", mappedBy="employe", cascade={"persist", "remove"})
     */
    private $affectations;

    /**
     * @ORM\OneToMany(targetEntity="EmployeFonction", mappedBy="employe", cascade={"persist", "remove"})
     */
    private $fonctions;
    
    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="superieur")
     */
    private $equipe;
    
    /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="equipe")
     * @ORM\JoinColumn(name="superieur_id", referencedColumnName="id")
     */
    protected $superieur;
    
    /**
     * @ORM\ManyToOne(targetEntity="Fonction", inversedBy="employes")
     * @ORM\JoinColumn(name="fonction_id", referencedColumnName="id")
     */
    protected $fonction;

		/**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="employes")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

		/**
     * @ORM\OneToMany(targetEntity="EmployeDocument", mappedBy="employe")
     */
    protected $documents;

	 /**
	   * @ORM\OneToMany(targetEntity="EmployeAbsence", mappedBy="employe", cascade={"persist"})
	   */
	  protected $absences;

		/**
     * @ORM\OneToMany(targetEntity="EmployeClasse", mappedBy="employe", cascade={"persist"})
     */
    protected $employeClasses;
    
    public function __construct()
    {
        $this->affectations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fonctions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipe = new \Doctrine\Common\Collections\ArrayCollection();
				$this->documents = new \Doctrine\Common\Collections\ArrayCollection();
				$this->absences = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add affectation
     *
     * @param \Acme\FmpsBundle\Entity\Affectation $affectation
     */
    public function addAffectation(\Acme\FmpsBundle\Entity\Affectation $affectation)
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
     * Get recent affectation
     *
     */
		public function getRecentAffectation()
    {
        $affectations = $this->getAffectations();
        $recent = null;
				$date = null;
				foreach ($affectations as $affectation)
				{
					if ($date == null or $date < $affectation->getDateDebutAffectation())
					{
						$recent = $affectation;
						$date = $affectation->getDateDebutAffectation();
					} 
				}
				
				return $recent;
    }

    /**
     * Get recent fonction
     *
     */
		public function getRecentFonction()
    {
        $fonctions = $this->getFonctions();
        $recent = null;
				$date = null;
				foreach ($fonctions as $fonction)
				{
					if ($date == null or $date < $fonction->getDateDebutFonction())
					{
						$recent = $fonction;
						$date = $fonction->getDateDebutFonction();
					}
				}
				
				return $recent;
    }


		/**
     * Add fonction
     *
     * @param \Acme\FmpsBundle\Entity\Fonction $fonction
     */
    public function addFonction(\Acme\FmpsBundle\Entity\Fonction $fonction)
    {
        $this->fonctions[] = $fonction;
    }

    /**
     * Get fonctions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFonctions()
    {
        return $this->fonctions;
    }

    /**
     * Add equipe
     *
     * @param Acme\FmpsBundle\Entity\User $equipe
     */
    public function addUser(\Acme\FmpsBundle\Entity\User $equipe)
    {
        $this->equipe[] = $equipe;
    }

    /**
     * Get equipe
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEquipe()
    {
        return $this->equipe;
    }

    /**
     * Set superieur
     *
     * @param Acme\FmpsBundle\Entity\Employe $superieur
     */
    public function setSuperieur(\Acme\FmpsBundle\Entity\Employe $superieur = null)
    {
        $this->superieur = $superieur;
    }

    /**
     * Get superieur
     *
     * @return Acme\FmpsBundle\Entity\Employe
     */
    public function getSuperieur()
    {
        return $this->superieur;
    }

		/**
     * Set fonction
     *
     * @param Acme\FmpsBundle\Entity\Fonction $fonction
     */
    public function setFonction(\Acme\FmpsBundle\Entity\Fonction $fonction = null)
    {
       if ( $fonction != null ) $this->fonction = $fonction;
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

		/**
     * Set ecole
     *
     * @param Acme\FmpsBundle\Entity\Ecole $ecole
     */
    public function setEcole(\Acme\FmpsBundle\Entity\Ecole $ecole = null)
    {
       if ( $ecole != null ) $this->ecole = $ecole;
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
     * Add documents
     *
     * @param Acme\FmpsBundle\Entity\Document $documents
     */
    public function addDocument(\Acme\FmpsBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
    }

    /**
     * Get documents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }

		/**
     * Add absence
     *
     * @param \Acme\FmpsBundle\Entity\EmployeAbsence $absence
     */
    public function addAbsence(\Acme\FmpsBundle\Entity\EmployeAbsence $absence)
    {
        $this->absence[] = $absence;
    }

    /**
     * Get absences
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAbsences()
    {
        return $this->absences;
    }


		/**
     * Get full_name
     *
     * @return string 
     */
    public function getFullName()
    {
       return $this->prenom . ' ' . $this->nom;
    }
    
    public function __toString()
    {
       return $this->getFullName();
    }

}