<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Acme\FmpsBundle\Util\SlugNormalizer;

/**
 * Acme\FmpsBundle\Entity\TypeDocument
 *
 * @ORM\Table(name="type_document")
 * @ORM\Entity
 * @UniqueEntity("libelleTypedocument")
 * @ORM\HasLifecycleCallbacks()
 */
class TypeDocument
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
     * @var string $libelleTypedocument
     * @Assert\NotBlank
     * @Assert\MinLength(2)
     * @ORM\Column(name="libelle_type_document", type="string", length=225, nullable=false, unique=true)
     */
    private $libelleTypedocument;

    /**
     * @var string $racineTypedocument
     *
     * @ORM\Column(name="racine_type_document", type="string", length=245, nullable=true)
     */
    private $racineTypedocument;
    
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
      $this->setLibelleTypedocument(ucfirst(strtolower($this->getLibelleTypedocument())));
      //$SlugNormalizer = new SlugNormalizer('fds 4342 dfds');
      //echo $SlugNormalizer->normalize();exit;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
      $this->setUpdatedAt(new \DateTime());
			$this->setLibelleTypedocument(ucfirst(strtolower($this->getLibelleTypedocument())));
    }

    /**
     * Set libelleTypedocument
     *
     * @param string $libelleTypedocument
     */
    public function setLibelleTypedocument($libelleTypedocument)
    {
        $this->libelleTypedocument = $libelleTypedocument;
    }

    /**
     * Get libelleTypedocument
     *
     * @return string 
     */
    public function getLibelleTypedocument()
    {
        return $this->libelleTypedocument;
    }

    /**
     * Set racineTypedocument
     *
     * @param string $racineTypedocument
     */
    public function setRacineTypedocument($racineTypedocument)
    {
        $this->racineTypedocument = $racineTypedocument;
    }

    /**
     * Get racineTypedocument
     *
     * @return string 
     */
    public function getRacineTypedocument()
    {
        return $this->racineTypedocument;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Document", mappedBy="type_document")
     */
    protected $documents;
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add documents
     *
     * @param Acme\FmpsBundle\Entity\Document $documents
     */
    public function addDocument(\Acme\FmpsBundle\Entity\Document $documents)
    {
        $this->documents[] = $documents;
    }

    /**
     * Get documents
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getDocuments()
    {
        return $this->documents;
    }
    
    public function __toString()
    {
        return $this->libelleTypedocument;
    }
}