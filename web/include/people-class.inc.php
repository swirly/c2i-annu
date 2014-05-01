<?php

require_once('/etc/c2i-annu/config.php');
require_once('include/ldap.inc.php');
require_once('include/pays.inc.php');

function cmpTri($a,$b){
    return strcmp($a["name"], $b["name"]);
}

class people {

  public $title; // M. Mme Mlle ou Herr Doktor :)
  public $name;
  public $firstname;
  public $mail;
  public $birth; // On utilise le champs description du LDAP carLicense
  public $phone; 
  public $uid;
  public $ine;
  public $section;
  public $pwdhash;
  public $pwdclear;
  public $photo;
  public $rne; // correspond au LDAP departmentNumber
  public $type; // correspond au LDAP employetype : sadmin, admin, teacher, pupil
  public $cn;
  public $localisation; // lieu de naissance
  public $nationalite;  // nationalite pour les eleves
  // Si il y a un argument unique, le constructeur considère que c'est l'UID 
  // et lit les valeurs dans le LDAP
  // Si l'arugument  est un tableau, il l'utilise pour remplir
  // Sinon, il retourne une instance vide
  
  function __construct() {
    if (func_num_args() == 1 ) { 	
      if (is_array(func_get_arg(0))) {
	$people = func_get_arg(0);
	$this->title=$people['title'];
	$new_name=str_replace("'","",$people['name']);
	$new_name=str_replace("- ","",$new_name);
	$new_name=str_replace(" ","",$new_name);
	$this->name=$new_name;
	$new_firstname=str_replace("'","",$people['firstname']);
	$new_firstname=str_replace("-","",$new_firstname);
	$new_firstname=str_replace(" ","",$new_firstname);
	$this->firstname=$new_firstname;
	$this->mail=$people['mail'];
	$this->birth=$people['birth'];
	$this->phone=$people['phone'];
	$this->uid=$people['uid'];
	$this->ine=$people['ine'];
	$this->section=$people['section'];
	$this->pwdhash=$people['pwdhash'];
	$this->photo=$people['photo'];
	$this->rne=$people['rne'];
	$this->type=$people['type'];
	$this->localisation=$people['localisation'];
  $this->nationalite=$people['nationalite'];
      }
      else{
	$this->read_from_ldap(func_get_arg(0));
      }
    }
  }

  function add_to_group($group) {
    global $c2i_ldap;
    global $ldap_res;

    if (!$this->is_member($group)) {    
      $ldap_dn="cn=$group,".$c2i_ldap['groups_dn'];
      $ldap_people['member']="uid=".$this->uid.",".$c2i_ldap['people_dn'];
      ldap_mod_add($ldap_res,$ldap_dn,$ldap_people);  
    }
  }

  function del_from_group($group) {
    global $c2i_ldap;
    global $ldap_res;
    
    if ($this->is_member($group)) {    
      $ldap_dn="cn=$group,".$c2i_ldap['groups_dn'];
      $ldap_people['member']="uid=".$this->uid.",".$c2i_ldap['people_dn'];
      ldap_mod_del($ldap_res,$ldap_dn,$ldap_people);  
    }    
  }

  
  // initialisation du mot de passe et stockage en variable de 
  // session pour l'impression de la feuille des mots de passe.

  function initiate_password() {
        
    $this->pwdclear=substr(`openssl rand -base64 12 | tr -d '/'`,0,8);
    $this->set_password($this->pwdclear);
        
  }

  function set_password($clear_password) {
    global $c2i_ldap;
    global $ldap_res;
    
    if ($this->uid_is_in_ldap()) {
	$password=$userpassword = "{SHA}" . base64_encode( pack('H*', sha1( $clear_password)));
      $attribut['userPassword']=$password;
      $search_dn=$c2i_ldap['people_dn'];
      $filter="(uid=".$this->uid.")";
      $dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
      $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
      $info=ldap_get_entries($ldap_res,$ldap_search_result);
      if (isset($info['0']['userpassword'])) {
	//password exists
	ldap_mod_replace($ldap_res,$dn,$attribut);
      } 
      else {
	ldap_mod_add($ldap_res,$dn,$attribut);
      }      
    }
  }

  function assign_attrib_from_ldap($ldap_entry,$ldap_attrib,$attrib) {
    if (is_array($ldap_entry[$ldap_attrib])) {
      $this->$attrib=$ldap_entry[$ldap_attrib]['0'];
    }
  }
  
  function map_to_ldap(&$ldap_admin,$attrib,$ldap_attrib) {
    if ($this->$attrib !='') {
	$ldap_admin[$ldap_attrib]=$this->$attrib;
      }
  }

  function uid_is_in_ldap() {
    global $c2i_ldap;
    global $ldap_res;

    if (!isset($this->uid)) return FALSE;

    $search_dn=$c2i_ldap['people_dn'];
    $filter="(uid=".$this->uid.")";

    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    if ($info['count']>0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  function uid_is_in_user_database() {
    // On recherche des inscrits manuels dans les utilisateurs.
    // Les inscrits dans c2iinscrits ne viennent que du LDAP

    if (!isset($this->uid)) return false;
    if (!isset($c2i_db_host)) return false;

    $dbh = new PDO("mysql:host=$c2i_db_host;dbname=$c2i_db_database", $c2i_db_user, $c2i_db_password); 
    $query = "SELECT * from c2iutilisateurs WHERE login='".$this->uid."' AND auth='manual' ; "; 
    $result = $dbh->query($query);
    if (!$result) return false;
    if ( $result->columnCount != 0 ) {
      return true;
    } else {
      return false;
    }
  }

  function is_in_ldap() {
    // recherche si une personne est dans le  LDAP 
    // à partir de l'INE pour les élèves
    // à partir du couple nom/prenom pour les admins

    global $c2i_ldap; 
    global $ldap_res;

    switch ($this->type) {
    case 'teacher' :
    case 'sadmin' :
    case 'admin' :  
      $search_dn=$c2i_ldap['people_dn'];
      $filter  ="(&(sn=".$this->name.")";
      $filter .="(givenName=".$this->firstname.")";
      $filter .="(ou=".$this->rne."))";
      $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
      $info=ldap_get_entries($ldap_res,$ldap_search_result);
      if ($info['count']>0 ) {     
	return true ;
      }
      else {
	return false;
      }
      break;
    case 'pupil' :  
      if (!isset($this->ine)) return false;
      $search_dn=$c2i_ldap['people_dn'];
      $filter="(employeeNumber=".$this->ine.")";
      $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
      $info=ldap_get_entries($ldap_res,$ldap_search_result);
      if ($info['count']>0 ) {
	return true ;
      }
      else {
	return false ;
      }
      break;
    default : 
      if ($this->uid_is_in_ldap()) {
      return true ;
      } 
      else {
	return false;
      }
      break;
    }
  }



  function synchro_teacher_SQL() {
    global  $c2i_db_host,$c2i_db_database,$c2i_db_user,$c2i_db_password,$c2i_db_etab;
    try {
      $dbh = new PDO("mysql:host=$c2i_db_host;dbname=$c2i_db_database", $c2i_db_user, $c2i_db_password);     
      if ($this->uid_is_in_user_database()) {
	// Au cas où l'enseignant est déjà dans la base C2I, synchronisation
	$query = "UPDATE c2iutilisateurs SET email='".$this->mail."', ";
	$query .= " nom = ' ".$this->name."' ,";
	$query .= " prenom = '".$this->firstname."' ";
	$query .= " WHERE login='".$pupil->uid."';";
	$dbh->query($query);
	print $query."<br>";
	$dbh = null;
      } else {
	// Creation du nouveau professeur directement dans la base
	$query = "INSERT INTO c2iutilisateurs (login,password,nom,prenom,email,est_admin_univ,etablissement,connexion,derniere_connexion,limite_positionnement,auth,numetudiant,ts_datecreation,ts_datemodification,origine,tags) VALUES (";
	$query.="'".$this->uid."',";
	$query.="'".$this->password."',";
	$query.="'".$this->name."',";
	$query.="'".$this->firstname."',";
	$query.="'".$this->mail."',";
	$query.="'N',";
	$query.="".$c2i_db_etab.",";
	$query.="DEFAULT,";
	$query.="DEFAULT,";
	$query.="0,";
	$query.="'ldap',";
	$query.="'',";
	$query.="".date_timestamp_get(date_create()).",";
	$query.="".date_timestamp_get(date_create()).",";
	$query.="'',";
	$query.="'');";
	$statement = $dbh->query($query);
	/*	if ($statement) {
	  print $query."<br>";print "Erreur statement SQL :<br><pre>";print_r($statement->errorInfo());print"</pre><br>";
	} else {
	  print $query."<br>";print "Erreur SQL :<br><pre>";print_r($dbh->errorInfo());print"</pre><br>";
	  } */
	$query="INSERT INTO c2idroits (login,id_profil) VALUES ('".$this->uid."',7);";
	$dbh->query($query);
	$dbh = null;
      }
    } catch (PDOException $e) {
      print "ERREUR de connexion a la base <br>";
    }
  }

  function is_member($group) {
    global $c2i_ldap;
    global $ldap_res;

    $search_dn=$c2i_ldap['groups_dn'];
    $searched_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
    $filter="(&(cn=$group)(member= $searched_dn))";
    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    if ($info['count']>0) {
      return true;
    }
    else {
      return false;
    }
  }
  
  function create_uid() {
      
      $translate_array = array('à'=>'a',
			       'À'=>'A',
			       'ä'=>'a',
			       'Ä'=>'A',
			       'â'=>'a',
			       'Â'=>'A',
			       'é'=>'e',
			       'É'=>'E',
			       'è'=>'e',
			       'È'=>'E',
			       'ê'=>'e',
			       'Ê'=>'E',
			       'ë'=>'e',
			       'Ë'=>'E',
			       'ö'=>'o',
			       'Ö'=>'O',
			       'ô'=>'o',
			       'Ô'=>'O',
			       'ù'=>'u',
			       'Ù'=>'U',
			       'ï'=>'i',
			       'Ï'=>'I',
			       'î'=>'i',
			       'Î'=>'I',
			       'ÿ'=>'y',
			       'Ÿ'=>'Y',
			       'ç'=>'c',
			       'Ç'=>'C',
			       'œ'=>'oe',
			       'Œ'=>'OE',
			       'ñ'=>'n',
			       'Ñ'=>'N');
      
      if ($this->uid=='') {
	  $uid = substr($this->firstname,0,1);
	  $uid .= substr($this->name,0,7);
	  $uid = strtr($uid,$translate_array);
	  $uid = strtolower($uid);
	  $uid = preg_replace("/[^a-z]/","",$uid);
	  $this->uid=$uid;
	  $compteur=1;
	  while ($this->uid_is_in_ldap()|| $this->uid_is_in_user_database()) {
	      $this->uid=$uid.$compteur;
	      $compteur++;
	  }
      }
  }
  
  function recover_from_ine($ine) {
    // used to recover a pupil from INE
    global $c2i_ldap;
    global $ldap_res;
    
    $search_dn=$c2i_ldap['people_dn'];
    $filter="(employeeNumber=".$ine.")";
    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    $this->read_from_ldap($info['0']['uid']['0']);
    
  }
      


  function read_from_ldap ($uid) {
    // le uid peut être donné isolément ou sous la forme de dn LDAP
    global $c2i_ldap;
    global $ldap_res;

    $search_dn=$c2i_ldap['people_dn'];
    $uid=trim($uid);
    $exploded=explode(',',$uid);
    $uid=$exploded['0'];
    $exploded=explode('=',$uid);
    if (isset($exploded['1'])) {
      $uid=$exploded['1'];
    }	
    else {
      $uid=$exploded['0'];
    }
      
    $filter="(uid=$uid)";
    
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);
    
    $peoples=ldap_get_entries($ldap_res,$ldap_search_result);
    
    $people=$peoples['0'];

    $this->uid=$people['uid']['0'];
    $this->name=$people['sn']['0'];
    $this->assign_attrib_from_ldap($people,'givenname','firstname');
    $this->assign_attrib_from_ldap($people,'mail','mail');
    $this->assign_attrib_from_ldap($people,'telephonenumber','phone');
    $this->assign_attrib_from_ldap($people,'title','title');
    $this->assign_attrib_from_ldap($people,'carlicense','birth');
    $this->assign_attrib_from_ldap($people,'departmentnumber','section');
    $this->assign_attrib_from_ldap($people,'userpassword','pwdhash');
    $this->assign_attrib_from_ldap($people,'ou','rne');
    $this->assign_attrib_from_ldap($people,'jpegphoto','photo');
    $this->assign_attrib_from_ldap($people,'employeetype','type');
    $this->assign_attrib_from_ldap($people,'employeenumber','ine');
    $this->assign_attrib_from_ldap($people,'cn','cn');
    $this->assign_attrib_from_ldap($people,'l','localisation');   
    $this->assign_attrib_from_ldap($people,'preferredlanguage','nationalite');   

  }


  function modify_into_ldap() {
      global $c2i_ldap;
      global $ldap_res;
      global $current_year;

      $ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];

      $ldap_entry['objectClass']="inetOrgPerson";
      $ldap_entry['uid']=$this->uid;

      $this->map_to_ldap($ldap_entry,'name','sn');
      $this->map_to_ldap($ldap_entry,'firstname','givenName');
      $this->cn=$this->firstname." ".$this->name;
      $this->map_to_ldap($ldap_entry,'cn','cn');
      $this->map_to_ldap($ldap_entry,'title','title');
      $this->map_to_ldap($ldap_entry,'rne','ou');            
      $this->map_to_ldap($ldap_entry,'mail','mail');            
      $this->map_to_ldap($ldap_entry,'phone','telephoneNumber');            
      
      if ($this->type=="pupil") {
	  $this->map_to_ldap($ldap_entry,'section','departmentNumber');
	  $this->map_to_ldap($ldap_entry,'birth','carLicense');      
	  $this->map_to_ldap($ldap_entry,'localisation','l'); 
    $this->map_to_ldap($ldap_entry,'nationalite','preferredLanguage');      
	  break;
      }

      ldap_modify($ldap_res,$ldap_dn,$ldap_entry);

      if (isset($this->pwdclear)) {
	$this->set_password($this->pwdclear);
      }
	  
  }
  


  function insert_into_ldap() {
    global $c2i_ldap;
    global $ldap_res;
    global $current_year;
    $set_password=false;

    if ($this->is_in_ldap()) {      
      switch ($this->type) {
      case admin :  
	  $ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];

	  $ldap_admin['objectClass']="inetOrgPerson";
	  $ldap_admin['uid']=$this->uid;
 	  
	  $this->map_to_ldap($ldap_admin,'name','sn');
	  $this->map_to_ldap($ldap_admin,'firstname','givenName');
	  $this->cn=$this->firstname." ".$this->name;
	  $this->map_to_ldap($ldap_admin,'cn','cn');
	  $this->map_to_ldap($ldap_admin,'title','title');
	  $this->map_to_ldap($ldap_admin,'rne','ou');            
	  $this->map_to_ldap($ldap_admin,'mail','mail');            
	  $this->map_to_ldap($ldap_admin,'phone','telephonenumber');            
	  
	  ldap_modify($ldap_res,$ldap_dn,$ldap_admin);
	  
	break;
      case pupil :
	// recuperation de l'eleve precedent ...
	$old_pupil=new people;
	$old_pupil->recover_from_ine($this->ine);
	$this->uid=$old_pupil->uid;
	$ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];

	$ldap_admin['objectClass']="inetOrgPerson";
	$ldap_admin['uid']=$this->uid;

	$this->map_to_ldap($ldap_admin,'name','sn');
	$this->map_to_ldap($ldap_admin,'firstname','givenName');
	$this->cn=$this->firstname." ".$this->name;
	$this->map_to_ldap($ldap_admin,'cn','cn');
	$this->map_to_ldap($ldap_admin,'mail','mail');
	$this->map_to_ldap($ldap_admin,'title','title');
	$this->map_to_ldap($ldap_admin,'birth','carLicense');
	$this->map_to_ldap($ldap_admin,'section','departmentNumber');
	$this->map_to_ldap($ldap_admin,'rne','ou');      
	$this->map_to_ldap($ldap_admin,'localisation','l');      
  $this->map_to_ldap($ldap_admin,'nationalite','preferredLanguage');      
  
	ldap_modify($ldap_res,$ldap_dn,$ldap_admin);

	/* strategie : 
	 Un membre de trash est mis de côté.
	 Un membre de pupil est mis dans son groupe s'il n'y est pas.
	 Le mot de passe est alors regenere
	 */

	if (!$this->is_member('trash')) { 
	         	
	  $pupil_section=$current_year."_".$this->rne."_".$this->section;
	  $pupil_old_section=$current_year."_".$old_pupil->rne."_".$old_pupil->section;
	  if ($pupil_section != $pupil_old_section) {
	    $set_password=true;
	    if ($this->is_member($pupil_old_section)) 
	      $this->del_from_group($pupil_old_section);
	  }

	  if (!$this->is_member($pupil_section)) {
	    $set_password=true;
	    $this->add_to_group($pupil_section);
	  }
	
	  if (!$this->is_member('pupils'))
	    $this->add_to_group('pupils');
	}
	
	if ($set_password) $this->initiate_password();

	break;
      }
    } 
    else {
      // This is a new entry
      $this->create_uid();
      $ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
      $ldap_admin['objectClass']="inetOrgPerson";
      $ldap_admin['uid']=$this->uid;
      $this->map_to_ldap($ldap_admin,'type','employeeType');
      $this->map_to_ldap($ldap_admin,'firstname','givenName');
      $this->map_to_ldap($ldap_admin,'title','title');
      $this->map_to_ldap($ldap_admin,'birth','carLicense');
      $this->map_to_ldap($ldap_admin,'section','departmentNumber');
      $this->map_to_ldap($ldap_admin,'rne','ou');
      $this->map_to_ldap($ldap_admin,'mail','mail');
      $this->map_to_ldap($ldap_admin,'phone','telephoneNumber');
      $this->map_to_ldap($ldap_admin,'ine','employeeNumber');
      $this->map_to_ldap($ldap_admin,'name','sn');
      $this->cn=$this->firstname." ".$this->name;
      $this->map_to_ldap($ldap_admin,'cn','cn');
      $this->map_to_ldap($ldap_admin,'localisation','l');
      $this->map_to_ldap($ldap_admin,'nationalite','preferredLanguage');      

      ldap_add($ldap_res,$ldap_dn,$ldap_admin);  
      $this->initiate_password();
      switch ($this->type) {
      case 'sadmin':
	$this->add_to_group('sadmins');
	break;
      case 'admin':
	$this->add_to_group('admins');
	break;
      case 'teacher':
	$this->add_to_group('teachers');
	break;
      case 'pupil':
	$this->add_to_group('pupils');
	$this->add_to_group($current_year."_".$this->rne."_".$this->section);
	break;
      }
      if ($_POST['password']!="") {
	$this->set_password($_POST['password']);
      }
    }
  }
  
  function delete() {
    // delete déplace une personne vers la corbeille
    // mais ne la détruit pas

    global $c2i_ldap;
    global $ldap_res;
    global $current_year;

    if ($this->is_in_ldap()) {
      switch ($this->type) {
      case 'sadmin':	
	$this->del_from_group('sadmins');
	break;
      case 'admin':
	if ($this->is_member('admins')) $this->del_from_group('admins');
	$ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
	ldap_delete($ldap_res,$ldap_dn);
	break;
      case 'teacher':
	if ($this->is_member('teacher')) $this->del_from_group('teachers');
	$ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
	ldap_delete($ldap_res,$ldap_dn);
	break;
      case 'pupil':
	$group = $current_year."_".$this->rne."_".$this->section;
	if ($this->is_member($group)) 	  $this->del_from_group($group);
	if ($this->is_member('pupils'))   $this->del_from_group('pupils');
	$this->add_to_group('trash');
	$this->initiate_password(); // mdp aléatoire pour interdire l'accès
	break;
      }
      
    }

  }

  function destroy(){
      
    global $c2i_ldap;
    global $ldap_res;
    global $current_year;
    
    if ($this->is_in_ldap()) {
      switch ($this->type) {
      case 'sadmin':	
	$this->del_from_group('sadmins');
	break;
      case 'admin':
	if ($this->is_member('admins')) $this->del_from_group('admins');
	$this->delete_from_SQL();
	break;
      case 'teacher':
	if ($this->is_member('teacher')) $this->del_from_group('teachers');
	$this->delete_from_SQL();
	break;
      case 'pupil':
	$group = $current_year."_".$this->rne."_".$this->section;
	if ($this->is_member($group)) 	  $this->del_from_group($group);
	if ($this->is_member('pupils'))   $this->del_from_group('pupils');
	if ($this->is_member('trash')) $this->del_from_group('trash');
	break;
      }
      
      $ldap_dn="uid=".$this->uid.",".$c2i_ldap['people_dn'];
	ldap_delete($ldap_res,$ldap_dn);
	
    }
    
  }

  function delete_from_SQL() {
    global $smarty;
    global  $c2i_db_host,$c2i_db_database,$c2i_db_user,$c2i_db_password,$c2i_db_etab;
    try {
      $dbh = new PDO("mysql:host=$c2i_db_host;dbname=$c2i_db_database", $c2i_db_user, $c2i_db_password);     
      $query = "DELETE FROM c2idroits where login='".$this->uid."'; ";
      $dbh->query($query);
      $query = "DELETE FROM c2iutilisateurs where login='".$this->uid."'; ";
      $dbh->query($query);
      $dbh=null;
    } catch (PDOException $err) {
      $smarty->error('Erreur à la connexion à la base SQL');
    }
    
    
  }

  static function read_teachers($rne='') {
    global $c2i_ldap,$ldap_res;
    
    $search_dn=$c2i_ldap['groups_dn'];
    $filter="(cn=teachers)";

    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);

    $info=ldap_get_entries($ldap_res,$ldap_search_result);

    $members=array();

    $number_members=$info['0']['member']['count'];
    for ($i=0; $i<$number_members; $i++){
      
      $uid= $info['0']['member'][$i];
      $member = new people($uid);
      if ($member->uid_is_in_ldap()) {
	$member = (array) $member;
	$params=array('uid'=>$uid);
	$member['edit_link']=menu_link('list','admin','modify_teacher',$params);
	$member['delete_link']=menu_link('list','admin','delete_teacher_confirm',$params);
	$member['reset_pwd_link']=menu_link('list','admin','reset_teacher_password',$params);
	if ($rne == '' || $rne == $member['rne']) {
	  array_push($members,$member);
	}
      }
    }            
    return $members;  
  }
}

function ldap_read_admins() {
  global $smarty,$ldap_res,$c2i_ldap;

  $admins=array();

  $search_dn=$c2i_ldap['groups_dn'];
  $filter="(cn=admins)";

  $ldap_search_result=@ldap_list($ldap_res,$search_dn,$filter);

  if ($ldap_search_result) {

    $info=ldap_get_entries($ldap_res,$ldap_search_result);

    $number_admins=$info['0']['member']['count'];
    for ($i=0; $i<$number_admins; $i++){
    
      $uid= $info['0']['member'][$i];
      $admin = new people($uid);
      if ($admin->uid_is_in_ldap()) {
	$admin = (array) $admin;
	$params=array('uid'=>$uid);
	$admin['edit_link']=menu_link('adminslist','admins','edit',$params);
	$admin['delete_link']=menu_link('adminslist','admins','confirm_delete',$params);
	$admin['reset_pwd_link']=menu_link('adminslist','admins','reset_admin_pwd',$params);
	array_push($admins,$admin);
      }
    }
  } else {
    $smarty->error('recherche dans le DN des groupes impossible. L\'annuaire est il bien initialisé ?');
  }
  
  return $admins;  
}

function ldap_read_pupils($section='') {
  global $c2i_ldap;
  global $ldap_res;
  global $current_year;  

  $rne=$_SESSION['user']->rne;

  $search_dn=$c2i_ldap['people_dn'];
  if ($section!='') {
    $filter="(&(employeeType=pupil)(ou=$rne)(departmentNumber=$section))" ;
  } else {
    if ($rne !='-1') {
      $filter="(&(employeeType=pupil)(ou=$rne))" ;
    } else {
      $filter="(employeeType=pupil)" ;
    }          
  }

  $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);

  $info=ldap_get_entries($ldap_res,$ldap_search_result);

  $pupils=array();
  $trashed=array();

  $pupils_number=$info['count'];

  for ($count=0; $count<$pupils_number;$count++) {
    $uid= $info[$count]['uid']['0'];
    $pupil = new people($uid);

    if ($pupil->is_member('pupils')) {
      $pupil = (array) $pupil;
      $params=array('uid'=>$uid);
      if ($_SESSION['user']->type=='teacher') {
	$pupil['reset_pwd_link']=menu_link('pupilslist','teacher','reset_pupil_password',$params);
      } else {
	$pupil['reset_pwd_link']=menu_link('pupilslist','admin','reset_pupil_pwd',$params);
	$pupil['edit_link']=menu_link('pupilslist','admin','edit_pupil',$params);
	$pupil['delete_link']=menu_link('pupilslist','admin','confirm_delete_pupil',$params);
      }
      array_push($pupils,$pupil);

    } elseif ($pupil->is_member('trash')) {
      $pupil = (array) $pupil;
      $params=array('uid'=>$uid);
      $pupil['reload_link']=menu_link('trashlist','admin','reload_pupil',$params);     
      array_push($trashed,$pupil);
      
    }

    //Classement alphabetique

    usort($pupils,"cmpTri");
    usort($trashed,"cmpTri");
     
    $all_pupils['pupils']=$pupils;
    $all_pupils['trashed']=$trashed;
   
  }
  return $all_pupils;  

}

function ldap_trash_from_list($file) {
    global $c2i_ldap;
    global $ldap_res;

    //Ouverture du fichier et création de la liste des ine
    $handle=@fopen($file,"r");
    if ($handle) {
	while (!feof($handle)) {
	    $ine=trim(fgets($handle));
	    $array_ine[$ine]="1";
	}
	fclose($handle);
    } else {
	return -1;
    }

    // Recuperation de l'ensemble des eleves
    $filter="(cn=pupils)";
    $search_dn=$c2i_ldap['groups_dn'];
    
    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    
    //Parcours de la liste des eleves
  
    $number_pupils=$info['0']['member']['count'];
    for ($i=0; $i<$number_pupils; $i++){
	
	$uid= $info['0']['member'][$i];
	$pupil = new people($uid);
	if ($pupil->uid_is_in_ldap()) {
	    $ine=trim($pupil->ine);
	    if ($array_ine[$ine]!="1") {
		//deplacement vers trash de ceux qui ne sont pas dans la liste
		print "suppression de l'eleve ".$pupil->cn." d'ine ".$pupil->ine."<br>";
		$pupil->delete();
	    } else {
		print "<b> OK </b> pour l'eleve ".$pupil->cn." d'ine ".$pupil->ine."<br>";
	    }
	}
    }
    return 0;
}

function ldap_recover_lost_ine_list($file) {
    global $c2i_ldap;
    global $ldap_res;
    $array_file_ine=array();
    $array_error_ine=array();
    $array_ok_ine=array();
    $array_lost_ine=array();

    //Ouverture du fichier et création de la liste des ine
    $handle=@fopen($file,"r");
    if ($handle) {
	while (!feof($handle)) {
	    $ine=trim(fgets($handle));
	    if ($ine!="") {
		array_push($array_file_ine,$ine);
	    }
	}
	fclose($handle);
    } else {
	return -1;
    }

    // Recuperation de l'ensemble des eleves

    foreach ($array_file_ine as $ine) {
	$filter="(&(employeeType=pupil)(employeeNumber=$ine))";
	$search_dn=$c2i_ldap['people_dn'];
	
	$ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
	
	$info=ldap_get_entries($ldap_res,$ldap_search_result);

	//Parcours de la liste des eleves
	if ($info['count']=='1') {	   
	    $uid= $info['0']['uid']['0'];
	    $pupil = new people($uid);
	    if($pupil->is_member('pupils')) {
		array_push($array_ok_ine,$pupil); 
	    } else {
		array_push($array_lost_ine,$pupil);
	    }	   
	}else {
	    array_push($array_error_ine,$pupil);
	}
    }

    $_SESSION['file_ine_list']=$array_file_ine;
    $_SESSION['error_ine_list']=$array_error_ine;
    $_SESSION['ok_ine_list']=$array_ok_ine;
    $_SESSION['lost_ine_list']=$array_lost_ine;
    
    return 0;
}


?>