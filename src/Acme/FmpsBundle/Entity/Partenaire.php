<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Partenaire
 *
 * @ORM\Table(name="partenaire")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\PartenaireRepository")
 * @UniqueEntity("nomPartenaire")
 * @ORM\HasLifecycleCallbacks()
 */
class Partenaire
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
     * @var string $nomPartenaire
     *
     * @ORM\Column(name="nom_partenaire", type="string", length=125, nullable=false, unique=true)
     */
    private $nomPartenaire;

    /**
     * @var text $adressePartenaire
     *
     * @ORM\Column(name="adresse_partenaire", type="text", nullable=true)
     */
    private $adressePartenaire;

    /**
     * @var string $tel1Partenaire
     *
     * @ORM\Column(name="tel1_partenaire", type="string", length=25, nullable=true)
     */
    private $tel1Partenaire;

    /**
     * @var string $tel2Partenaire
     *
     * @ORM\Column(name="tel2_partenaire", type="string", length=25, nullable=true)
     */
    private $tel2Partenaire;

    /**
     * @var string $faxPartenaire
     *
     * @ORM\Column(name="fax_partenaire", type="string", length=25, nullable=true)
     */
    private $faxPartenaire;

    /**
     * @var string $mailPartenaire
     *
     * @ORM\Column(name="mail_partenaire", type="string", length=45, nullable=true)
     */
    private $mailPartenaire;

    /**
     * @var string $siteWebPartenaire
     *
     * @ORM\Column(name="site_web_partenaire", type="string", length=225, nullable=true)
     */
    private $siteWebPartenaire;

    /**
     * @var integer $villeId
     *
     * @ORM\Column(name="ville_id", type="integer", nullable=false)
     */
    private $villeId;
    
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
     * Set nomPartenaire
     *
     * @param string $nomPartenaire
     */
    public function setNomPartenaire($nomPartenaire)
    {
        $this->nomPartenaire = $nomPartenaire;
    }

    /**
     * Get nomPartenaire
     *
     * @return string 
     */
    public function getNomPartenaire()
    {
        return $this->nomPartenaire;
    }

    /**
     * Set adressePartenaire
     *
     * @param text $adressePartenaire
     */
    public function setAdressePartenaire($adressePartenaire)
    {
        $this->adressePartenaire = $adressePartenaire;
    }

    /**
     * Get adressePartenaire
     *
     * @return text 
     */
    public function getAdressePartenaire()
    {
        return $this->adressePartenaire;
    }

    /**
     * Set tel1Partenaire
     *
     * @param string $tel1Partenaire
     */
    public function setTel1Partenaire($tel1Partenaire)
    {
        $this->tel1Partenaire = $tel1Partenaire;
    }

    /**
     * Get tel1Partenaire
     *
     * @return string 
     */
    public function getTel1Partenaire()
    {
        return $this->tel1Partenaire;
    }

    /**
     * Set tel2Partenaire
     *
     * @param string $tel2Partenaire
     */
    public function setTel2Partenaire($tel2Partenaire)
    {
        $this->tel2Partenaire = $tel2Partenaire;
    }

    /**
     * Get tel2Partenaire
     *
     * @return string 
     */
    public function getTel2Partenaire()
    {
        return $this->tel2Partenaire;
    }

    /**
     * Set faxPartenaire
     *
     * @param string $faxPartenaire
     */
    public function setFaxPartenaire($faxPartenaire)
    {
        $this->faxPartenaire = $faxPartenaire;
    }

    /**
     * Get faxPartenaire
     *
     * @return string 
     */
    public function getFaxPartenaire()
    {
        return $this->faxPartenaire;
    }

    /**
     * Set mailPartenaire
     *
     * @param string $mailPartenaire
     */
    public function setMailPartenaire($mailPartenaire)
    {
        $this->mailPartenaire = $mailPartenaire;
    }

    /**
     * Get mailPartenaire
     *
     * @return string 
     */
    public function getMailPartenaire()
    {
        return $this->mailPartenaire;
    }

    /**
     * Set siteWebPartenaire
     *
     * @param string $siteWebPartenaire
     */
    public function setSiteWebPartenaire($siteWebPartenaire)
    {
        $this->siteWebPartenaire = $siteWebPartenaire;
    }

    /**
     * Get siteWebPartenaire
     *
     * @return string 
     */
    public function getSiteWebPartenaire()
    {
        return $this->siteWebPartenaire;
    }

    /**
     * Set villeId
     *
     * @param integer $villeId
     */
    public function setVilleId($villeId)
    {
        $this->villeId = $villeId;
    }

    /**
     * Get villeId
     *
     * @return integer 
     */
    public function getVilleId()
    {
        return $this->villeId;
    }
    
    /**
     * @ORM\ManyToMany(targetEntity="Contact", inversedBy="partenaires", cascade={"persist"})
     * @ORM\JoinTable(name="contact_partenaire",
     * joinColumns={@ORM\JoinColumn(name="partenaire_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")}
     * )
     */
    
    private $contacts;
    
    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="partenaires")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id")
     */
    protected $ville;
    
    /**
     * @ORM\ManyToMany(targetEntity="Partenariat", inversedBy="partenaires", cascade={"persist"})
     * @ORM\JoinTable(name="partenariat_partenaire",
     * joinColumns={@ORM\JoinColumn(name="partenaire_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="partenariat_id", referencedColumnName="id")}
     * )
     */
    private $partenariats;
    
    /**
     * @ORM\OneToMany(targetEntity="PartenariatPartenaire", mappedBy="partenaire")
     */
    protected $partenariats_partenaires;
    
    public function __construct()
    {
        $this->contacts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->partenariats = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add contact
     *
     * @param Acme\FmpsBundle\Entity\Contact $contact
     */
    public function addContact(\Acme\FmpsBundle\Entity\Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * Get contacts
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Set ville
     *
     * @param Acme\FmpsBundle\Entity\Ville $ville
     */
    public function setVille(\Acme\FmpsBundle\Entity\Ville $ville)
    {
        $this->ville = $ville;
    }

    /**
     * Get ville
     *
     * @return Acme\FmpsBundle\Entity\Ville 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add partenariat
     *
     * @param Acme\FmpsBundle\Entity\Partenariat $partenariat
     */
    public function addPartenariat(\Acme\FmpsBundle\Entity\Partenariat $partenariat)
    {
        $this->partenariats[] = $partenariat;
    }

    /**
     * Get partenariats
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPartenariats()
    {
        return $this->partenariats;
    }
    
    public function __toString()
    {
        return $this->nomPartenaire;
    }
}