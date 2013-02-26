<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\PartenariatPartenaire
 *
 * @ORM\Table(name="partenariat_partenaire")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\PartenariatPartenaireRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class PartenariatPartenaire
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
     * @var integer $partenariatId
     *
     * @ORM\Column(name="partenariat_id", type="integer", nullable=false)
     */
    private $partenariatId;

    /**
     * @var integer $partenaireId
     *
     * @ORM\Column(name="partenaire_id", type="integer", nullable=false)
     */
    private $partenaireId;

    /**
     * @var integer $montantParticipation
     *
     * @ORM\Column(name="montant_participation", type="decimal", scale="2", nullable=true)
     */
    private $montantParticipation;

	/**
     * @var integer $montantRecu
     *
     * @ORM\Column(name="montant_recu", type="decimal", scale="2", nullable=true)
     */
    private $montantRecu;
    
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
     * @var integer $typeEngagementId
     *
     * @ORM\Column(name="type_engagement_id", type="integer", nullable=true)
     */
    private $typeEngagementId;
    
    /**
     * @var integer $typeContributionId
     *
     * @ORM\Column(name="type_contribution_id", type="integer", nullable=true)
     */
    private $typeContributionId;
    
    /**
     * @var string $detail
     *
     * @ORM\Column(name="detail", type="string", nullable=true)
     */
    private $detail;
    
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
     * Set partenaireId
     *
     * @param integer $partenaireId
     */
    public function setPartenaireId($partenaireId)
    {
        $this->partenaireId = $partenaireId;
    }

    /**
     * Get partenaireId
     *
     * @return integer 
     */
    public function getPartenaireId()
    {
        return $this->partenaireId;
    }

    /**
     * Set montantParticipation
     *
     * @param integer $montantParticipation
     */
    public function setMontantParticipation($montantParticipation)
    {
        $this->montantParticipation = $montantParticipation;
    }

    /**
     * Get montantParticipation
     *
     * @return integer 
     */
    public function getMontantParticipation()
    {
        return $this->montantParticipation;
    }


	/**
     * Set montantRecu
     *
     * @param integer $montantRecu
     */
    public function setMontantRecu($montantRecu)
    {
        $this->montantRecu = $montantRecu;
    }

    /**
     * Get montantRecu
     *
     * @return integer 
     */
    public function getMontantRecu()
    {
        return $this->montantRecu;
    }
    
     /**
     * Get typeEngagementId
     *
     * @return integer 
     */
    public function getTypeEngagementId()
    {
        return $this->typeEngagementId;
    }

    /**
     * Set typeEngagementId
     *
     * @param integer $typeEngagementId
     */
    public function setTypeEngagementId($typeEngagementId)
    {
        $this->typeEngagementId = $typeEngagementId;
    }
    
    /**
     * Get typeContributionId
     *
     * @return integer 
     */
    public function getTypeContributionId()
    {
        return $this->typeContributionId;
    }

    /**
     * Set typeContributionId
     *
     * @param integer $typeContributionId
     */
    public function setTypeContributionId($typeContributionId)
    {
        $this->typeContributionId = $typeContributionId;
    }
    
    /**
     * Get detail
     *
     * @return string 
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set detail
     *
     * @param string $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }
    
     /**
     * @ORM\ManyToOne(targetEntity="Partenaire", inversedBy="partenariats_partenaires")
     * @ORM\JoinColumn(name="partenaire_id", referencedColumnName="id")
     */
    protected $partenaire;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partenariat", inversedBy="partenariats_partenaires")
     * @ORM\JoinColumn(name="partenariat_id", referencedColumnName="id")
     */
    protected $partenariat;
    
     /**
     * @ORM\ManyToOne(targetEntity="TypeEngagement", inversedBy="partenariats_partenaires", cascade={"persist"})
     * @ORM\JoinColumn(name="type_engagement_id", referencedColumnName="id")
     */
    protected $type_engagement;
    
    /**
     * @ORM\ManyToOne(targetEntity="TypeContribution", inversedBy="partenariats_partenaires", cascade={"persist"})
     * @ORM\JoinColumn(name="type_contribution_id", referencedColumnName="id")
     */
    protected $type_contribution;

	/**
     * @ORM\OneToMany(targetEntity="SuiviArgPart", mappedBy="partenariatPartenaire", cascade={"persist", "remove"})
     */
    protected $suivis_argent;

   	public function __construct()
    {
        $this->suivis_argent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set partenaire
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenaire
     */
    public function setPartenaire(\Acme\FmpsBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire = $partenaire;
    }

    /**
     * Get partenaire
     *
     * @return Acme\FmpsBundle\Entity\Partenaire 
     */
    public function getPartenaire()
    {
        return $this->partenaire;
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
    
    /**
     * Set typeEngagement
     *
     * @param Acme\FmpsBundle\Entity\TypeEngagement $typeEngagement
     */
    public function setTypeEngagement(\Acme\FmpsBundle\Entity\TypeEngagement $typeEngagement)
    {
        $this->type_engagement = $typeEngagement;
    }

    /**
     * Get typeEngagement
     *
     * @return Acme\FmpsBundle\Entity\TypeEngagement
     */
    public function getTypeEngagement()
    {
        return $this->type_engagement;
    }
    
    /**
     * Set typeContribution
     *
     * @param Acme\FmpsBundle\Entity\TypeContribution $typeContribution
     */
    public function setTypeContribution(\Acme\FmpsBundle\Entity\TypeContribution $typeContribution)
    {
        $this->type_contribution = $typeContribution;
    }

    /**
     * Get typeContribution
     *
     * @return Acme\FmpsBundle\Entity\TypeContribution
     */
    public function getTypeContribution()
    {
        return $this->type_contribution;
    }

	/**
     * Add suivis_argent
     *
     * @param Acme\FmpsBundle\Entity\SuiviArgPart $suivisArgent
     */
    public function addSuiviArgPart(\Acme\FmpsBundle\Entity\SuiviArgPart $suivisArgent)
    {
        $this->suivis_argent[] = $suivisArgent;
    }

    /**
     * Get suivis_argent
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSuivisArgent()
    {
        return $this->suivis_argent;
    }
    
    public function __toString()
    {
        return $this->getPartenaire()->getNomPartenaire();
    }
     
}