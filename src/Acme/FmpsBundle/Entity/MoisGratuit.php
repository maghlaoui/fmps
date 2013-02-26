<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\MoisGratuit
 *
 * @ORM\Table(name="mois_gratuit")
 * @ORM\Entity
 */
class MoisGratuit
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
     * @var integer $offreServiceId
     *
     * @ORM\Column(name="offre_service_id", type="integer", nullable=false)
     */
    private $offreServiceId;

    /**
     * @var string $mois
     *
     * @ORM\Column(name="mois", type="string", length=125, nullable=false)
     */
    private $mois;

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
     * Set offreServiceId
     *
     * @param integer $offreServiceId
     */
    public function setOffreServiceId($offreServiceId)
    {
        $this->offreServiceId = $offreServiceId;
    }

    /**
     * Get offreServiceId
     *
     * @return integer 
     */
    public function getOffreServiceId()
    {
        return $this->offreServiceId;
    }

    /**
     * Set mois
     *
     * @param string $mois
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }

    /**
     * Get mois
     *
     * @return string 
     */
    public function getMois()
    {
        return $this->mois;
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
}