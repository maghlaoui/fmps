<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\DocumentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Document
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
     * @var integer $typedocumentId
     *
     * @ORM\Column(name="type_document_id", type="integer", nullable=false)
     */
    private $typedocumentId;

    /**
     * @var string $fichier
     * @Assert\NotBlank
     * @Assert\File(maxSize="2000000")
     * @ORM\Column(name="fichier", type="string", length=125, nullable=true)
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
     * Set typedocumentId
     *
     * @param integer $typedocumentId
     */
    public function setTypedocumentId($typedocumentId)
    {
        $this->typedocumentId = $typedocumentId;
    }

    /**
     * Get typedocumentId
     *
     * @return integer 
     */
    public function getTypedocumentId()
    {
        return $this->typedocumentId;
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
     * @ORM\ManyToOne(targetEntity="Partenariat", inversedBy="documents")
     * @ORM\JoinColumn(name="partenariat_id", referencedColumnName="id")
     */
    protected $partenariat;
    
     /**
     * @ORM\ManyToOne(targetEntity="TypeDocument", inversedBy="documents")
     * @ORM\JoinColumn(name="type_document_id", referencedColumnName="id")
     */
    protected $type_document;

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
     * Set type_document
     *
     * @param Acme\FmpsBundle\Entity\TypeDocument $typeDocument
     */
    public function setTypeDocument(\Acme\FmpsBundle\Entity\TypeDocument $typeDocument)
    {
        $this->type_document = $typeDocument;
    }

    /**
     * Get type_document
     *
     * @return Acme\FmpsBundle\Entity\TypeDocument 
     */
    public function getTypeDocument()
    {
        return $this->type_document;
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
        return 'uploads/partenariats/documents';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->fichier) {
            $this->path = 'document_'.uniqid().'.'.$this->fichier->guessExtension();
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