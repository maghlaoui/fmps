<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\ReseauPrescolaire
 *
 * @ORM\Table(name="reseau_prescolaire")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\ReseauPrescolaireRepository")
 * @UniqueEntity("libelleReseauPrescolaire")
 * @ORM\HasLifecycleCallbacks()
 */
class ReseauPrescolaire
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
     * @var text $libelleReseauPrescolaire
     *
     * @ORM\Column(name="libelle_reseau_prescolaire", type="text", nullable=false, unique=true)
     */
    private $libelleReseauPrescolaire;

    /**
     * @var integer $partenariatId
     *
     * @ORM\Column(name="partenariat_id", type="integer", nullable=false)
     */
    private $partenariatId;
    
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
     * Set libelleReseauPrescolaire
     *
     * @param text $libelleReseauPrescolaire
     */
    public function setLibelleReseauPrescolaire($libelleReseauPrescolaire)
    {
        $this->libelleReseauPrescolaire = $libelleReseauPrescolaire;
    }

    /**
     * Get libelleReseauPrescolaire
     *
     * @return text 
     */
    public function getLibelleReseauPrescolaire()
    {
        return $this->libelleReseauPrescolaire;
    }

    /**
     * Set partenariatId
     *
     * @param integer $partenariatId
     */
    public function setPartenariatId($partenariatId)
    {
        $this->partenariatId = $partenariatId;
    }

    /**
     * Get partenariatId
     *
     * @return integer 
     */
    public function getPartenariatId()
    {
        return $this->partenariatId;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Ecole", mappedBy="reseau_prescolaire")
     */
    protected $ecoles;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partenariat", inversedBy="reseaux_prescolaire")
     * @ORM\JoinColumn(name="partenariat_id", referencedColumnName="id")
     */
    protected $partenariat;
    
    public function __construct()
    {
        $this->ecoles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add ecoles
     *
     * @param Acme\FmpsBundle\Entity\Ecole $ecoles
     */
    public function addEcole(\Acme\FmpsBundle\Entity\Ecole $ecoles)
    {
        $this->ecoles[] = $ecoles;
    }

    /**
     * Get ecoles
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEcoles()
    {
        return $this->ecoles;
    }

    /**
     * Set partenariat
     *
     * @param Acme\FmpsBundle\Entity\Partenariat $partenariat
     */
    public function setPartenariat(\Acme\FmpsBundle\Entity\Partenariat $partenariat)
    {
        $this->partenariat = $partenariat;
    }

    /**
     * Get partenariat
     *
     * @return Acme\FmpsBundle\Entity\Partenariat 
     */
    public function getPartenariat()
    {
        return $this->partenariat;
    }
    
    public function __toString()
    {
        return $this->libelleReseauPrescolaire;
    }
}