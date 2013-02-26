<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\CategoryRepository")
 * @UniqueEntity("libelle")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
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
     * @var string $libelle
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle", type="string", length=255, nullable=false, unique=true)
     */
    private $libelle;

   /**
     * @var string $commentaire
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;
    
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
     * Set libelle
     *
     * @param string $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
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
    
    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * @ORM\OneToMany(targetEntity="OffreService", mappedBy="category")
     */
    protected $offresServices;

    /**
     * @ORM\OneToMany(targetEntity="Preinscription", mappedBy="category", cascade={"persist", "remove"})
     */
    private $preinscriptions;
    

    public function __construct()
    {
        $this->offresServices = new \Doctrine\Common\Collections\ArrayCollection();
				$this->preinscriptions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add offresServices
     *
     * @param Acme\FmpsBundle\Entity\OffreServioffresServicesce $offresServices
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
}