<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\EnfantClasse
 *
 * @ORM\Table(name="enfant_classe")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EnfantClasseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class EnfantClasse
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
     * @var integer $enfantId
     *
     * @ORM\Column(name="enfant_id", type="integer", nullable=false)
     */
    private $enfantId;

    /**
     * @var integer $classeId
     *
     * @ORM\Column(name="classe_id", type="integer", nullable=false)
     */
    private $classeId;

    /**
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

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
     * Set enfantId
     *
     * @param integer $enfantId
     */
    public function setEnfantId($enfantId)
    {
        $this->enfantId = $enfantId;
    }

    /**
     * Get enfantId
     *
     * @return integer 
     */
    public function getEnfantId()
    {
        return $this->enfantId;
    }

    /**
     * Set classeId
     *
     * @param integer $classeId
     */
    public function setClasseId($classeId)
    {
        $this->classeId = $classeId;
    }

    /**
     * Get classeId
     *
     * @return integer 
     */
    public function getClasseId()
    {
        return $this->classeId;
    }

    /**
     * Set anneeScolaireId
     *
     * @param integer $anneeScolaireId
     */
    public function setAnneeScolaireId($anneeScolaireId)
    {
        $this->anneeScolaireId = $anneeScolaireId;
    }

    /**
     * Get anneeScolaireId
     *
     * @return integer 
     */
    public function getAnneeScolaireId()
    {
        return $this->anneeScolaireId;
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
     * @ORM\ManyToOne(targetEntity="AnneeScolaire")
     * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
     */
    protected $anneeScolaire;

	 /**
     * @ORM\ManyToOne(targetEntity="Classe")
     * @ORM\JoinColumn(name="classe_id", referencedColumnName="id")
     */
    protected $classe;

	 /**
     * @ORM\ManyToOne(targetEntity="Enfant")
     * @ORM\JoinColumn(name="enfant_id", referencedColumnName="id")
     */
    protected $enfant;

	 /**
     * Set anneeScolaire
     *
     * @param Acme\FmpsBundle\Entity\AnneeScolaire $anneeScolaire
     */
    public function setAnneeScolaire(\Acme\FmpsBundle\Entity\AnneeScolaire $anneeScolaire)
    {
        $this->anneeScolaire = $anneeScolaire;
    }

    /**
     * Get anneeScolaire
     *
     * @return Acme\FmpsBundle\Entity\AnneeScolaire 
     */
    public function getAnneeScolaire()
    {
        return $this->anneeScolaire;
    }

	/**
     * Set classe
     *
     * @param Acme\FmpsBundle\Entity\Classe $classe
     */
    public function setClasse(\Acme\FmpsBundle\Entity\Classe $classe)
    {
        $this->classe = $classe;
    }

    /**
     * Get classe
     *
     * @return Acme\FmpsBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }

	 /**
     * Set enfant
     *
     * @param Acme\FmpsBundle\Entity\Enfant $enfant
     */
    public function setEnfant(\Acme\FmpsBundle\Entity\Enfant $enfant)
    {
        $this->enfant = $enfant;
    }

    /**
     * Get enfant
     *
     * @return Acme\FmpsBundle\Entity\Enfant 
     */
    public function getEnfant()
    {
        return $this->enfant;
    }
}