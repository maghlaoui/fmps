<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\EntityManager;

/**
 * Acme\FmpsBundle\Entity\ArticleBonCommande
 *
 * @ORM\Table(name="article_bon_commande")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\ArticleBonCommandeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ArticleBonCommande
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
     * @var integer $articleId
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var integer $bonCommandeId
     *
     * @ORM\Column(name="bon_commande_id", type="integer", nullable=false)
     */
    private $bonCommandeId;

    /**
     * @var decimal $prixUnitaire
     * @Assert\NotBlank
     * 
     * @ORM\Column(name="prix_unitaire", type="decimal", scale="2", nullable=true)
     */
    private $prixUnitaire;

    /**
     * @var float $quantite
     * @Assert\NotBlank
     * 
     * @ORM\Column(name="quantite", type="float", nullable=true)
     */
    private $quantite;

		/**
     * @var string $unite
     * 
     * @ORM\Column(name="unite", type="string", nullable=true)
     */
    private $unite;
    
    /**
     * @var float $tva
     * 
     * @ORM\Column(name="tva", type="float", nullable=true)
     */
    private $tva;

    /**
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

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
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
     * Get articleId
     *
     * @return integer 
     */
    public function getArticleId()
    {
        return $this->articleId;
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
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;
    }

    /**
     * Get prixUnitaire
     *
     * @return float 
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

	/**
     * Get prixUnitaireTtc
     *
     * @return float 
     */
    public function getPrixUnitaireTtc()
    {
        return $this->prixUnitaire*(1+$this->tva/100);
    }

    /**
     * Set quantite
     *
     * @param float $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * Get quantite
     *
     * @return float 
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set unite
     *
     * @param string $unite
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
    }

    /**
     * Get unite
     *
     * @return unite 
     */
    public function getUnite()
    {
        return $this->unite;
    }
    
    /**
     * Set tva
     *
     * @param float $tva
     */
    public function setTva($tva)
    {
        $this->tva = $tva;
    }

    /**
     * Get tva
     *
     * @return float 
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Get totalTva
     *
     * @return float 
     */
    public function getTotalTva()
    {
        return $this->getTotalHt()*($this->tva/100);
    }

    /**
     * Get totalHt
     *
     * @return float 
     */
    public function getTotalHt()
    {
        return $this->getPrixUnitaire()*$this->getQuantite();
    }

    /**
     * Get totalTtc
     *
     * @return float 
     */
    public function getTotalTtc()
    {
        return $this->getTotalHt() + $this->getTotalTva();
    }
    /**
     * Set userId
     *
     * @param integer $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
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
    //, onDelete="cascade"
    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="articles_bons_commande", cascade={"persist"})
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    protected $article;
    
    /**
     * @ORM\ManyToOne(targetEntity="BonCommande", inversedBy="articles_bons_commande")
     * @ORM\JoinColumn(name="bon_commande_id", referencedColumnName="id")
     */
    protected $bonCommande;
    
      /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles_bons_commande")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * Set article
     *
     * @param Acme\FmpsBundle\Entity\Article $article
     */
    public function setArticle(\Acme\FmpsBundle\Entity\Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get article
     *
     * @return Acme\FmpsBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }
    
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
    
    /**
     * Set user
     *
     * @param Acme\FmpsBundle\Entity\User $user
     */
    public function setUser(\Acme\FmpsBundle\Entity\User $user)
    {
        $this->user = $user;
    }

   /**
     * Get user
     *
     * @return Acme\FmpsBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function onPrePersist()
    {
      $this->setPrixUnitaire(str_replace(',', '.', $this->getPrixUnitaire()));
      $this->setQuantite(str_replace(',', '.', $this->getQuantite()));
    }
    
    /**
    * @ORM\PreRemove
    */
    public function onPreRemove()
    {
      $entity = $this->getBonCommande();
      $entity->setMontant($entity->getMontant() - $this->getTotalTtc());
    }

	/**
     * Get ammortissement
     *
     * @return float 
     */
    public function getAmmortissement($duree, $yearsAgo)
    {
        if ($yearsAgo > 0){
	
					return ($duree * 100) / $yearsAgo;
				}
		else {
			
			return 0;
		}
    }

   public function getData()
	 {
		
		return array();

	 }

    
}