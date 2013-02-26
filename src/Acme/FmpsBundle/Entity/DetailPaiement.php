<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\DetailPaiement
 *
 * @ORM\Table(name="detail_paiement")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class DetailPaiement
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
     * @var integer $moisId
     *
     * @ORM\Column(name="mois_id", type="integer", nullable=false)
     */
    private $moisId;

    /**
     * @var integer $serviceId
     *
     * @ORM\Column(name="service_id", type="integer", nullable=false)
     */
    private $serviceId;

    /**
     * @var integer $inscriptionId
     *
     * @ORM\Column(name="inscription_id", type="integer", nullable=false)
     */
    private $inscriptionId;

    /**
     * @var integer $paiementId
     *
     * @ORM\Column(name="paiement_id", type="integer", nullable=false)
     */
    private $paiementId;

    /**
     * @var string $etat
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var decimal $montant
     *
     * @ORM\Column(name="montant", type="decimal", nullable=false)
     */
    private $montant;

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
     * Set moisId
     *
     * @param integer $moisId
     */
    public function setMoisId($moisId)
    {
        $this->moisId = $moisId;
    }

    /**
     * Get moisId
     *
     * @return integer 
     */
    public function getMoisId()
    {
        return $this->moisId;
    }

    /**
     * Set serviceId
     *
     * @param integer $serviceId
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * Get serviceId
     *
     * @return integer 
     */
    public function getServiceId()
    {
        return $this->serviceId;
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
     * Set paiementId
     *
     * @param integer $paiementId
     */
    public function setPaiementId($paiementId)
    {
        $this->paiementId = $paiementId;
    }

    /**
     * Get paiementId
     *
     * @return integer 
     */
    public function getPaiementId()
    {
        return $this->paiementId;
    }

    /**
     * Set etat
     *
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set montant
     *
     * @param decimal $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return decimal 
     */
    public function getMontant()
    {
        return $this->montant;
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
}