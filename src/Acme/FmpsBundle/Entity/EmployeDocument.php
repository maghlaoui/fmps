<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\EmployeDocument
 *
 * @ORM\Table(name="employe_document")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class EmployeDocument
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
     * @var integer $typedocumentId
     *
     * @ORM\Column(name="type_document_id", type="integer", nullable=false)
     */
    private $typedocumentId;

    /**
     * @var string $titre
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string $fichier
     * @Assert\NotBlank
     * @Assert\File(maxSize="2000000")
     * @ORM\Column(name="fichier", type="string", length=255, nullable=false)
     */
    private $fichier;

    /**
     * @var string $path
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
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
     * Set titre
     *
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
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
        return 'uploads/employes_documents';
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

		 /**
     * @ORM\ManyToOne(targetEntity="Employe", inversedBy="documents")
     * @ORM\JoinColumn(name="employe_id", referencedColumnName="id")
     */
    protected $employe;

     /**
     * @ORM\ManyToOne(targetEntity="TypeDocument", inversedBy="documents")
     * @ORM\JoinColumn(name="type_document_id", referencedColumnName="id")
     */
    protected $type_document;

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

}