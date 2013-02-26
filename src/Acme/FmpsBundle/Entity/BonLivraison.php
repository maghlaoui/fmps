<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\BonLivraison
 *
 * @ORM\Table(name="bon_livraison")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\BonLivraisonRepository")
 * @ORM\HasLifecycleCallbacks
 */
class BonLivraison
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
     * @var integer $bonCommandeId
     *
     * @ORM\Column(name="bon_commande_id", type="integer", nullable=false)
     */
    private $bonCommandeId;

    /**
     * @var string $fichier
     * @Assert\NotBlank
     * @Assert\File(maxSize="2000000")
     * @ORM\Column(name="fichier", type="string", length=45, nullable=true)
     */
    private $fichier;
    
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
     * Set bonCommandeId
     *
     * @param integer $bonCommandeId
     */
    public function setBonCommandeId($bonCommandeId)
    {
        $this->bonCommandeId = $bonCommandeId;
    }

    /**
     * Get bonCommandeId
     *
     * @return integer 
     */
    public function getBonCommandeId()
    {
        return $this->bonCommandeId;
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
     * @ORM\ManyToOne(targetEntity="BonCommande", inversedBy="bons_livraison")
     * @ORM\JoinColumn(name="bon_commande_id", referencedColumnName="id")
     */
    protected $bonCommande;
    

    /**
     * Set bonCommande
     *
     * @param Acme\FmpsBundle\Entity\BonCommande $bonCommande
     */
    public function setBonCommande(\Acme\FmpsBundle\Entity\BonCommande $bonCommande)
    {
        $this->bonCommande = $bonCommande;
    }

    /**
     * Get bonCommande
     *
     * @return Acme\FmpsBundle\Entity\BonCommande 
     */
    public function getBonCommande()
    {
        return $this->bonCommande;
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
        return 'uploads/'.$this->getBonCommande()->getFolderName();
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'bon_livraison_'.uniqid().'.'.$this->fichier->guessExtension();
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
}