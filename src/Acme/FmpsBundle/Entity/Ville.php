<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\VilleRepository")
 * @UniqueEntity("libelleVille")
 * @ORM\HasLifecycleCallbacks()
 */
class Ville
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
     * @var string $libelleVille
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle_ville", type="string", length=125, nullable=false, unique=true)
     */
    private $libelleVille;
    
    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

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
     * Set created_at
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * Get created_at
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
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
     * Set libelleVille
     *
     * @param string $libelleVille
     */
    public function setLibelleVille($libelleVille)
    {
        $this->libelleVille = $libelleVille;
    }

    /**
     * Get libelleVille
     *
     * @return string 
     */
    public function getLibelleVille()
    {
        return $this->libelleVille;
    }

    /**
     * Get partenairesCount
     *
     * @return integer 
     */
    public function getPartenairesCount()
    {
        return count($this->partenaires);
    }

    /**
     * Get ecolesCount
     *
     * @return integer 
     */
    public function getEcolesCount()
    {
        return count($this->ecoles);
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Ecole", mappedBy="ville", cascade={"persist"})
     */
    protected $ecoles;
    
    /**
     * @ORM\OneToMany(targetEntity="Partenaire", mappedBy="ville", cascade={"persist"})
     */
    protected $partenaires;
    
    public function __construct()
    {
        $this->ecoles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partenaires = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add partenaires
     *
     * @param Acme\FmpsBundle\Entity\Ville $partenaires
     */
    public function addVille(\Acme\FmpsBundle\Entity\Ville $partenaires)
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
    
    public function __toString()
    {
        return $this->libelleVille;
    }
    
}