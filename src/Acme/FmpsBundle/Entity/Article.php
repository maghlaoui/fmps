<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
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
     * @var text $designation
     * @Assert\NotBlank
     * @ORM\Column(name="designation", type="text", nullable=false, unique=true)
     */
    private $designation;
    
    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Set designation
     *
     * @param string $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    /**
     * Get designation
     *
     * @return string 
     */
    public function getDesignation()
    {
        return $this->designation;
    }
    
    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * @ORM\OneToMany(targetEntity="ArticleBonCommande", mappedBy="article")
     */
    protected $articles_bons_commande;
    
    public function __construct()
    {
        $this->articles_bons_commande = new \Doctrine\Common\Collections\ArrayCollection();
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
        return $this->designation;
    }
    
    public function getTitleLength(){
       return strlen($this->getDesignation() . ' ' . $this->getDescription());
    }
    
}