<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\TypeEngagement
 *
 * @ORM\Table(name="type_engagement")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\TypeEngagementRepository")
 * @UniqueEntity("libelleTypeEngagement")
 * @ORM\HasLifecycleCallbacks()
 */
class TypeEngagement
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
     * @var string $libelleTypeEngagement
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle_type_engagement", type="string", length=125, nullable=true, unique=true)
     */
    private $libelleTypeEngagement;
    
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
      $this->setLibelleTypeEngagement(ucfirst(strtolower($this->getLibelleTypeEngagement())));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
      $this->setLibelleTypeEngagement(ucfirst(strtolower($this->getLibelleTypeEngagement())));
    }

    /**
     * Set libelleTypeEngagement
     *
     * @param string $libelleTypeEngagement
     */
    public function setLibelleTypeEngagement($libelleTypeEngagement)
    {
        $this->libelleTypeEngagement = $libelleTypeEngagement;
    }

    /**
     * Get libelleTypeEngagement
     *
     * @return string 
     */
    public function getLibelleTypeEngagement()
    {
        return $this->libelleTypeEngagement;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="PartenariatPartenaire", mappedBy="type_engagement")
     */
    protected $partenariats_partenaires;
    
    public function __construct()
    {
        $this->partenariats_partenaires = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add partenariats_partenaires
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenariats_partenaires
     */
    public function addPartenariatPartenaire(\Acme\FmpsBundle\Entity\PartenariatPartenaire $partenariats_partenaires)
    {
        $this->partenariats_partenaires[] = $partenariats_partenaires;
    }

    /**
     * Get partenaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartenariatsPartenaires()
    {
        return $this->partenariats_partenaires;
    }
    
    public function __toString()
    {
        return $this->libelleTypeEngagement;
    }
}