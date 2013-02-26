<?php

namespace Acme\FmpsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acme\FmpsBundle\Entity\SituationCaisse
 *
 * @ORM\Table(name="situation_caisse")
 * @ORM\Entity(repositoryClass="Acme\FmpsBundle\Entity\SituationCaisseRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SituationCaisse {

  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var integer $ecoleId
   *
   * @ORM\Column(name="ecole_id", type="integer", nullable=false)
   */
  private $ecoleId;

  /**
   * @var string $mois
   *
   * @ORM\Column(name="mois", type="string", length=125, nullable=false)
   */
  private $mois;

  /**
   * @var string $annee
   *
   * @ORM\Column(name="annee", type="string", length=125, nullable=false)
   */
  private $annee;

  /**
   * @var float $soldeInitiale
   *
   * @ORM\Column(name="solde_initiale", type="float", nullable=false)
   */
  private $soldeInitiale;

  /**
   * @var float $totalAlimentation
   *
   * @ORM\Column(name="total_alimentation", type="float", nullable=false)
   */
  private $totalAlimentation;

  /**
   * @var float $totalAchat
   *
   * @ORM\Column(name="total_achat", type="float", nullable=false)
   */
  private $totalAchat;

  /**
   * @var float $soldeFinale
   *
   * @ORM\Column(name="solde_finale", type="float", nullable=false)
   */
  private $soldeFinale;

  /**
   * @var boolean $cloture
   *
   * @ORM\Column(name="cloture", type="boolean", nullable=true)
   */
  private $cloture;

  /**
   * @var string $fichier
   *
   * @ORM\Column(name="fichier", type="string", length=125, nullable=true)
   */
  private $fichier;

  /**
   * @var string $path
   *
   * @ORM\Column(name="path", type="string", length=125, nullable=true)
   */
  private $path;

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
  public function getId() {
    return $this->id;
  }

  /**
   * Set ecoleId
   *
   * @param integer $ecoleId
   */
  public function setEcoleId($ecoleId) {
    $this->ecoleId = $ecoleId;
  }

  /**
   * Get ecoleId
   *
   * @return integer 
   */
  public function getEcoleId() {
    return $this->ecoleId;
  }

  /**
   * Set mois
   *
   * @param string $mois
   */
  public function setMois($mois) {
    $this->mois = $mois;
  }

  /**
   * Get mois
   *
   * @return string 
   */
  public function getMois() {
    return $this->mois;
  }

  /**
   * Set annee
   *
   * @param string $annee
   */
  public function setAnnee($annee) {
    $this->annee = $annee;
  }

  /**
   * Get annee
   *
   * @return string 
   */
  public function getAnnee() {
    return $this->annee;
  }

  /**
   * Set soldeInitiale
   *
   * @param float $soldeInitiale
   */
  public function setSoldeInitiale($soldeInitiale) {
    $this->soldeInitiale = $soldeInitiale;
  }

  /**
   * Get soldeInitiale
   *
   * @return float 
   */
  public function getSoldeInitiale() {
    return $this->soldeInitiale;
  }

  /**
   * Set totalAlimentation	
   *
   * @param float $totalAlimentation
   */
  public function setTotalAlimentation($totalAlimentation) {
    $this->totalAlimentation = $totalAlimentation;
  }

  /**
   * Get totalAlimentation
   *
   * @return float 
   */
  public function getTotalAlimentation() {
    return $this->totalAlimentation;
  }

  /**
   * Set totalAchat	
   *
   * @param float $totalAchat
   */
  public function setTotalAchat($totalAchat) {
    $this->totalAchat = $totalAchat;
  }

  /**
   * Get totalAchat
   *
   * @return float 
   */
  public function getTotalAchat() {
    return $this->totalAchat;
  }

  /**
   * Set soldeFinale	
   *
   * @param float $soldeFinale
   */
  public function setSoldeFinale($soldeFinale) {
    $this->soldeFinale = $soldeFinale;
  }

  /**
   * Get soldeFinale
   *
   * @return float 
   */
  public function getSoldeFinale() {
    return $this->soldeFinale;
  }

  /**
   * Set cloture
   *
   * @param boolean $cloture
   */
  public function setCloture($cloture) {
    $this->cloture = $cloture;
  }

  /**
   * Get cloture
   *
   * @return boolean 
   */
  public function getCloture() {
    return $this->cloture;
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
   * Set path
   *
   * @param string $path
   */
  public function setPath($path) {
    $this->path = $path;
  }

  /**
   * Get path
   *
   * @return string 
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Set createdAt
   *
   * @param datetime $createdAt
   */
  public function setCreatedAt($createdAt) {
    $this->createdAt = $createdAt;
  }

  /**
   * Get createdAt
   *
   * @return datetime
   */
  public function getCreatedAt() {
    return $this->createdAt;
  }

  /**
   * Set updatedAt
   *
   * @param datetime $updatedAt
   */
  public function setUpdatedAt($updatedAt) {
    $this->updatedAt = $updatedAt;
  }

  /**
   * Get updatedAt
   *
   * @return datetime
   */
  public function getUpdatedAt() {
    return $this->updatedAt;
  }

  public function getAbsolutePath() {
    return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
  }

  public function getWebPath() {
    return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
  }

  protected function getUploadRootDir() {
    return __DIR__ . '/../../../../web/' . $this->getUploadDir();
  }

  protected function getUploadDir() {
    return 'uploads/situation_caisse';
  }

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload() {
    if (null !== $this->fichier) {
      $this->path = 'situation_caisse_' . uniqid() . '.' . $this->fichier->guessExtension();
    }
  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload() {
    if (null === $this->fichier) {
      return;
    }

    $this->fichier->move($this->getUploadRootDir(), $this->path);
    unset($this->fichier);
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload() {
    $fichier = $this->getAbsolutePath();
    if (file_exists($fichier))
      unlink($fichier);
  }

  /**
   * @ORM\PrePersist
   */
  public function prePersist() {
    $this->setCreatedAt(new \DateTime());
    $this->setUpdatedAt(new \DateTime());
  }

  /**
   * @ORM\PreUpdate
   */
  public function preUpdate() {
    $this->setUpdatedAt(new \DateTime());
  }

  /**
   * @ORM\ManyToOne(targetEntity="Ecole")
   * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
   */
  protected $ecole;

  /**
   * Set ecole
   *
   * @param Acme\FmpsBundle\Entity\Ecole $ecole
   */
  public function setEcole(\Acme\FmpsBundle\Entity\Ecole $ecole) {
    $this->ecole = $ecole;
  }

  /**
   * Get ecole
   *
   * @return Acme\FmpsBundle\Entity\Ecole 
   */
  public function getEcole() {
    return $this->ecole;
  }

  public function queryDecharge($em, $ecoleId, $mois, $annee) {

    $stDecharge = $em->createQuery("SELECT sum(d.montant) as montantDecharge FROM AcmeFmpsBundle:Decharge d  where d.datePaiement<>0 and SUBSTRING(d.date, 6, 2)=" . $mois . " and SUBSTRING(d.date, 1, 4)=" . $annee . " and d.ecoleId=" . $ecoleId);

// fetch query result
    return $stDecharge;
  }
    public function queryDechargeAll($em, $ecoleId, $mois, $annee) {

    $stDecharge = $em->createQuery("SELECT d FROM AcmeFmpsBundle:Decharge d  where d.datePaiement<>0 and SUBSTRING(d.date, 6, 2)=" . $mois . " and SUBSTRING(d.date, 1, 4)=" . $annee . " and d.ecoleId=" . $ecoleId);

// fetch query result
    return $stDecharge;
  }

  public function queryEauElectricite($em, $ecoleId, $mois, $annee) {

    $stEauElectricite = $em->createQuery("SELECT  sum(e.montant) as montantEau FROM AcmeFmpsBundle:EauElectricite e  where e.datepaiement<>0 and SUBSTRING(e.datefacture, 6, 2)=" . $mois . " and SUBSTRING(e.datefacture, 1, 4)=" . $annee . " and e.ecoleId=" . $ecoleId);
    return $stEauElectricite;
  }
   public function queryEauElectriciteAll($em, $ecoleId, $mois, $annee) {

    $stEauElectricite = $em->createQuery("SELECT  e FROM AcmeFmpsBundle:EauElectricite e  where e.datepaiement<>0 and SUBSTRING(e.datefacture, 6, 2)=" . $mois . " and SUBSTRING(e.datefacture, 1, 4)=" . $annee . " and e.ecoleId=" . $ecoleId);
    return $stEauElectricite;
  }

  public function queryFacture($em, $ecoleId, $mois, $annee) {

    $st_facture = $em->createQuery("SELECT  sum(f.montant) as montantFacture  FROM AcmeFmpsBundle:EcoleAchat f  where f.datePaiementFacture<>0 and SUBSTRING(f.date, 6, 2)=" . $mois . " and SUBSTRING(f.date, 1, 4)=" . $annee . " and f.ecoleId=" . $ecoleId);
    return $st_facture;
  }

  public function queryFactureAll($em, $ecoleId, $mois, $annee) {

    $st_facture = $em->createQuery("SELECT  f  FROM AcmeFmpsBundle:EcoleAchat f  where f.datePaiementFacture<>0 and SUBSTRING(f.date, 6, 2)=" . $mois . " and SUBSTRING(f.date, 1, 4)=" . $annee . " and f.ecoleId=" . $ecoleId);
    return $st_facture;
  }

  public function queryAlimentationAll($em, $ecoleId, $mois, $annee) {

    $st_Alimentation = $em->createQuery("SELECT  a FROM AcmeFmpsBundle:Alimentation a  where a.date<>0 and SUBSTRING(a.date, 6, 2)=" . $mois . " and SUBSTRING(a.date, 1, 4)=" . $annee . " and  a.reception=1 and a.ecoleId=" . $ecoleId);
    return $st_Alimentation;
  }

  public function queryBon($em, $ecoleId, $mois, $annee) {

    $st_bon = $em->createQuery("SELECT  sum(b.montant) as montantBon FROM AcmeFmpsBundle:Bon b  where b.datePaiement<>0 and SUBSTRING(b.date, 6, 2)=" . $mois . " and SUBSTRING(b.date, 1, 4)=" . $annee . " and b.ecoleId=" . $ecoleId);
    return $st_bon;
  }
    public function queryBonAll($em, $ecoleId, $mois, $annee) {

    $st_bon = $em->createQuery("SELECT  b FROM AcmeFmpsBundle:Bon b  where b.datePaiement<>0 and SUBSTRING(b.date, 6, 2)=" . $mois . " and SUBSTRING(b.date, 1, 4)=" . $annee . " and b.ecoleId=" . $ecoleId);
    return $st_bon;
  }

  public function queryAlimentation($em, $ecoleId, $mois, $annee) {

    $st_Alimentation = $em->createQuery("SELECT  sum(a.montant) as montantAlimentation FROM AcmeFmpsBundle:Alimentation a  where a.date<>0 and SUBSTRING(a.date, 6, 2)=" . $mois . " and SUBSTRING(a.date, 1, 4)=" . $annee . " and  a.ecoleId=" . $ecoleId);
    return $st_Alimentation;
  }

  public function queryCallLastCloture($em, $ecoleId) {

    $st_cloture = $em->createQuery("SELECT  c as derniereLigne FROM AcmeFmpsBundle:SituationCaisse c  
            where  c.ecoleId=" . $ecoleId);
    return $st_cloture;
  }

  public function querymoisapres($moisId) {
    $c = '';
    $i = 0;
    $tab = array(01 => 'janvier', 02 => 'fevrier', 03 => 'mars', 04 => 'avril', 05 => 'mai', 06 => 'juin', 07 => 'juillet', 08 => 'aout', 09 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre');
    foreach ($tab as $index => $libelle) {
      if ($libelle == $moisId ) {
        $i = $index;
        if ($i == 12) {
          $i = 1;
        } else {
          $i++;
        }
        return array($i, $tab[$i]);
      }
      
    }
      foreach ($tab as $index => $libelle) {
      if ($index == $moisId ) {
        $i = $index;
     
          $i--;
        
        return array($i, $tab[$i]);
      }
      
    }
  }

}