<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Partenariat
 *
 * @ORM\Table(name="partenariat")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\PartenariatRepository")
 * @UniqueEntity("libellePartenariat")
 * @ORM\HasLifecycleCallbacks()
 */
class Partenariat
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
     * @var string $libellePartenariat
     *
     * @ORM\Column(name="libelle_partenariat", type="string", length=225, nullable=true, unique="true")
     */
    private $libellePartenariat;

    /**
     * @var text $objetPartenariat
     *
     * @ORM\Column(name="objet_partenariat", type="text", nullable=true)
     */
    private $objetPartenariat;

    /**
     * @var date $datePatenariat
     *
     * @ORM\Column(name="date_patenariat", type="date", nullable=true)
     */
    private $datePatenariat;

    /**
     * @var date $dateFinPartenariat
     *
     * @ORM\Column(name="date_fin_partenariat", type="date", nullable=true)
     */
    private $dateFinPartenariat;
    
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
     * Set libellePartenariat
     *
     * @param string $libellePartenariat
     */
    public function setLibellePartenariat($libellePartenariat)
    {
        $this->libellePartenariat = $libellePartenariat;
    }

    /**
     * Get libellePartenariat
     *
     * @return string 
     */
    public function getLibellePartenariat()
    {
        return $this->libellePartenariat;
    }

    /**
     * Set objetPartenariat
     *
     * @param text $objetPartenariat
     */
    public function setObjetPartenariat($objetPartenariat)
    {
        $this->objetPartenariat = $objetPartenariat;
    }

    /**
     * Get objetPartenariat
     *
     * @return text 
     */
    public function getObjetPartenariat()
    {
        return $this->objetPartenariat;
    }

    /**
     * Set datePatenariat
     *
     * @param date $datePatenariat
     */
    public function setDatePatenariat($datePatenariat)
    {
        $this->datePatenariat = $datePatenariat;
    }

    /**
     * Get datePatenariat
     *
     * @return date 
     */
    public function getDatePatenariat()
    {
        return $this->datePatenariat;
    }

    /**
     * Set dateFinPartenariat
     *
     * @param date $dateFinPartenariat
     */
    public function setDateFinPartenariat($dateFinPartenariat)
    {
        $this->dateFinPartenariat = $dateFinPartenariat;
    }

    /**
     * Get dateFinPartenariat
     *
     * @return date 
     */
    public function getDateFinPartenariat()
    {
        return $this->dateFinPartenariat;
    }
    
    public function getCode(){
        return sprintf('%03d', $this->getId()) . '/' . $this->getDatePatenariat()->format('Y');
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="partenariat")
     */
    protected $documents;
    
    /**
     * @ORM\OneToMany(targetEntity="GestionPartenariat", mappedBy="partenariat")
     */
    protected $gestion_partenariats;
    
    /**
     * @ORM\ManyToMany(targetEntity="Partenaire", mappedBy="partenariats", cascade={"persist"})
     */
    private $partenaires;
    
    /**
     * @ORM\OneToMany(targetEntity="Partenariat", mappedBy="partenariat")
     */
    protected $reseaux_prescolaire;
    
    
     /**
     * @ORM\OneToMany(targetEntity="PartenariatPartenaire", mappedBy="partenariat")
     */
    protected $partenariats_partenaires;
	
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gestion_partenariats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partenaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->reseaux_prescolaire = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partenariats_partenaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add gestion_partenariats
     *
     * @param Acme\FmpsBundle\Entity\GestionPartenariat $gestionPartenariats
     */
    public function addGestionPartenariat(\Acme\FmpsBundle\Entity\GestionPartenariat $gestionPartenariats)
    {
        $this->gestion_partenariats[] = $gestionPartenariats;
    }

    /**
     * Get gestion_partenariats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGestionPartenariats()
    {
        return $this->gestion_partenariats;
    }

    /**
     * Add partenaires
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenaires
     */
    public function addPartenaire(\Acme\FmpsBundle\Entity\Partenaire $partenaires)
    {
        $this->partenaires[] = $partenaires;
    }

    /**
     * Get partenaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * Add reseaux_prescolaire
     *
     * @param Acme\FmpsBundle\Entity\Partenariat $reseauxPrescolaire
     */
    public function addPartenariat(\Acme\FmpsBundle\Entity\Partenariat $reseauxPrescolaire)
    {
        $this->reseaux_prescolaire[] = $reseauxPrescolaire;
    }

    /**
     * Get reseaux_prescolaire
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getReseauxPrescolaire()
    {
        return $this->reseaux_prescolaire;
    }
    
    /**
     * Add partenariats_partenaires
     *
     * @param Acme\FmpsBundle\Entity\PartenariatPartenaire $partenariats_partenaires
     */
    public function addPartenariatsPartenaires(\Acme\FmpsBundle\Entity\PartenariatPartenaire $partenariats_partenaires)
    {
        $this->partenariats_partenaires[] = $partenariats_partenaires;
    }

    /**
     * Get partenariats_partenaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartenariatsPartenaires()
    {
        return $this->partenariats_partenaires;
    }

    public function getTitle()
	{
		return $this->getCode() . ' ' . $this->getLibellePartenariat();
	}
    
    public function __toString()
    {
        return $this->getTitle();
    }
}