<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\ContactPartenaire
 *
 * @ORM\Table(name="contact_partenaire")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class ContactPartenaire
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
     * @var integer $partenaireId
     *
     * @ORM\Column(name="partenaire_id", type="integer", nullable=false)
     */
    private $partenaireId;

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
     * Set partenaireId
     *
     * @param integer $partenaireId
     */
    public function setPartenaireId($partenaireId)
    {
        $this->partenaireId = $partenaireId;
    }

    /**
     * Get partenaireId
     *
     * @return integer 
     */
    public function getPartenaireId()
    {
        return $this->partenaireId;
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
     * @ORM\ManyToOne(targetEntity="Partenaire", inversedBy="partenaires")
     * @ORM\JoinColumn(name="partenaire_id", referencedColumnName="id")
     */
    protected $partenaire;

		/**
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="contacts")
     * @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     */
    protected $contact;

    /**
     * Set partenaire
     *
     * @param Acme\FmpsBundle\Entity\Partenaire $partenaire
     */
    public function setPartenaire(\Acme\FmpsBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire = $partenaire;
    }

   /**
     * Get partenaire
     *
     * @return Acme\FmpsBundle\Entity\Partenaire 
     */
    public function getPartenaire()
    {
        return $this->partenaire;
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