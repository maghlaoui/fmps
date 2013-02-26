<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FirstConnection {
    
      public function query($id,$em){
   
// execute SQL query, receive Doctrine_Connection_Statement
        $st = $em->createQuery("SELECT  FROM AcmeFmpsBundle:Affection a ,AcmeFmpsBundle:Ecole e    where a.ecole_id=e.id and a.employe_id =".$id);
// fetch query result
       
        return $st;
    }
    
}
?>
