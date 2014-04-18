<?php
require_once('include/ldap.inc.php');
require_once('include/school-class.inc.php');

function sadmin_welcome_schools() {
  global $smarty;

  $smarty->assign('header_title','&Eacute;tablissement');

  $smarty->display('schools.tpl');
}

function sadmin_create_school() {
  global $smarty;

  $smarty->assign('header_title','Cr&eacute;ation &eacute;tablissement');
  
  $school=array('rne'=>'');

  sadmin_school($school);

  exit;
}

function sadmin_modify_school ($rne) {
  global $smarty;
  
  $smarty->assign('header_title','Modification &eacute;tablissement');

  $school = new school($rne);

  sadmin_school((array) $school);

  exit;
}

function sadmin_school($school) {

  global $smarty;
  
  $smarty->assign('school',$school);

  $smarty->display('create_school.tpl');

  exit;
}

function sadmin_confirm_delete_school ($rne) {
  global $smarty;
  
  $smarty->assign('header_title','Suppression &eacute;tablissement?');

  $school = new school($rne);
  
  $smarty->assign('school',(array) $school);

  $params=array('rne'=>$rne);

  $smarty->assign('delete_link',menu_link('confirmform','schools','delete',$params));
  $smarty->assign('cancel_link',menu_link('confirmform','schools','list_schools'));
  
  $smarty->display('confirm_delete_school.tpl');

  exit;
}

function sadmin_delete_school ($RNE) {

  ldap_delete_school($RNE);

  sadmin_list_schools($school);

  exit;
}


function sadmin_list_schools($dept='acad') {
  global $smarty;

  $schools=ldap_read_schools();

  $smarty->assign('header_title','Liste des &eacute;tablissements');
  
  $smarty->assign('schools',$schools);

  $smarty->assign('create_link',menu_link('schoolslist','schools','create_school'));

  $smarty->display('list_schools.tpl');

}

function sadmin_process_school($school) {
 
  ldap_insert_school($school);

  sadmin_list_schools();

  exit;
}

function sadmin_import_schools($msg="") {

  global $smarty;

  $smarty->assign('header_title','Importation des &eacute;tablissements');
  $smarty->error($msg);
  $smarty->display('import_schools.tpl');

  exit;
}

function sadmin_schools_process_import () {
  
  $valid=true;

  $file = $_FILES['schools_import_file']['tmp_name'];

  if (!is_uploaded_file($file)) {
    $valid=false;
    $error="Probl&egrave;me dans le chargement du fichier";
  }
  
  if ($valid == true && filesize($file)==0){
    $valid=false;
    $error="Votre fichier est vide!";
  }

  if ($valid==true) {
    $handle=fopen($file,'r');
    if ($handle) {
      $header_line=trim(fgets($handle));
      // Analyse de l'entête
      $header_array=explode(";",$header_line);
      foreach($header_array as $key=>$value) {
        $element=trim($value);
	if ($element!="") {
	  $column[$element]=$key;	
	}
      }
      if (!isset($column['RNE'])) {
	$error .= "Colonne RNE non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['type'])) {
	$error .= "Colonne type non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['nom'])) {
	$error .= "Colonne nom non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['adresse'])) {
	$error .= "Colonne adresse non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['codepostal'])) {
	$error .= "Colonne codepostal non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['ville'])) {
	$error .= "Colonne ville non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['telephone'])) {
	$error .= "Colonne telephone non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['BP'])) {
	$error .= "Colonne BP non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['fax'])) {
	$error .= "Colonne fax non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['mail'])) {
	$error .= "Colonne mail non d&eacute;finie<br>";
	$valid=false;}
      if ($valid == true) {      
	while (!feof($handle)) {	
	  $buffer = trim(fgets($handle));
	  $line = explode(";",$buffer);
	  if (count($line)>8) {
	    $school['rne']=trim($line[$column['RNE']]);
	    $school['type']=trim($line[$column['type']]);
	    $school['name']=trim($line[$column['nom']]);
	    $school['address']=trim($line[$column['adresse']]);
	    $school['postalcode']=trim($line[$column['codepostal']]);
	    $school['city']=trim($line[$column['ville']]);
	    $school['phone']=trim($line[$column['telephone']]);
	    $school['pob']=trim($line[$column['BP']]);
	    $school['fax']=trim($line[$column['fax']]);
	    $school['mail']=trim($line[$column['mail']]);
	    $school_object = new school($school);
	    $school_object->insert_into_ldap();	  
	  }
	}
      }
      fclose($handle);
    } 
  }
  else {
    $valid=false;
    $error="Lecture du fichier $file impossible sur le serveur";
  }
    
   // Analyse du fichier
  
  if ($valid == false) {
    sadmin_import_schools($error);
    exit;
  } 
  else {    
    sadmin_list_schools();
    exit;
  } 
}

?>