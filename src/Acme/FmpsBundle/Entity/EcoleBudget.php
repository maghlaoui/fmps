<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\BudgetEcole
 *
 * @ORM\Table(name="ecole_budget")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EcoleBudgetRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EcoleBudget
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
     * @var integer $budgetId
     *
     * @ORM\Column(name="budget_id", type="integer", nullable=false)
     */
    private $budgetId;

    /**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

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
     * Set budgetId
     *
     * @param integer $budgetId
     */
    public function setBudgetId($budgetId)
    {
        $this->budgetId = $budgetId;
    }

    /**
     * Get budgetId
     *
     * @return integer 
     */
    public function getBudgetId()
    {
        return $this->budgetId;
    }

    /**
     * Set ecoleId
     *
     * @param integer $ecoleId
     */
    public function setEcoleId($ecoleId)
    {
        $this->ecoleId = $ecoleId;
    }

    /**
     * Get ecoleId
     *
     * @return integer 
     */
    public function getEcoleId()
    {
        return $this->ecoleId;
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
     * @ORM\ManyToOne(targetEntity="Budget")
     * @ORM\JoinColumn(name="budget_id", referencedColumnName="id")
     */
    protected $budget;

		  /**
     * @ORM\ManyToOne(targetEntity="Ecole")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

		/**
     * Set budget
     *
     * @param Acme\FmpsBundle\Entity\Budget $budget
     */
    public function setBudget(\Acme\FmpsBundle\Entity\Budget $budget)
    {
        $this->budget = $budget;
    }

   /**
     * Get budget
     *
     * @return Acme\FmpsBundle\Entity\Budget 
     */
    public function getBudget()
    {
        return $this->budget;
    }

		/**
     * Set ecole
     *
     * @param Acme\FmpsBundle\Entity\Ecole $ecole
     */
    public function setEcole(\Acme\FmpsBundle\Entity\Ecole $ecole)
    {
        $this->ecole = $ecole;
    }

   /**
     * Get ecole
     *
     * @return Acme\FmpsBundle\Entity\Ecole 
     */
    public function getEcole()
    {
        return $this->ecole;
    }
}