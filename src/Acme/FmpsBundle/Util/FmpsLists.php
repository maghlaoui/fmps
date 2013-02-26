<?php

namespace Acme\FmpsBundle\Util;


class FmpsLists {
	
    public static function getMonths()
    {   
	    return array('Septembre' => 'Septembre', 'Octobre' => 'Octobre', 'Novembre' => 'Novembre', 'Décembre' => 'Décembre', 'Janvier' => 'Janvier', 'Février' => 'Février', 'Mars' => 'Mars', 'Avril' => 'Avril', 'Mai' => 'Mai', 'Juin' => 'Juin');
	  }
     
    public static function tva(){
        return array(20 => 20, 14 => 14, 10 => 10, 7 => 7, 0 => 0);
    }

		public static function months(){
        return array(1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 
										 5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Aout', 
										 9 => 'Novembre', 10 => 'Octobre', 11 => 'Septembre', 12 => 'Décembre');
    }
    
    public static function getRolesList()
	  {
        return array(
           'ROLE_DG' => 'Directeur général',
					 'ROLE_DRH' => 'Direction Ressources Humaines',
					 'ROLE_RH' => 'Ressources Humaines',
					 'ROLE_FORMATION' => 'Formation',
					 'ROLE_DIRECTEUR' => 'Directeur d\'école',
					 'ROLE_SECRETARIAT' => 'Secrétariat et assistance de direction',
					 'ROLE_DC' => 'Direction Comptabilité',
					 'ROLE_COMPTABILITE' => 'Comptabilité',
					 'ROLE_SUPER_ADMIN' => 'Direction Service Informatique',
					 'ROLE_SI' => 'Utilisateur',
					 'ROLE_ETUDE' => 'Service  Etude',
					 'ROLE_DAL' => 'Direction Service Achat et logistique',
					 'ROLE_AL' => 'Service Achat et logistique',
					 'ROLE_PATRIMOINE' => 'Service Patrimoine',
					 'ROLE_COM' => 'Service Communication et Marketing');
	  }

	  public static function getDefaultYears(){
		  return array(2013 => 2013, 2012 => 2012, 2011 => 2011, 2010 => 2010, 2009 => 2009, 2008 => 2008);
	  }
	
	  public static function getDefaultGenders(){
      return array(0 => 'Masculin', 1 => 'Féminin');
    }

		public static function getDefaultPaymentTypes(){
      return array('Espèce' => 'Espèce', 'Chèque' => 'Chèque', 'Virement' => 'Virement');
    }

		public static function getDefaultOrderStatus()
	  {
		    return array(
           'engagé' => 'Engagé',
					 'payé'   => 'Payé',
           'annulé' => 'Annulé'
           );
	  }
	
		public static function getDefaultMotifs()
	  {
		    return array(
           'Maternité' => 'Maternité',
					 'Maladie'   => 'Maladie',
					 'Mariage'   => 'Mariage',
					 'Affaire Personnelle'   => 'Affaire Personnelle',
					 'Décès'   => 'Décès',
					 'Naissance'   => 'Naissance',
					 'Mise à pied' => 'Mise à pied',
           'Autre' => 'Autre'
           );
	  }
	
		public static function getDefaultLanguages()
	  {
		    return array(
           '1' => 'Arabe',
					 '2'   => 'Français',
           '3' => 'Arabe et Français'
           );
	  }
	
		public static function getDefaultOffreStatus()
	  {
		    return array( 'non compté', 'impayé', 'gratuit', 'payé' );
	  }
	
		//0 n'existe pas dans la période
		//1 enfant n'a pas encore payé 
		//2 mois gratuit
		//3 payé
	

}