<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\SuiviArgPart
 *
 * @ORM\Table(name="suivi_arg_part")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\SuiviArgPartRepository")
 * @ORM\HasLifecycleCallbacks
 */
class SuiviArgPart
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
     * @var integer $montant
     *
     * @ORM\Column(name="montant", type="integer", nullable=true)
     */
    private $montant;

    /**
     * @var date $dateReception
     *
     * @ORM\Column(name="date_reception", type="date", nullable=true)
     */
    private $dateReception;

    /**
     * @var integer $partenariatPartenaireId
     *
     * @ORM\Column(name="partenariat_partenaire_id", type="integer", nullable=false)
     */
    private $partenariatPartenaireId;
    
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
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

    /**
     * Set montant
     *
     * @param integer $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return integer 
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set dateReception
     *
     * @param date $dateReception
     */
    public function setDateReception($dateReception)
    {
        $this->dateReception = $dateReception;
    }

    /**
     * Get dateReception
     *
     * @return date 
     */
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * Set partenariatPartenaireId
     *
     * @param integer $partenariatPartenaireId
     */
    public function setPartenariatPartenaireId($partenariatPartenaireId)
    {
        $this->partenariatPartenaireId = $partenariatPartenaireId;
    }

    /**
     * Get partenariatPartenaireId
     *
     * @return integer 
     */
    public function getPartenariatPartenaireId()
    {
        return $this->partenariatPartenaireId;
    }

	 /**
     * @ORM\ManyToOne(targetEntity="PartenariatPartenaire", inversedBy="suivis_argent")
     * @ORM\JoinColumn(name="partenariat_partenaire_id", referencedColumnName="id")
     */
    protected $partenariatPartenaire;

    /**
     * Set partenariatPartenaire
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenariatPartenaire
     */
    public function setPartenariatPartenaire(\Acme\FmpsBundle\Entity\PartenariatPartenaire $partenariatPartenaire)
    {
        $this->partenariatPartenaire = $partenariatPartenaire;
    }

    /**
     * Get partenariatPartenaire
     *
     * @return Acme\FmpsBundle\Entity\PartenariatPartenaire
     */
    public function getPartenariatPartenaire()
    {
        return $this->partenariatPartenaire;
    }

		/**
     * Get partenaire
     *
     * @return string
     */
    public function getPartenaire()
    {
			 $this->getPartenariatPartenaire()->getPartenaire()->getNomPartenaire();
    }

		/**
     * Get partenariat
     *
     * @return string
     */
		public function getPartenariat()
    {
	     $this->getPartenariatPartenaire()->getPartenariat()->getTitle();
    }

	 /**
     * @ORM\PostPersist()
     * @ORM\PreUpdate()
	   * @ORM\PostRemove()
     */
    public function updateMontantRecu()
    {
	   $partenariatPartenaire = $this->getPartenariatPartenaire();
	   $contributions = $partenariatPartenaire->getSuivisArgent();
	   $montantRecu = 0;
	   foreach ($contributions as $contribution)
	   {
		   $montantRecu += $contribution->getMontant();
	   }
	   $this->getPartenariatPartenaire()->setMontantRecu($montantRecu);
	}
   
}