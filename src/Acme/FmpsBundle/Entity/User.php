<?php

namespace Acme\FmpsBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\FmpsBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

     /**
     * @var integer $employeId
     *
     * @ORM\Column(name="employe_id", type="integer", nullable=false)
     */
    private $employeId;

	 /**
	 * @var boolean $firstConnect
	 *
	 * @ORM\Column(name="first_connect", type="boolean", nullable=true)
	 */
	 protected $firstConnect;
    
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
		 * Get firstConnect
		 *
		 * @return boolean 
		 */
		 public function getFirstConnect()
		 {
		   return $this->firstConnect;
		 }

		 /**
		  * Set firstConnect
		  *
		  * @param boolean $firstConnect
		  */
		  public function setFirstconnect($firstConnect)
		  {
		    $this->firstConnect = $firstConnect;
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
    
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\OneToOne(targetEntity="Employe", cascade={"persist", "remove"})
     */
    protected $employe;

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

   public function getEnabled()
	 {
		  return $this->enabled;
	 }
	
	public function getEcoles()
	 {
		  $affectations = $this->getEmploye()->getAffectations();
		  $ids = array();
		  foreach ($affectations as $affectation){
			  $ids[] = $affectation->getEcoleId();
			}
			
			return $ids;
	 }
	
	public function getEmployes($current = true)
	 {
		  $affectations = $this->getEmploye()->getEcole()->getAffectations();
		  $ids = array();
		  foreach ($affectations as $affectation){
			  $ids[] = $affectation->getEmployeId();
			}

			return $ids;
	 }
	
	 public function __toString()
   {
       return $this->getEmploye()->getFullName();
   }

	   public function lookforfirtconnecte($id,$em){

	// execute SQL query, receive Doctrine_Connection_Statement
	        $st = $em->createQuery("SELECT u.firstConnect FROM AcmeFmpsBundle:User u where u.id =".$id);
	// fetch query result

	        return $st;
	    }
	
}