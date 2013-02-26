<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\PaiementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Paiement
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
     * @var string $matricule
     *
     * @ORM\Column(name="matricule", type="string", length=255, nullable=false)
     */
    private $matricule;

    /**
     * @var date $datePaiement
     *
     * @ORM\Column(name="date_paiement", type="date", nullable=false)
     */
    private $datePaiement;

    /**
     * @var string $moyenPaiement
     *
     * @ORM\Column(name="moyen_paiement", type="string")
     */
    private $moyenPaiement;

    /**
     * @var float $montantPaiement
     *
     * @ORM\Column(name="montant_paiement", type="float", nullable=false)
     */
    private $montantPaiement;

    /**
     * @var string $nomPersonnePaiement
     *
     * @ORM\Column(name="nom_personne_paiement", type="string", length=50, nullable=false)
     */
    private $nomPersonnePaiement;

    /**
     * @var integer $inscriptionId
     *
     * @ORM\Column(name="inscription_id", type="integer", nullable=false)
     */
    private $inscriptionId;

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
     * @ORM\OneToOne(targetEntity="Inscription", cascade={"persist", "remove"})
		 * @ORM\JoinColumn(name="inscription_id", referencedColumnName="id")
     */
    private $inscription;


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
     * Set matricule
     *
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * Get matricule
     *
     * @return string 
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set datePaiement
     *
     * @param date $datePaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;
    }

    /**
     * Get datePaiement
     *
     * @return date 
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * Set moyenPaiement
     *
     * @param string $moyenPaiement
     */
    public function setMoyenPaiement($moyenPaiement)
    {
        $this->moyenPaiement = $moyenPaiement;
    }

    /**
     * Get moyenPaiement
     *
     * @return string 
     */
    public function getMoyenPaiement()
    {
        return $this->moyenPaiement;
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
     * Set nomPersonnePaiement
     *
     * @param string $nomPersonnePaiement
     */
    public function setNomPersonnePaiement($nomPersonnePaiement)
    {
        $this->nomPersonnePaiement = $nomPersonnePaiement;
    }

    /**
     * Get nomPersonnePaiement
     *
     * @return string 
     */
    public function getNomPersonnePaiement()
    {
        return $this->nomPersonnePaiement;
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