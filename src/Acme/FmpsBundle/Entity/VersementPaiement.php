<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\VersementPaiement
 *
 * @ORM\Table(name="versement_paiement")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class VersementPaiement
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
     * @var integer $virementId
     *
     * @ORM\Column(name="virement_id", type="integer", nullable=false)
     */
    private $virementId;

    /**
     * @var integer $paiementId
     *
     * @ORM\Column(name="paiement_id", type="integer", nullable=false)
     */
    private $paiementId;

    /**
     * @var float $montantVerse
     *
     * @ORM\Column(name="montant_verse", type="float", nullable=true)
     */
    private $montantVerse;

    /**
     * @var float $montantPaiement
     *
     * @ORM\Column(name="montant_paiement", type="float", nullable=true)
     */
    private $montantPaiement;

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
     * Set virementId
     *
     * @param integer $virementId
     */
    public function setVirementId($virementId)
    {
        $this->virementId = $virementId;
    }

    /**
     * Get virementId
     *
     * @return integer 
     */
    public function getVirementId()
    {
        return $this->virementId;
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
     * Set montantVerse
     *
     * @param float $montantVerse
     */
    public function setMontantVerse($montantVerse)
    {
        $this->montantVerse = $montantVerse;
    }

    /**
     * Get montantVerse
     *
     * @return float 
     */
    public function getMontantVerse()
    {
        return $this->montantVerse;
    }

    /**
     * Set montantPaiement
     *
     * @param float $montantPaiement
     */
    public function setMontantPaiement($montantPaiement)
    {
        $this->montantPaiement = $montantPaiement;
    }

    /**
     * Get montantPaiement
     *
     * @return float 
     */
    public function getMontantPaiement()
    {
        return $this->montantPaiement;
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
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}