<?php
require_once('ldap.inc.php');
require_once('people-class.inc.php');

function sadmin_create_admin() {
  global $smarty;

  $smarty->assign('header_title','Cr&eacute;ation d\'un administrateur');
  
  $admin=array('uid'=>'');

  sadmin_admin($admin);

  exit;
}

function sadmin_modify_admin ($uid) {
  global $smarty;
  
  $smarty->assign('header_title','Modification d\'un administrateur');

  $admin = new people($uid);

  sadmin_admin((array) $admin);

  exit;
}

function sadmin_admin($admin) {

  global $smarty;
  
  $smarty->assign('admin',$admin);

  $smarty->display('create_admin.tpl');

  exit;
}


function sadmin_admin_process() {
  
  global $smarty;

  try {
    $admin = new people($_POST);
    
    if ($_POST['password']!="") {
      if ($_POST['password'] != $_POST['passverif']) {
	throw (new C2iException('passwords_dont_match'));
      } else {
	$admin->pwdclear=$_POST['password']; 
      }
    }

    if ($_POST['uid']!="") {
      $admin->modify_into_ldap();
    } else {
      $admin->insert_into_ldap();
    }
    sadmin_list_admins();
  } catch (C2iException $exception) {
    $smarty->error($exception->getMessage()."<br><i>".$exception->getDetails()."</i>");    
    sadmin_admin($_POST);
  }
}

function sadmin_confirm_delete_admin ($uid) {
  global $smarty;
  
  $smarty->assign('header_title','Suppression d\'un administrateur?');

  $admin = new people($uid);
  
  $smarty->assign('admin',(array) $admin);

  $params=array('uid'=>$uid);

  $smarty->assign('delete_link',menu_link('confirmform','admins','delete',$params));
  $smarty->assign('cancel_link',menu_link('confirmform','admins','list_admins'));
  
  $smarty->display('confirm_delete_admin.tpl');

  exit;
}

function sadmin_delete_admin ($uid) {

  $people = new people($uid);
  $people->destroy();
  sadmin_list_admins();

  exit;
}


function sadmin_reset_admin_pwd($uid) {
  global $smarty;

  $admin = new people($uid);
  $valid=true;
  
  
  if ($admin->type!='admin') {
    $error .= "l'identifiant ".$admin->uid;
    $error .= " ne correspond pas &agrave; un administrateur local";
    $errot .= "<br>";
    $valid=false;
  }
  
  if ($valid) {
   $admin->initiate_password();
  }

  $admins[$admin->uid]=(array) $admin;

  $smarty->assign('header_title','Réinitialisation du mot de passe');  
  if ($error != '') $smarty->error($error);
  $smarty->assign('admins',$admins);
  $smarty->display('sadmin_reset_admin_password.tpl');

}

function sadmin_reset_all_admins_pwd() {
  global $smarty;

  $admins_list = ldap_read_admins();
  
  foreach ($admins_list as $member) {
    $admin=new people($member['uid']);

    $valid=true;
 
    if ($admin->type!='admin') {
      $error .= "l'identifiant ".$admin->uid;
      $error .= " ne correspond pas &agrave; un administrateur";
      $errot .= "<br>";
      $valid=false;
    }
    
    if ($valid) {
      $admin->initiate_password();
      $admin->initiate_password();
      $admins[$admin->uid]=(array) $admin;
    }
  }
  
  $smarty->assign('header_title','Réinitialisation du mot de passe');
  $smarty->assign('admins',$admins);
  $smarty->display('sadmin_reset_admin_password.tpl');
  
}



function sadmin_list_admins($dept='acad') {
  global $smarty;

  $admins=ldap_read_admins();

  $smarty->assign('header_title','Liste des administrateurs');
  
  $smarty->assign('admins',$admins);

  $smarty->assign('create_link',menu_link('adminslist','admins','create_admin'));

  $smarty->assign('password_link',menu_link('adminslist','admins','reset_all_admins_pwd'));

  $smarty->display('list_admins.tpl');

}

function sadmin_process_admin($school) {
 
  ldap_insert_admin($school);

  sadmin_list_admins();

  exit;
}

function sadmin_admins_import($msg="") {

  global $smarty;

  $smarty->assign('header_title','Importation des &eacute;tablissements');
  $smarty->assign('error_message',$msg);
  $smarty->display('sadmin_import_admins.tpl');

  exit;
}

function sadmin_admins_process_import () {

  global $smarty;
  
  $admins=array();

  $valid=true;

  $file = $_FILES['admins_import_file']['tmp_name'];

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
      if (!isset($column['NOM'])) {
	$error .= "Colonne NOM non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['PRENOM'])) {
	$error .= "Colonne PRENOM non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['MAIL'])) {
	$error .= "Colonne MAIL non d&eacute;finie<br>";
	$valid=false;}
      if (!isset($column['SEXE'])) {
	$error .= "Colonne SEXE non d&eacute;finie<br>";
	$valid=false;}
      if ($valid == true) {      
	while (!feof($handle)) {	
	  $buffer = trim(fgets($handle));
	  $line = explode(";",$buffer);
	  if (count($line)>4) {
	    $admin['rne']=trim($line[$column['RNE']]);
	    $admin['name']=trim($line[$column['NOM']]);
	    $admin['firstname']=trim($line[$column['PRENOM']]);
	    $admin['mail']=trim($line[$column['MAIL']]);
	    $admin['title']=trim($line[$column['SEXE']]);
	    $admin['type']='admin';
	    array_push($admins,$admin);	    
	  }
	}
      }
      fclose($handle);
      foreach($admins as $new_admin) {
	$admin= new people($new_admin);
	if ($admin->is_in_ldap()) {
	  $error_msg.= $admin->firstname." ".$admin->name." est déjà administrateur de l'établissement ".$admin->rne."<br>\n";  
	}
	else {
	  $admin->insert_into_ldap();
	  $admin->initiate_password();
	  $password_list[$admin->uid]= array( "cn" => $admin->firstname." ".$admin->name,
					      "uid" => $admin->uid,
					      "password" => $admin->pwdclear );
	  $admin->synchro_teacher_SQL();
	}
      }
    } 
  }
  else {
    $valid=false;
    $error="Lecture du fichier $file impossible sur le serveur";
  }
    
   // Analyse du fichier
  
  if ($valid == false) {
    sadmin_admins_import($error);
    exit;
  } 
  else {    
    $smarty->assign('header_title',"Import des administrateurs");
    $smarty->assign('error_message',$error_msg);
    $smarty->assign('password_list',$password_list);
    $smarty->display('sadmin_admins_password_list.tpl');      
  } 
}

function sadmin_ldap_synchronize($msg="") {

  global $smarty;

  $smarty->assign('header_title','Synchronisation de l\'annuaire LDAP');
  $smarty->assign('error_message',$msg);
  $smarty->display('sadmin_ldap_synchronize.tpl');

  exit;
}

function sadmin_process_ldap_synchronize() {

  $file = $_FILES['ine_import_file']['tmp_name'];

  ldap_trash_from_list($file);

  sadmin_welcome();
}

?>