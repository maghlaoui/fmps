<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity
 * @UniqueEntity("libelleService")
 * @ORM\HasLifecycleCallbacks()
 */
class Service
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
     * @var string $libelleService
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libelle_service", type="string", length=125, nullable=false, unique=true)
     */
    private $libelleService;

    /**
     * @var string $demService
     *
     * @ORM\Column(name="dem_service", type="string", length=125, nullable=true)
     */
    private $demService;

		/**
     * @var boolean $obligatoire
     *
     * @ORM\Column(name="obligatoire", type="boolean")
     */
    private $obligatoire;

		/**
     * @var string $periode
     *
     * @ORM\Column(name="periode", type="string", length=125, nullable=false)
     */
    private $periode;
    
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

    /**
     * Set libelleService
     *
     * @param string $libelleService
     */
    public function setLibelleService($libelleService)
    {
        $this->libelleService = $libelleService;
    }

    /**
     * Get libelleService
     *
     * @return string 
     */
    public function getLibelleService()
    {
        return $this->libelleService;
    }

    /**
     * Set demService
     *
     * @param string $demService
     */
    public function setDemService($demService)
    {
        $this->demService = $demService;
    }

    /**
     * Get demService
     *
     * @return string 
     */
    public function getDemService()
    {
        return $this->demService;
    }

    /**
     * Set boolean
     *
     * @param boolean $obligatoire
     */
    public function setObligatoire($obligatoire)
    {
        $this->obligatoire = $obligatoire;
    }

    /**
     * Get obligatoire
     *
     * @return boolean 
     */
    public function getObligatoire()
    {
        return $this->obligatoire;
    }

    /**
     * Set periode
     *
     * @param string $periode
     */
    public function setPeriode($periode)
    {
        $this->periode = $periode;
    }

    /**
     * Get periode
     *
     * @return string 
     */
    public function getPeriode()
    {
        return $this->periode;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="OffreService", mappedBy="service")
     */
    protected $offresServices;
    

    public function __construct()
    {
        $this->offresServices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add offresServices
     *
     * @param Acme\FmpsBundle\Entity\OffreService $offresServices
     */
    public function addOffreService(\Acme\FmpsBundle\Entity\OffreService $offresServices)
    {
        $this->offresServices[] = $offresServices;
    }

    /**
     * Get offresServices
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getOffresServices()
    {
        return $this->offresServices;
    }
    
    public function __toString()
    {
        return (string)$this->libelleService;
    }
}