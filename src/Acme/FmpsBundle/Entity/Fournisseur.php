<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Fournisseur
 *
 * @ORM\Table(name="fournisseur")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\FournisseurRepository")
 * @UniqueEntity("nom")
 * @ORM\HasLifecycleCallbacks
 */
class Fournisseur
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
     * @var string $nom
     * @Assert\NotBlank
     * @ORM\Column(name="nom", type="string", length=255, nullable=false, unique=true)
     */
    private $nom;

    /**
     * @var text $adresse
     *
     * @ORM\Column(name="adresse", type="text", nullable=true)
     */
    private $adresse;

    /**
     * @var string $telephone
     *
     * @ORM\Column(name="telephone", type="string", length=125, nullable=true)
     */
    private $telephone;

    /**
     * @var string $fax
     *
     * @ORM\Column(name="fax", type="string", length=125, nullable=true)
     */
    private $fax;

    /**
     * @var string $registreCommerce
     *
     * @ORM\Column(name="registre_commerce", type="string", length=125, nullable=true)
     */
    private $registreCommerce;

    /**
     * @var string $numeroPatente
     *
     * @ORM\Column(name="numero_patente", type="string", length=125, nullable=true)
     */
    private $numeroPatente;

    /**
     * @var string $identifiantFiscale
     *
     * @ORM\Column(name="identifiant_fiscale", type="string", length=125, nullable=true)
     */
    private $identifiantFiscale;

    /**
     * @var string $numeroRib
     *
     * @ORM\Column(name="numero_rib", type="string", length=125, nullable=true)
     */
    private $numeroRib;

    /**
     * @var string $banque
     *
     * @ORM\Column(name="banque", type="string", length=125, nullable=true)
     */
    private $banque;

    /**
     * @var string $attestationRib
     * @ORM\Column(name="attestation_rib", type="string", length=125, nullable=true)
     */
    private $attestationRib;
    
    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    private $path;

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
     * Set nom
     *
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set adresse
     *
     * @param text $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * Get adresse
     *
     * @return text 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set registreCommerce
     *
     * @param string $registreCommerce
     */
    public function setRegistreCommerce($registreCommerce)
    {
        $this->registreCommerce = $registreCommerce;
    }

    /**
     * Get registreCommerce
     *
     * @return string 
     */
    public function getRegistreCommerce()
    {
        return $this->registreCommerce;
    }

    /**
     * Set numeroPatente
     *
     * @param string $numeroPatente
     */
    public function setNumeroPatente($numeroPatente)
    {
        $this->numeroPatente = $numeroPatente;
    }

    /**
     * Get numeroPatente
     *
     * @return string 
     */
    public function getNumeroPatente()
    {
        return $this->numeroPatente;
    }

    /**
     * Set identifiantFiscale
     *
     * @param string $identifiantFiscale
     */
    public function setIdentifiantFiscale($identifiantFiscale)
    {
        $this->identifiantFiscale = $identifiantFiscale;
    }

    /**
     * Get identifiantFiscale
     *
     * @return string 
     */
    public function getIdentifiantFiscale()
    {
        return $this->identifiantFiscale;
    }

    /**
     * Set numeroRib
     *
     * @param string $numeroRib
     */
    public function setNumeroRib($numeroRib)
    {
        $this->numeroRib = $numeroRib;
    }

    /**
     * Get numeroRib
     *
     * @return string 
     */
    public function getNumeroRib()
    {
        return $this->numeroRib;
    }

    /**
     * Set banque
     *
     * @param string $banque
     */
    public function setBanque($banque)
    {
        $this->banque = $banque;
    }

    /**
     * Get banque
     *
     * @return string 
     */
    public function getBanque()
    {
        return $this->banque;
    }

    /**
     * Set attestationRib
     *
     * @param string $attestationRib
     */
    public function setAttestationRib($attestationRib)
    {
        $this->attestationRib = $attestationRib;
    }

    /**
     * Get attestationRib
     *
     * @return string 
     */
    public function getAttestationRib()
    {
        return $this->attestationRib;
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
    
    public function __toString()
    {
        return $this->nom;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="BonCommande", mappedBy="fournisseur")
     * @ORM\OrderBy({"nom" = "ASC"})
     */
    protected $bonCommande;
    
    
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
        return 'uploads/attestation_rib';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->attestationRib) {
            $this->path = 'attestation_rib_'.uniqid().'.'.$this->attestationRib->guessExtension();
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->attestationRib) {
            return;
        }

        $this->attestationRib->move($this->getUploadRootDir(), $this->path);
        unset($this->attestationRib);
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fichier = $this->getAbsolutePath();
        if ( file_exists($fichier)) unlink($fichier);
    }
}