<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\OffreService
 *
 * @ORM\Table(name="offre_service")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\OffreServiceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OffreService
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
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

    /**
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

    /**
     * @var integer $serviceId
     *
     * @ORM\Column(name="service_id", type="integer", nullable=false)
     */
    private $serviceId;

    /**
     * @var integer $categoryId
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId;

    /**
     * @var integer $montantService
     *
     * @ORM\Column(name="montant_service", type="integer", nullable=true)
     */
    private $montantService;

		/**
     * @var boolean $mois
     *
     * @ORM\Column(name="mois", type="boolean")
     */
    private $mois;
    
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
      $this->setMois( $this->getService()->getPeriode() == 'mensuelle' );
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
			$this->setMois( $this->getService()->getPeriode() == 'mensuelle' );
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
     * Set categoryId
     *
     * @param integer $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set montantService
     *
     * @param integer $montantService
     */
    public function setMontantService($montantService)
    {
        $this->montantService = $montantService;
    }

    /**
     * Get montantService
     *
     * @return integer 
     */
    public function getMontantService()
    {
        return $this->montantService;
    }

    /**
     * Set mois
     *
     * @param boolean $mois
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }

    /**
     * Get mois
     *
     * @return boolean 
     */
    public function getMois()
    {
        return $this->mois;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="offresServices")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;
    
    /**
     * @ORM\ManyToOne(targetEntity="AnneeScolaire", inversedBy="offresServices")
     * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
     */
    protected $anneeScolaire;
    
    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="offresServices")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */
    protected $service;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="offresServices")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

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
     * Set service
     *
     * @param Acme\FmpsBundle\Entity\Service $service
     */
    public function setService(\Acme\FmpsBundle\Entity\Service $service)
    {
        $this->service = $service;
    }

    /**
     * Get service
     *
     * @return Acme\FmpsBundle\Entity\Service 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set category
     *
     * @param Acme\FmpsBundle\Entity\Category $category
     */
    public function setCategory(\Acme\FmpsBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Acme\FmpsBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
	  {
	      return $this->getService()->getLibelleService();
	  }
}