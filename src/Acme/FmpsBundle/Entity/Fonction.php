<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Fonction
 *
 * @ORM\Table(name="fonction")
 * @ORM\Entity
 * @UniqueEntity("libele")
 * @ORM\HasLifecycleCallbacks()
 */
class Fonction
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
     * @var string $libele
     * @Assert\NotBlank
     * @Assert\MinLength(3)
     * @ORM\Column(name="libele", type="string", length=255, nullable=false, unique=true)
     */
    private $libele;

    /**
     * @var smallint $niveauHierarchique
     *
     * @ORM\Column(name="niveau_hierarchique", type="smallint", nullable=true)
     */
    private $niveauHierarchique;
    
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
      $this->setNiveauHierarchique(0);
			$this->setLibele(ucfirst(strtolower($this->getLibele())));
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
			$this->setLibele(ucfirst(strtolower($this->getLibele())));
    }

    /**
     * Set libele
     *
     * @param string $libele
     */
    public function setLibele($libele)
    {
        $this->libele = $libele;
    }

    /**
     * Get libele
     *
     * @return string 
     */
    public function getLibele()
    {
        return $this->libele;
    }

    /**
     * Set niveauHierarchique
     *
     * @param smallint $niveauHierarchique
     */
    public function setNiveauHierarchique($niveauHierarchique)
    {
        $this->niveauHierarchique = $niveauHierarchique;
    }

    /**
     * Get niveauHierarchique
     *
     * @return smallint 
     */
    public function getNiveauHierarchique()
    {
        return $this->niveauHierarchique;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Employe", mappedBy="fonction")
     */
    protected $employes;

    /**
     * @ORM\OneToMany(targetEntity="EmployeFonction", mappedBy="fonction")
     */
    protected $fonctions;
    
    public function __construct()
    {
        $this->employes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fonctions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add employes
     *
     * @param Acme\FmpsBundle\Entity\Employe $employe
     */
    public function addEmploye(\Acme\FmpsBundle\Entity\Employe $employes)
    {
        $this->employes[] = $employes;
    }

    /**
     * Get employes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getEmployes()
    {
        return $this->employes;
    }

   /**
     * Add fonctions
     *
     * @param Acme\FmpsBundle\Entity\EmployeFonction $fonction
     */
    public function addFonction(\Acme\FmpsBundle\Entity\EmployeFonction $fonction)
    {
        $this->fonctions[] = $fonction;
    }

    /**
     * Get fonctions
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getFonctions()
    {
        return $this->fonctions;
    }
    
    public function __toString()
    {
        return $this->libele;
    }
}