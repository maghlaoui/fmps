<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Acme\FmpsBundle\Entity\Rubrique
 *
 * @ORM\Table(name="rubrique")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\RubriqueRepository")
 * @UniqueEntity("intitule")
 * @ORM\HasLifecycleCallbacks()
 */
class Rubrique
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
     * @var string $intitule
     * @ORM\Column(name="intitule", type="string", length=125, nullable=true)
     */
    private $intitule;

    /**
     * @var smallint $chapitre
     * @Assert\NotBlank
     * @ORM\Column(name="chapitre", type="smallint", nullable=false)
     */
    private $chapitre;

    /**
     * @var integer $article
     * @Assert\NotBlank
     * @ORM\Column(name="article", type="integer", nullable=false)
     */
    private $article;

    /**
     * @var integer $paragraphe
     * @Assert\NotBlank
     * @ORM\Column(name="paragraphe", type="integer", nullable=false)
     */
    private $paragraphe;
    
     /**
     * @var boolean $ammortissable
     * @ORM\Column(name="ammortissable", type="boolean", nullable=true)
     */
    private $ammortissable;
    
     /**
     * @var integer $dureeAmmortissement
     * @ORM\Column(name="duree_ammortissement", type="integer", nullable=true)
     */
    private $dureeAmmortissement;

    
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
     * Set intitule
     *
     * @param string $intitule
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set chapitre
     *
     * @param smallint $chapitre
     */
    public function setChapitre($chapitre)
    {
        $this->chapitre = $chapitre;
    }

    /**
     * Get chapitre
     *
     * @return smallint 
     */
    public function getChapitre()
    {
        return $this->chapitre;
    }

    /**
     * Set article
     *
     * @param integer $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * Get article
     *
     * @return integer 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set paragraphe
     *
     * @param integer $paragraphe
     */
    public function setParagraphe($paragraphe)
    {
        $this->paragraphe = $paragraphe;
    }

    /**
     * Get paragraphe
     *
     * @return integer 
     */
    public function getParagraphe()
    {
        return $this->paragraphe;
    }
    
    /**
     * Set ammortissable
     *
     * @param boolean $ammortissable
     */
    public function setAmmortissable($ammortissable)
    {
        $this->ammortissable = $ammortissable;
    }

    /**
     * Get ammortissable
     *
     * @return boolean 
     */
    public function getAmmortissable()
    {
        return $this->ammortissable;
    }
    
    /**
     * Get ammortissable_str
     *
     * @return string 
     */
    public function getAmmortissableStr()
    {
        return $this->ammortissable == 1 ? 'oui' : 'non';
    }
    
    /**
     * Set dureeAmmortissement
     *
     * @param integer $dureeAmmortissement
     */
    public function setDureeAmmortissement($dureeAmmortissement)
    {
        $this->dureeAmmortissement = $dureeAmmortissement;
    }

    /**
     * Get dureeAmmortissement
     *
     * @return integer 
     */
    public function getDureeAmmortissement()
    {
        return $this->dureeAmmortissement;
    }
    
    public function __toString()
    {
        return $this->intitule;
    }
    
    /**
     * @ORM\OneToMany(targetEntity="BonCommande", mappedBy="rubrique")
     */
    protected $bonCommande;
    
    
}