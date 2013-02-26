<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Titeur
 *
 * @ORM\Table(name="titeur")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\TiteurRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Titeur
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
     * @var boolean $adherent
     *
     * @ORM\Column(name="adherent", type="boolean", nullable=true)
     */
    private $adherent;

    /**
     * @var string $nom
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string $prenom
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     */
    private $prenom;

    /**
     * @var string $cin
     *
     * @ORM\Column(name="cin", type="string", length=255, nullable=false, unique=true)
     */
    private $cin;

    /**
     * @var string $nationalite
     *
     * @ORM\Column(name="nationalite", type="string", length=255, nullable=true)
     */
    private $nationalite;

    /**
     * @var string $profession
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    private $profession;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string $telephone
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string $telephoneBureau
     *
     * @ORM\Column(name="telephone_bureau", type="string", length=255, nullable=true)
     */
    private $telephoneBureau;

    /**
     * @var string $fix
     *
     * @ORM\Column(name="fix", type="string", length=255, nullable=true)
     */
    private $fix;

    /**
     * @var string $adresse
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var integer $villeId
     *
     * @ORM\Column(name="ville_id", type="integer", nullable=false)
     */
    private $villeId;

    /**
     * @var boolean $typeParente
     *
     * @ORM\Column(name="type_parente", type="boolean", nullable=false)
     */
    private $typeParente;

    /**
     * @var string $numPpr
     *
     * @ORM\Column(name="num_ppr", type="string", length=255, nullable=true)
     */
    private $numPpr;

    /**
     * @var string $numAdh
     *
     * @ORM\Column(name="num_adh", type="string", length=255, nullable=true)
     */
    private $numAdh;

    /**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=true)
     */
    private $ecoleId;

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
     * @ORM\ManyToOne(targetEntity="Ville")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    protected $ville;

    /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="enfants")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

	/**
     * @ORM\OneToMany(targetEntity="EnfantTiteur", mappedBy="titeurs")
     */
    protected $enfants_titeurs;

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
     * Set adherent
     *
     * @param boolean $adherent
     */
    public function setAdherent($adherent)
    {
        $this->adherent = $adherent;
    }

    /**
     * Get adherent
     *
     * @return boolean 
     */
    public function getAdherent()
    {
        return $this->adherent;
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
     * Get full_name
     *
     * @return string 
     */
    public function getFullTiteurName()
    {
        return $this->prenom . ' ' . $this->nom;
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
     * Get cin
     *
     * @return string 
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set profession
     *
     * @param string $profession
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    }

    /**
     * Get profession
     *
     * @return string 
     */
    public function getProfession()
    {
        return $this->profession;
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
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephoneBureau
     *
     * @param string $telephoneBureau
     */
    public function setTelephoneBureau($telephoneBureau)
    {
        $this->telephoneBureau = $telephoneBureau;
    }

    /**
     * Get telephoneBureau
     *
     * @return string 
     */
    public function getTelephoneBureau()
    {
        return $this->telephoneBureau;
    }

    /**
     * Set fix
     *
     * @param string $fix
     */
    public function setFix($fix)
    {
        $this->fix = $fix;
    }

    /**
     * Get fix
     *
     * @return string 
     */
    public function getFix()
    {
        return $this->fix;
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
     * Set typeParente
     *
     * @param boolean $typeParente
     */
    public function setTypeParente($typeParente)
    {
        $this->typeParente = $typeParente;
    }

    /**
     * Get typeParente
     *
     * @return boolean 
     */
    public function getTypeParente()
    {
        return $this->typeParente;
    }

	/**
     * Get typeParenteStr
     *
     * @return string 
     */
    public function getTypeParenteStr()
    {
      if ($this->typeParente == 1){
			  return 'Père';
		  }
		  else if ($this->typeParente == 2){
			  return 'Mère';
		  }
		  else {
			  return 'Titeur';
		  }
    }

    /**
     * Set numPpr
     *
     * @param string $numPpr
     */
    public function setNumPpr($numPpr)
    {
        $this->numPpr = $numPpr;
    }

    /**
     * Get numPpr
     *
     * @return string 
     */
    public function getNumPpr()
    {
        return $this->numPpr;
    }

    /**
     * Set numAdh
     *
     * @param string $numAdh
     */
    public function setNumAdh($numAdh)
    {
        $this->numAdh = $numAdh;
    }

    /**
     * Get numAdh
     *
     * @return string 
     */
    public function getNumAdh()
    {
        return $this->numAdh;
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
	     * Set ecole
	     *
	     * @param Acme\FmpsBundle\Entity\Ecole $ecole
	     */
	    public function setEcole(\Acme\FmpsBundle\Entity\Ecole $ecole = null)
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


	  public function __toString()
    {
        return $this->getFullTiteurName();
    }

    public function __construct()
    {
	     $this->adherent = 0;
    }
}