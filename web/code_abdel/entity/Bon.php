<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Finder\Comparator\DateComparator;

/**
 * 
 * @ORM\Entity 
 * @ORM\Table(name="bon")
 * @ORM\Entity(repositoryClass="Acme\fmpsBundle\Entity\BonRepository")
 * @Assert\Callback(methods={"validateDate"})
 * @Assert\Callback(methods={"validateDatePaiement"})
 * @ORM\HasLifecycleCallbacks()
 * 
 */
class Bon
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
     * @var string $fournisseur
     *
     * @ORM\Column(name="fournisseur", type="string", length=255, nullable=false)
     */
    private $fournisseur;

    /**
     * @var integer $ecoleId
     *
     * @ORM\Column(name="ecole_id", type="integer", nullable=false)
     */
    private $ecoleId;

    /**
     * @var integer $rubriqueId
     *
     * @ORM\Column(name="rubrique_id", type="integer", nullable=false)
     */
    private $rubriqueId;

    /**
     * @var string $patente
     *
     * @ORM\Column(name="patente", type="string", length=255, nullable=false)
     */
    private $patente;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string $objet
     *
     * @ORM\Column(name="objet", type="string", length=255, nullable=false)
     */
    private $objet;

    /**
     * @var float $montant
     *
     * @ORM\Column(name="montant", type="float", nullable=false)
     */
    private $montant;

    /**
     * @var date $datePaiement
     *
     * @ORM\Column(name="date_paiement", type="date", nullable=true)
     */
    private $datePaiement;

    /**
     * @var string $fichier
     *
     * @ORM\Column(name="fichier", type="string", length=125, nullable=true)
     */
    private $fichier;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=125, nullable=true)
     */
    private $path;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Ecole")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    protected $ecole;

    /**
     * @ORM\ManyToOne(targetEntity="Rubrique")
     * @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     */
    protected $rubrique;



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
     * Set fournisseur
     *
     * @param string $fournisseur
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;
    }

    /**
     * Get fournisseur
     *
     * @return string 
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
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
     * Set patente
     *
     * @param string $patente
     */
    public function setPatente($patente)
    {
        $this->patente = $patente;
    }

    /**
     * Get patente
     *
     * @return string 
     */
    public function getPatente()
    {
        return $this->patente;
    }

    /**
     * Set date
     *
     * @param date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return date 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set objet
     *
     * @param string $objet
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
    }

    /**
     * Get objet
     *
     * @return string 
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * Set montant
     *
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * Get montant
     *
     * @return float 
     */
    public function getMontant()
    {
        return $this->montant;
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
     * Set fichier
     *
     * @param string $fichier
     */
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
    }

    /**
     * Get fichier
     *
     * @return string 
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
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

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/bons';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'bons_'.uniqid().'.'.$this->fichier->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->fichier) {
            return;
        }

        $this->fichier->move($this->getUploadRootDir(), $this->path);
        unset($this->fichier);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fichier = $this->getAbsolutePath();
        if ( file_exists($fichier)) unlink($fichier);
    }

		public function ValidateDate(ExecutionContext $context)

		{
    if ( !empty($this->date)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->date->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.date';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date doit être inférieur ou égale à celle d\'aujourd\'hui', array(), null);
			}
    }

		}

		public function ValidateDatePaiement(ExecutionContext $context)

		{
    if ( !empty($this->datePaiement)  ){
	    $format = 'Y-m-d';
	    $dateComparator = new DateComparator($this->datePaiement->format($format));
			$dateComparator->setOperator("<=");
			$date = new \DateTime('now');
			if($dateComparator->test($date->format('U'))) {
			  $propertyPath = $context->getPropertyPath() . '.datePaiement';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de paiement doit être inférieur ou égale à celle d\'aujourd\'hui', array(), null);
			}
    }

		}
}