<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\Preinscription
 *
 * @ORM\Table(name="preinscription")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\PreinscriptionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Preinscription
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
     * @var string $nomEnfant
     *
     * @ORM\Column(name="nom_enfant", type="string", length=255, nullable=false)
     */
    private $nomEnfant;

    /**
     * @var string $prenomEnfant
     *
     * @ORM\Column(name="prenom_enfant", type="string", length=255, nullable=false)
     */
    private $prenomEnfant;

    /**
     * @var string $nomTiteur
     *
     * @ORM\Column(name="nom_titeur", type="string", length=255, nullable=false)
     */
    private $nomTiteur;

    /**
     * @var string $prenomTiteur
     *
     * @ORM\Column(name="prenom_titeur", type="string", length=255, nullable=false)
     */
    private $prenomTiteur;

    /**
     * @var string $telephoneTiteur
     *
     * @ORM\Column(name="telephone_titeur", type="string", length=255, nullable=false)
     */
    private $telephoneTiteur;

    /**
     * @var integer $sectionId
     *
     * @ORM\Column(name="section_id", type="integer", nullable=false)
     */
    private $sectionId;

    /**
     * @var integer $anneeScolaireId
     *
     * @ORM\Column(name="annee_scolaire_id", type="integer", nullable=false)
     */
    private $anneeScolaireId;

    /**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

    /**
     * @var integer $categoryId
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId;

    /**
     * @var string $commentaire
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * Set nomEnfant
     *
     * @param string $nomEnfant
     */
    public function setNomEnfant($nomEnfant)
    {
        $this->nomEnfant = $nomEnfant;
    }

    /**
     * Get nomEnfant
     *
     * @return string 
     */
    public function getNomEnfant()
    {
        return $this->nomEnfant;
    }

    /**
     * Set prenomEnfant
     *
     * @param string $prenomEnfant
     */
    public function setPrenomEnfant($prenomEnfant)
    {
        $this->prenomEnfant = $prenomEnfant;
    }

    /**
     * Get prenomEnfant
     *
     * @return string 
     */
    public function getPrenomEnfant()
    {
        return $this->prenomEnfant;
    }

    /**
     * Set nomTiteur
     *
     * @param string $nomTiteur
     */
    public function setNomTiteur($nomTiteur)
    {
        $this->nomTiteur = $nomTiteur;
    }

    /**
     * Get nomTiteur
     *
     * @return string 
     */
    public function getNomTiteur()
    {
        return $this->nomTiteur;
    }

    /**
     * Set prenomTiteur
     *
     * @param string $prenomTiteur
     */
    public function setPrenomTiteur($prenomTiteur)
    {
        $this->prenomTiteur = $prenomTiteur;
    }

    /**
     * Get prenomTiteur
     *
     * @return string 
     */
    public function getPrenomTiteur()
    {
        return $this->prenomTiteur;
    }

    /**
     * Set telephoneTiteur
     *
     * @param string $telephoneTiteur
     */
    public function setTelephoneTiteur($telephoneTiteur)
    {
        $this->telephoneTiteur = $telephoneTiteur;
    }

    /**
     * Get telephoneTiteur
     *
     * @return string 
     */
    public function getTelephoneTiteur()
    {
        return $this->telephoneTiteur;
    }

    /**
     * Set sectionId
     *
     * @param integer $sectionId
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    /**
     * Get sectionId
     *
     * @return integer 
     */
    public function getSectionId()
    {
        return $this->sectionId;
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
     * Set commentaire
     *
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
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
     * @ORM\ManyToOne(targetEntity="Ecole")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;
    
    /**
     * @ORM\ManyToOne(targetEntity="AnneeScolaire")
     * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
     */
    protected $anneeScolaire;
    
    /**
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    protected $section;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
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
     * Set section
     *
     * @param Acme\FmpsBundle\Entity\Section $section
     */
    public function setSection(\Acme\FmpsBundle\Entity\Section $section)
    {
        $this->section = $section;
    }

    /**
     * Get section
     *
     * @return Acme\FmpsBundle\Entity\Section 
     */
    public function getSection()
    {
        return $this->section;
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
	      return $this->getPrenomTiteur() . ' ' . $this->getNomTiteur();
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