<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;


/**
 * Acme\FmpsBundle\Entity\Enfant
 *
 * @ORM\Table(name="enfant")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EnfantRepository")
 * @Assert\Callback(methods={"validateDateNaissance"})
 * @ORM\HasLifecycleCallbacks
 */
class Enfant
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
     * @var string $sexe
     *
     * @ORM\Column(name="sexe", type="string", nullable=false)
     */
    private $sexe;

    /**
     * @var date $dateNaissance
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @var string $lieuNaissance
     *
     * @ORM\Column(name="lieu_naissance", type="string", length=125, nullable=false)
     */
    private $lieuNaissance;

    /**
     * @var string $nationalite
     *
     * @ORM\Column(name="nationalite", type="string", length=125, nullable=false)
     */
    private $nationalite;

    /**
     * @var string $ecoleFreq
     *
     * @ORM\Column(name="ecole_freq", type="string", length=125, nullable=true)
     */
    private $ecoleFreq;

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
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="enfants")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

		/** 
		 * @ORM\OneToMany(targetEntity="Inscription", mappedBy="enfant", cascade={"all"}) 
		 */ 
	  protected $inscriptions;

	 /**
     * @ORM\OneToMany(targetEntity="EnfantTiteur", mappedBy="enfants")
     */
    protected $enfants_titeurs;

    /**
     * Add inscription
     *
     * @param Acme\FmpsBundle\Entity\Inscription $inscription
     */
    public function addInscription(\Acme\FmpsBundle\Entity\Inscription $inscription)
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
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
    public function getFullName()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
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
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;
    }

    /**
     * Get lieuNaissance
     *
     * @return string 
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
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
     * Set ecoleFreq
     *
     * @param string $ecoleFreq
     */
    public function setEcoleFreq($ecoleFreq)
    {
        $this->ecoleFreq = $ecoleFreq;
    }

    /**
     * Get ecoleFreq
     *
     * @return string 
     */
    public function getEcoleFreq()
    {
        return $this->ecoleFreq;
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
			$this->setNom(strtoupper($this->getNom()));
			$this->setPrenom(ucfirst(strtolower($this->getPrenom())));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
			$this->setNom(strtoupper($this->getNom()));
			$this->setPrenom(ucfirst(strtolower($this->getPrenom())));
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
        return 'uploads/enfants';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'enfant_'.uniqid().'.'.$this->fichier->guessExtension();
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
        if ( file_exists($fichier) ) unlink($fichier);
    }

	  public function __toString()
    {
        return $this->getFullName();
    }

		public function validateDateNaissance(ExecutionContext $context)
		{
    if ( !empty($this->dateNaissance)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->dateNaissance->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.dateNaissance';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de naissance n\'est pas valide', array(), null);
			}
    }
		
		}

}