<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\Attachement
 *
 * @ORM\Table(name="attachement")
 * @ORM\Entity(repositoryClass="Acme\fmpsBundle\Entity\AttachementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Attachement {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $fichier
     *
     * @ORM\Column(name="fichier", type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @var integer $hits
     *
     * @ORM\Column(name="actualite_id", type="integer", nullable=true)
     */
    private $actualite;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set fichier
     *
     * @param string $fichier
     */
    public function setFichier($fichier) {
        $this->fichier = $fichier;
    }

    /**
     * Get fichier
     *
     * @return string 
     */
    public function getFichier() {
        return $this->fichier;
    }

    /**
     * Set actualite
     *
     * @return int
     */
    public function setActualite($actualite) {
        $this->actualite = $actualite;
    }

    /**
     * Get actualite
     *
     * @return int
     */
    public function getActualite() {
        return $this->actualite;
    }

}