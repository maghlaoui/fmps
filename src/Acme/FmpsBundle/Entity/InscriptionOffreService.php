<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Acme\FmpsBundle\Util\FmpsLists;

/**
 * Acme\FmpsBundle\Entity\InscriptionOffreService
 *
 * @ORM\Table(name="inscription_offre_service")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\InscriptionOffreServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class InscriptionOffreService
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
     * @var integer $offreServiceId
     *
     * @ORM\Column(name="offre_service_id", type="integer", nullable=false)
     */
    private $offreServiceId;

    /**
     * @var integer $inscriptionId
     *
     * @ORM\Column(name="inscription_id", type="integer", nullable=false)
     */
    private $inscriptionId;

    /**
     * @var string $mois
     *
     * @ORM\Column(name="mois", type="string", length=125, nullable=false)
     */
    private $mois;

    /**
     * @var integer $valide
     *
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string $commentaire
     *
     * @ORM\Column(name="commentaire", type="string", nullable=true)
     */
    private $commentaire;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * Set offreServiceId
     *
     * @param integer $offreServiceId
     */
    public function setOffreServiceId($offreServiceId)
    {
        $this->offreServiceId = $offreServiceId;
    }

    /**
     * Get offreServiceId
     *
     * @return integer 
     */
    public function getOffreServiceId()
    {
        return $this->offreServiceId;
    }

    /**
     * Set inscriptionId
     *
     * @param integer $inscriptionId
     */
    public function setInscriptionId($inscriptionId)
    {
        $this->inscriptionId = $inscriptionId;
    }

    /**
     * Get inscriptionId
     *
     * @return integer 
     */
    public function getInscriptionId()
    {
        return $this->inscriptionId;
    }

    /**
     * Set mois
     *
     * @param string $mois
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }

    /**
     * Get mois
     *
     * @return string 
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get valide
     *
     * @return string 
     */
    public function getStatusStr()
    {
	      $status = FmpsLists::getDefaultOffreStatus();
        return $status[$this->status];
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

		/**
     * @ORM\ManyToOne(targetEntity="OffreService", inversedBy="InscriptionOffreService")
     * @ORM\JoinColumn(name="offre_service_id", referencedColumnName="id")
     */
    protected $offreService;

   	/**
	   * @ORM\ManyToOne(targetEntity="Inscription", inversedBy="InscriptionOffreService")
	   * @ORM\JoinColumn(name="inscription_id", referencedColumnName="id")
	   */
	  protected $inscription;
	
		/**
     * Set offreService
     *
     * @param Acme\FmpsBundle\Entity\OffreService $offreService
     */
    public function setOffreService(\Acme\FmpsBundle\Entity\OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    /**
     * Get offreService
     *
     * @return Acme\FmpsBundle\Entity\OffreService 
     */
    public function getOffreService()
    {
        return $this->offreService;
    }

		/**
     * Set inscription
     *
     * @param Acme\FmpsBundle\Entity\Inscription $inscription
     */
    public function setInscription(\Acme\FmpsBundle\Entity\Inscription $inscription)
    {
        $this->inscription = $inscription;
    }

    /**
     * Get inscription
     *
     * @return Acme\FmpsBundle\Entity\Inscription 
     */
    public function getInscription()
    {
        return $this->inscription;
    }
}