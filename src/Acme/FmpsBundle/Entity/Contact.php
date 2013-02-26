<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\ContactRepository")
 * @UniqueEntity("nomContact")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
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
     * @var string $nomContact
     * @Assert\NotBlank
     * @ORM\Column(name="nom_contact", type="string", length=45, nullable=false, unique=true)
     */
    private $nomContact;

    /**
     * @var string $prenomContact
     * @Assert\NotBlank
     * @ORM\Column(name="prenom_contact", type="string", length=45, nullable=true)
     */
    private $prenomContact;

    /**
     * @var string $tel1Contact
     *
     * @ORM\Column(name="tel1_contact", type="string", length=45, nullable=true)
     */
    private $tel1Contact;

    /**
     * @var string $tel2Contact
     *
     * @ORM\Column(name="tel2_contact", type="string", length=45, nullable=true)
     */
    private $tel2Contact;

    /**
     * @var string $faxContact
     *
     * @ORM\Column(name="fax_contact", type="string", length=45, nullable=true)
     */
    private $faxContact;

    /**
     * @var string $mailContact
     * @Assert\Email(checkMX=false, message="Veuillez saisir une adresse valide")
     * @ORM\Column(name="mail_contact", type="string", length=45, nullable=true)
     */
    private $mailContact;

    /**
     * @var string $statusContact
     * 
     * @ORM\Column(name="status_contact", type="string", length=245, nullable=true)
     */
    private $statusContact;
    
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
     * Set nomContact
     *
     * @param string $nomContact
     */
    public function setNomContact($nomContact)
    {
        $this->nomContact = $nomContact;
    }

    /**
     * Get nomContact
     *
     * @return string 
     */
    public function getNomContact()
    {
        return $this->nomContact;
    }

    /**
     * Set prenomContact
     *
     * @param string $prenomContact
     */
    public function setPrenomContact($prenomContact)
    {
        $this->prenomContact = $prenomContact;
    }

    /**
     * Get prenomContact
     *
     * @return string 
     */
    public function getPrenomContact()
    {
        return $this->prenomContact;
    }

    /**
     * Set tel1Contact
     *
     * @param string $tel1Contact
     */
    public function setTel1Contact($tel1Contact)
    {
        $this->tel1Contact = $tel1Contact;
    }

    /**
     * Get tel1Contact
     *
     * @return string 
     */
    public function getTel1Contact()
    {
        return $this->tel1Contact;
    }

    /**
     * Set tel2Contact
     *
     * @param string $tel2Contact
     */
    public function setTel2Contact($tel2Contact)
    {
        $this->tel2Contact = $tel2Contact;
    }

    /**
     * Get tel2Contact
     *
     * @return string 
     */
    public function getTel2Contact()
    {
        return $this->tel2Contact;
    }

    /**
     * Set faxContact
     *
     * @param string $faxContact
     */
    public function setFaxContact($faxContact)
    {
        $this->faxContact = $faxContact;
    }

    /**
     * Get faxContact
     *
     * @return string 
     */
    public function getFaxContact()
    {
        return $this->faxContact;
    }

    /**
     * Set mailContact
     *
     * @param string $mailContact
     */
    public function setMailContact($mailContact)
    {
        $this->mailContact = $mailContact;
    }

    /**
     * Get mailContact
     *
     * @return string 
     */
    public function getMailContact()
    {
        return $this->mailContact;
    }

    /**
     * Set statusContact
     *
     * @param string $statusContact
     */
    public function setStatusContact($statusContact)
    {
        $this->statusContact = $statusContact;
    }

    /**
     * Get statusContact
     *
     * @return string 
     */
    public function getStatusContact()
    {
        return $this->statusContact;
    }
    
    /**
     * @ORM\ManyToMany(targetEntity="Partenaire", mappedBy="contacts", cascade={"persist"})
     */
    
    private $partenaires;
    
    /**
     * @ORM\OneToMany(targetEntity="GestionPartenariat", mappedBy="contact")
     */
    protected $gestion_partenariats;
    
    public function __construct()
    {
        $this->partenaires = new \Doctrine\Common\Collections\ArrayCollection();
        $this->gestion_partenariats = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add partenaires
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenaires
     */
    public function addPartenaire(\Acme\FmpsBundle\Entity\Partenaire $partenaires)
    {
        $this->partenaires[] = $partenaires;
    }

    /**
     * Get partenaires
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartenaires()
    {
        return $this->partenaires;
    }

    /**
     * Add gestion_partenariats
     *
     * @param Acme\FmpsBundle\Entity\GestionPartenariat $gestionPartenariats
     */
    public function addGestionPartenariat(\Acme\FmpsBundle\Entity\GestionPartenariat $gestionPartenariats)
    {
        $this->gestion_partenariats[] = $gestionPartenariats;
    }

    /**
     * Get gestion_partenariats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGestionPartenariats()
    {
       return $this->gestion_partenariats;
    }

		public function getFullName()
    {
       return ucfirst($this->getPrenomContact()) . ' ' . strtoupper($this->getNomContact());
    }
    

    public function __toString()
    {
        return $this->getFullName();
    }
}