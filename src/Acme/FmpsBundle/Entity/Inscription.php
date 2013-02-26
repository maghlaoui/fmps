<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;

/**
 * Acme\FmpsBundle\Entity\Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\InscriptionRepository")
 * @UniqueEntity("numDemande")
 * @Assert\Callback(methods={"validateDateDemande"})
 * @ORM\HasLifecycleCallbacks()
 */
class Inscription
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
     * @var string $numDemande
     *
     * @ORM\Column(name="num_demande", type="string", length=255, nullable=false, unique=true)
     */
    private $numDemande;

    /**
     * @var date $dateDemande
     *
     * @ORM\Column(name="date_demande", type="date", nullable=false)
     */
    private $dateDemande;

    /**
     * @var boolean $typeDemande
     *
     * @ORM\Column(name="type_demande", type="boolean", nullable=false)
     */
    private $typeDemande;

    /**
     * @var boolean $etatDemande
     *
     * @ORM\Column(name="etat_demande", type="boolean", nullable=false)
     */
    private $etatDemande;

    /**
     * @var date $dateEntree
     *
     * @ORM\Column(name="date_entree", type="date", nullable=false)
     */
    private $dateEntree;

    /**
     * @var date $dateSortie
     *
     * @ORM\Column(name="date_sortie", type="date", nullable=false)
     */
    private $dateSortie;

    /**
     * @var integer $categoryId
     *
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $categoryId;

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
     * @var integer $sectionId
     *
     * @ORM\Column(name="section_id", type="integer", nullable=false)
     */
    private $sectionId;

    /**
     * @var integer $titeurId
     *
     * @ORM\Column(name="titeur_id", type="integer", nullable=false)
     */
    private $titeurId;

    /**
     * @var integer $enfantId
     *
     * @ORM\Column(name="enfant_id", type="integer", nullable=false)
     */
    private $enfantId;

    /**
     * @var boolean $assurance
     *
     * @ORM\Column(name="assurance", type="boolean", nullable=true)
     */
    private $assurance;

		/**
     * @var boolean $validated
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;

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
		 * Holds the Doctrine entity manager for database interaction
		 * @var EntityManager 
		 */

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
     * Set numDemande
     *
     * @param string $numDemande
     */
    public function setNumDemande($numDemande)
    {
        $this->numDemande = $numDemande;
    }

    /**
     * Get numDemande
     *
     * @return string 
     */
    public function getNumDemande()
    {
        return $this->numDemande;
    }

    /**
     * Set dateDemande
     *
     * @param date $dateDemande
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;
    }

    /**
     * Get dateDemande
     *
     * @return date 
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set typeDemande
     *
     * @param boolean $typeDemande
     */
    public function setTypeDemande($typeDemande)
    {
        $this->typeDemande = $typeDemande;
    }

    /**
     * Get typeDemande
     *
     * @return boolean 
     */
    public function getTypeDemande()
    {
        return $this->typeDemande;
    }

    /**
     * Set etatDemande
     *
     * @param boolean $etatDemande
     */
    public function setEtatDemande($etatDemande)
    {
        $this->etatDemande = $etatDemande;
    }

    /**
     * Get etatDemande
     *
     * @return boolean 
     */
    public function getEtatDemande()
    {
        return $this->etatDemande;
    }

    /**
     * Set dateEntree
     *
     * @param date $dateEntree
     */
    public function setDateEntree($dateEntree)
    {
        $this->dateEntree = $dateEntree;
    }

    /**
     * Get dateEntree
     *
     * @return date 
     */
    public function getDateEntree()
    {
        return $this->dateEntree;
    }

    /**
     * Set dateSortie
     *
     * @param date $dateSortie
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;
    }

    /**
     * Get dateSortie
     *
     * @return date 
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
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
     * Set titeurId
     *
     * @param integer $titeurId
     */
    public function setTiteurId($titeurId)
    {
        $this->titeurId = $titeurId;
    }

    /**
     * Get titeurId
     *
     * @return integer 
     */
    public function getTiteurId()
    {
        return $this->titeurId;
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
     * Set assurance
     *
     * @param boolean $assurance
     */
    public function setAssurance($assurance)
    {
        $this->assurance = $assurance;
    }

    /**
     * Get assurance
     *
     * @return boolean 
     */
    public function getAssurance()
    {
        return $this->assurance;
    }

		/**
     * Set validated
     *
     * @param boolean $validated
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
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
			
			//TODO
			//valide { 0, 1, 2, 3} 
			//0 n'existe pas dans la période
			//1 enfant n'a pas encore payé 
			//2 mois gratuit
			//3 payé
			//1 est la valeur par défaut 
			//Si il vient après le commecement on met les mois à 0 ( sauf les frais d'inscription )
			//quand l'utilisateur pai on valide son inscription
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }

	  /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="Inscription")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     */
    protected $section;

	  /**
     * @ORM\ManyToOne(targetEntity="AnneeScolaire", inversedBy="Inscription")
     * @ORM\JoinColumn(name="annee_scolaire_id", referencedColumnName="id")
     */
    protected $anneeScolaire;

	  /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="Inscription")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

	  /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Inscription")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="Titeur", inversedBy="Inscription", cascade={"persiste", "remove"})
     * @ORM\JoinColumn(name="titeur_id", referencedColumnName="id")
     */
    protected $titeur;

	  /**
     * @ORM\ManyToOne(targetEntity="Enfant", inversedBy="inscriptions", cascade={"all"})
     * @ORM\JoinColumn(name="enfant_id", referencedColumnName="id")
     */
    protected $enfant;

    public function __construct()
    {
		  $this->setDateDemande(new \DateTime());
			if ( date('m') < 9 ) {
				$value = new \DateTime();
				$value->setDate(date('Y'),'09', '01');
				$this->setDateEntree($value);
			} 
			else{
				$this->setDateEntree(new \DateTime());
			}
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

	  /**
     * Set titeur
     *
     * @param Acme\FmpsBundle\Entity\Titeur $titeur
     */
    public function setTiteur(\Acme\FmpsBundle\Entity\Titeur $titeur)
    {
        $this->titeur = $titeur;
    }

    /**
     * Get titeur
     *
     * @return Acme\FmpsBundle\Entity\Titeur 
     */
    public function getTiteur()
    {
        return $this->titeur;
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

		public function __toString()
	  {
	      return $this->getEnfant()->getNom() . ' ' . $this->getEnfant()->getPrenom();
	  }
	
		public function validateDateDemande(ExecutionContext $context)
		{
    if ( !empty($this->dateDemande)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->dateDemande->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.dateDemande';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de la demande doit être inférieur ou égale à la date d\'aujourd\'hui', array(), null);
			}
    }
		
		}
}