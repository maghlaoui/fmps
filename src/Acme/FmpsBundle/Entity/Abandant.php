<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\Abandant
 *
 * @ORM\Table(name="abandant")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Abandant
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
     * @var integer $inscriptionId
     *
     * @ORM\Column(name="inscription_id", type="integer", nullable=false)
     */
    private $inscriptionId;

    /**
     * @var string $motifSortie
     *
     * @ORM\Column(name="motif_sortie", type="string", length=255, nullable=false)
     */
    private $motifSortie;

    /**
     * @var string $commentaire
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=false)
     */
    private $commentaire;

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
     * Set inscriptionId
     *
     * @param integer $inscriptionId
     */
    public function setInscriptionId($inscriptionId)
    {
        $this->inscriptionId = $inscriptionId;
    }

    /**
     * Get inscriptionId
     *
     * @return integer 
     */
    public function getInscriptionId()
    {
        return $this->inscriptionId;
    }

    /**
     * Set motifSortie
     *
     * @param string $motifSortie
     */
    public function setMotifSortie($motifSortie)
    {
        $this->motifSortie = $motifSortie;
    }

    /**
     * Get motifSortie
     *
     * @return string 
     */
    public function getMotifSortie()
    {
        return $this->motifSortie;
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
}