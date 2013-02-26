<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\TypeContribution
 *
 * @ORM\Table(name="type_contribution")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\TypeContributionRepository")
 * @UniqueEntity("libelleTypeContribution")
 * @ORM\HasLifecycleCallbacks()
 */
class TypeContribution
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
     * @var string $libelleTypeContribution
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle_type_contribution", type="string", length=225, nullable=false, unique=true)
     */
    private $libelleTypeContribution;
    
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
			$this->setLibelleTypeContribution(ucfirst(strtolower($this->getLibelleTypeContribution())));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
      $this->setLibelleTypeContribution(ucfirst(strtolower($this->getLibelleTypeContribution())));
    }
    /**
     * Set libelleTypeContribution
     *
     * @param string $libelleTypeContribution
     */
    public function setLibelleTypeContribution($libelleTypeContribution)
    {
        $this->libelleTypeContribution = $libelleTypeContribution;
    }

    /**
     * Get libelleTypeContribution
     *
     * @return string 
     */
    public function getLibelleTypeContribution()
    {
        return $this->libelleTypeContribution;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="PartenariatPartenaire", mappedBy="type_contribution")
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
        return $this->libelleTypeContribution;
    }
}