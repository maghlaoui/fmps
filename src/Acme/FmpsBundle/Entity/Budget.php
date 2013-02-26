<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Budget
 *
 * @ORM\Table(name="budget", uniqueConstraints={@ORM\UniqueConstraint(name="fk_budget_rubrique1", columns={"rubriqueId", "annee"})})
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\BudgetRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Budget
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
     * @var integer $rubriqueId
     *
     * @ORM\Column(name="rubrique_id", type="integer", nullable=false)
     */
    private $rubriqueId;

    /**
     * @var string $annee
     * @Assert\NotBlank
     * @ORM\Column(name="annee", type="string", nullable=true)
     */
    private $annee;

    /**
     * @var string $montant
     * @Assert\NotBlank
     * @ORM\Column(name="montant", type="string", length=125, nullable=true)
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
     * @var Rubrique
     *
     * @ORM\ManyToOne(targetEntity="Rubrique")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     * })
     */
    private $rubrique;


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
     * Set rubriqueId
     *
     * @param integer $rubriqueId
     */
    public function setRubriqueId($rubriqueId)
    {
        $this->rubriqueId = $rubriqueId;
    }

    /**
     * Get rubriqueId
     *
     * @return integer 
     */
    public function getRubriqueId()
    {
        return $this->rubriqueId;
    }

    /**
     * Set annee
     *
     * @param date $annee
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;
    }

    /**
     * Get annee
     *
     * @return date 
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set montant
     *
     * @param string $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return string 
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

    /**
     * Set rubrique
     *
     * @param Acme\FmpsBundle\Entity\Rubrique $rubrique
     */
    public function setRubrique(\Acme\FmpsBundle\Entity\Rubrique $rubrique)
    {
        $this->rubrique = $rubrique;
    }

    /**
     * Get rubrique
     *
     * @return Acme\FmpsBundle\Entity\Rubrique 
     */
    public function getRubrique()
    {
        return $this->rubrique;
    }

    public function __toString()
    {
        return $this->getRubrique()->getIntitule() . ' ('. $this->getAnnee() .')';
    }

    public function getEcoles()
    {
	
    }

    public function setEcoles($id, $ecoles)
		{
			//find ecoles
			//find existed relations between ecole and budget
			
		}
}