<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\Actualite
 * @ORM\Table(name="actualite")
 * @ORM\Entity(repositoryClass="Acme\fmpsBundle\Entity\ActualiteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Actualite
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
     * @var integer $userId
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var text $title
     * @Assert\NotBlank
     * @Assert\MinLength(6)
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    private $title;

    /**
     * @var text $content
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var boolean $published
     *
     * @ORM\Column(name="published", type="boolean", nullable=false)
     */
    private $published;

    /**
     * @var text $roles
     *
     * @ORM\Column(name="roles", type="text", nullable=false)
     */
    private $roles;

    /**
     * @var integer $hits
     *
     * @ORM\Column(name="hits", type="integer", nullable=true)
     */
    private $hits;

    /**
     * @var datetime $rubriqueId
     *
     * @ORM\Column(name="rubrique_id", type="integer", nullable=false)
     */
    private $rubriqueId;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var ActualiteRubrique
     *
     * @ORM\ManyToOne(targetEntity="ActualiteRubrique")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rubrique_id", referencedColumnName="id")
     * })
     */
    private $rubrique;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


 
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
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     */
    public function setPublished($published)
    {
        $this->published = $published;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set roles
     *
     * @param text $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Get roles
     *
     * @return text 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set hits
     *
     * @param integer $hits
     */
    public function setHits($hits)
    {
        $this->hits = $hits;
    }

    /**
     * Get hits
     *
     * @return integer 
     */
    public function getHits()
    {
        return $this->hits;
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
     * Set rubrique
     *
     * @param Acme\FmpsBundle\Entity\ActualiteRubrique $rubrique
     */
    public function setRubrique(\Acme\FmpsBundle\Entity\ActualiteRubrique $rubrique)
    {
        $this->rubrique = $rubrique;
    }

    /**
     * Get rubrique
     *
     * @return Acme\FmpsBundle\Entity\ActualiteRubrique 
     */
    public function getRubrique()
    {
        return $this->rubrique;
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

    public function __toString()
    {
        return $this->title;
    }

    public function query($id,$em){
   
// execute SQL query, receive Doctrine_Connection_Statement
        $st = $em->createQuery("SELECT a.id as aid,a.content,r.id as rid,a.title as actualite,r.title as rubrique FROM AcmeFmpsBundle:Actualite a ,AcmeFmpsBundle:ActualiteRubrique r    where r.id=a.rubrique and r.id =".$id."order by r.createdAt DESC ");
// fetch query result
       
        return $st;
    }

    public function queryAll($em){
        $st = $em->createQuery("SELECT a.id as aid,a.content,r.id as rid,a.title as actualite,r.title as rubrique FROM AcmeFmpsBundle:Actualite a ,AcmeFmpsBundle:ActualiteRubrique r    where r.id=a.rubrique order by r.createdAt,r.id ASC  ");
// fetch query result
       
        return $st;
    }
    public function findLastId($em){
        $st = $em->createQuery("SELECT max(a.id) as id from AcmeFmpsBundle:Actualite a ");
// fetch query result
       
        return $st;
    }
    
}