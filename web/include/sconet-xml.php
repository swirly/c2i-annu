<?php

function process_sconet_xml ($file) {

  // Un truc étonnant... le fichier est en ISO8859-15
  // Mais simplexml me donne de l'UTF-8 direct...
  // ça m'arrange, mais c'est perturbant...
  
  $XML = simplexml_load_file($file);
  foreach ($XML->DONNEES->ELEVES->children() as $child) {
    $id=(string) $child['ELEVE_ID'];

    // On ne sélectionne que les élèves avec un INE

    if ((string) $child->ID_NATIONAL!='') {
      $eleves[$id]['ine']= (string) $child->ID_NATIONAL;
      $sexe = (string) $child->CODE_SEXE;
      if ($sexe==1) {
	$eleves[$id]['title']= "M.";
      }
      else {
	$eleves[$id]['title']= "Mlle";
      }
      $eleves[$id]['name']= trim ((string) $child->NOM);
      $eleves[$id]['firstname']= trim((string) $child->PRENOM);
      $eleves[$id]['birth']= trim((string) $child->DATE_NAISS);  
      $eleves[$id]['localisation']= trim((string) $child->CODE_COMMUNE_INSEE_NAISS);
      $eleves[$id]['rne']= trim((string) $XML->PARAMETRES->UAJ); 
      $eleves[$id]['type']="pupil";
    }
  }
  
  // On rajoute les sections d'appartenance aux élèves

  foreach ($XML->DONNEES->STRUCTURES->children() as $child) {
    $id=(string) $child['ELEVE_ID'];
    if (isset($eleves[$id])) {
	foreach ($child->children() as $structure) {
	    if (trim((string) $structure->TYPE_STRUCTURE)=="D" ){
		    $eleves[$id]['section']= trim((string) $structure->CODE_STRUCTURE);
		}
	}
    }
  }

  // On supprime les élèves sans classe (anciens élèves)

  foreach ($eleves as $index => $eleve) {
    if ($eleve['section']=='') {
      unset($eleves[$index]);
    } 
  }

  return ($eleves);
}
?>
