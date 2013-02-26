<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\GestionPartenariat
 *
 * @ORM\Table(name="gestion_partenariat")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\GestionPartenariatRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class GestionPartenariat
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
     * @var integer $partenariatId
     *
     * @ORM\Column(name="partenariat_id", type="integer", nullable=false)
     */
    private $partenariatId;

    /**
     * @var date $dateAffectationGestion
     *
     * @ORM\Column(name="date_affectation_gestion", type="date", nullable=true)
     */
    private $dateAffectationGestion;

    /**
     * @var date $dateFinAffectationGestion
     *
     * @ORM\Column(name="date_fin_affectation_gestion", type="date", nullable=true)
     */
    private $dateFinAffectationGestion;

    /**
     * @var integer $contactId
     *
     * @ORM\Column(name="contact_id", type="integer", nullable=false)
     */
    private $contactId;
    
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
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
    }
    /**
     * Set partenariatId
     *
     * @param integer $partenariatId
     */
    public function setPartenariatId($partenariatId)
    {
        $this->partenariatId = $partenariatId;
    }

    /**
     * Get partenariatId
     *
     * @return integer 
     */
    public function getPartenariatId()
    {
        return $this->partenariatId;
    }

    /**
     * Set dateAffectationGestion
     *
     * @param date $dateAffectationGestion
     */
    public function setDateAffectationGestion($dateAffectationGestion)
    {
        $this->dateAffectationGestion = $dateAffectationGestion;
    }

    /**
     * Get dateAffectationGestion
     *
     * @return date 
     */
    public function getDateAffectationGestion()
    {
        return $this->dateAffectationGestion;
    }

    /**
     * Set dateFinAffectationGestion
     *
     * @param date $dateFinAffectationGestion
     */
    public function setDateFinAffectationGestion($dateFinAffectationGestion)
    {
        $this->dateFinAffectationGestion = $dateFinAffectationGestion;
    }

    /**
     * Get dateFinAffectationGestion
     *
     * @return date 
     */
    public function getDateFinAffectationGestion()
    {
        return $this->dateFinAffectationGestion;
    }

    /**
     * Set contactId
     *
     * @param integer $contactId
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;
    }

    /**
     * Get contactId
     *
     * @return integer 
     */
    public function getContactId()
    {
        return $this->contactId;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Partenariat", inversedBy="gestion_partenariats")
     * @ORM\JoinColumn(name="partenariat_id", referencedColumnName="id")
     */
    protected $partenariat;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="gestion_partenariats")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    protected $contact;

    /**
     * Set partenariat
     *
     * @param Acme\FmpsBundle\Entity\Partenariat $partenariat
     */
    public function setPartenariat(\Acme\FmpsBundle\Entity\Partenariat $partenariat)
    {
        $this->partenariat = $partenariat;
    }

    /**
     * Get partenariat
     *
     * @return Acme\FmpsBundle\Entity\Partenariat 
     */
    public function getPartenariat()
    {
        return $this->partenariat;
    }

    /**
     * Set contact
     *
     * @param Acme\FmpsBundle\Entity\Contact $contact
     */
    public function setContact(\Acme\FmpsBundle\Entity\Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get contact
     *
     * @return Acme\FmpsBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}