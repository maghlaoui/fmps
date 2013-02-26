<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContext;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\EmployeAbsence
 *
 * @ORM\Table(name="employe_absence")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\EmployeAbsenceRepository")
 * @Assert\Callback(methods={"validateDate"})
 * @ORM\HasLifecycleCallbacks()
 */
class EmployeAbsence
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
     * @var integer $employeId
     *
     * @ORM\Column(name="employe_id", type="integer", nullable=false)
     */
    private $employeId;

    /**
     * @var date $du
     * @Assert\Date
     * @ORM\Column(name="du", type="date", nullable=false)
     */
    private $du;  //TODO check this is hifger to last "au"

    /**
     * @var date $au
     *
     * @ORM\Column(name="au", type="date", nullable=true)
     */
    private $au;

    /**
     * @var string $motif
     *
     * @ORM\Column(name="motif", type="string", length=125, nullable=false)
     */
    private $motif;

    /**
     * @var boolean $justifie
     *
     * @ORM\Column(name="justifie", type="boolean", nullable=true)
     */
    private $justifie;

    /**
     * @var string $commentaire
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

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
     * Set employeId
     *
     * @param integer $employeId
     */
    public function setEmployeId($employeId)
    {
        $this->employeId = $employeId;
    }

    /**
     * Get employeId
     *
     * @return integer 
     */
    public function getEmployeId()
    {
        return $this->employeId;
    }

    /**
     * Set du
     *
     * @param date $du
     */
    public function setDu($du)
    {
        $this->du = $du;
    }

    /**
     * Get du
     *
     * @return date 
     */
    public function getDu()
    {
        return $this->du;
    }

    /**
     * Set au
     *
     * @param date $au
     */
    public function setAu($au)
    {
        $this->au = $au;
    }

    /**
     * Get au
     *
     * @return date 
     */
    public function getAu()
    {
        return $this->au;
    }

    /**
     * Set motif
     *
     * @param string $motif
     */
    public function setMotif($motif)
    {
        $this->motif = $motif;
    }

    /**
     * Get motif
     *
     * @return string 
     */
    public function getMotif()
    {
        return $this->motif;
    }

    /**
     * Set justifie
     *
     * @param boolean $justifie
     */
    public function setJustifie($justifie)
    {
        $this->justifie = $justifie;
    }

    /**
     * Get justifie
     *
     * @return boolean 
     */
    public function getJustifie()
    {
        return $this->justifie;
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
	   * @ORM\ManyToOne(targetEntity="Employe", inversedBy="absences", cascade={"persist"})
	   * @ORM\JoinColumn(name="employe_id", referencedColumnName="id")
	   */
	  protected $employe;
	
	  /**
	   * Set employe
	    *
	    * @param Acme\FmpsBundle\Entity\Employe $employe
	    */
	  public function setEmploye(\Acme\FmpsBundle\Entity\Employe $employe)
	  {
	    $this->employe = $employe;
	  }

	  /**
	   * Get employe
	   *
	   * @return Acme\FmpsBundle\Entity\Employe
	   */
	  public function getEmploye()
	  {
	    return $this->employe;
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
        return 'uploads/absences';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'absence_'.uniqid().'.'.$this->fichier->guessExtension();
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
    if ( !empty($this->du) && !empty($this->au)  ){
	    $format = 'Y-m-d';
			if( $this->au->format($format) < $this->du->format($format) ) {
			  $propertyPath = $context->getPropertyPath() . '.au';
			  $context->setPropertyPath($propertyPath);
			  $context->addViolation('La date de fin doit être supérieur à la date de début', array(), null);
			}
    }
		
		}
}