<?php

class school {

  public $rne;
  public $type; 
  public $name;
  public $address;
  public $pob;
  public $postalcode;
  public $city;
  public $phone;
  public $fax;
  public $mail;

  // Si il y a un argument, le constructeur considère que c'est le RNE
  // et lit les valeurs dans le LDAP
  // Sinon, il retourne une instance vide

  function __construct () {
    if (func_num_args() == 1 ) {
      if (is_array(func_get_arg(0))) {
	$school = func_get_arg(0);
	$this->rne=$school['rne'];
	$this->type=$school['type'];
	$this->name=$school['name'];
	$this->address=$school['address'];
	$this->pob=$school['pob'];
	$this->postalcode=$school['postalcode'];
	$this->city=$school['city'];
	$this->phone=$school['phone'];
	$this->fax=$school['fax'];
	$this->mail=$school['mail'];
      } 
      else {
	$this->read_from_ldap(func_get_arg(0));
      }
    }
  }
  
  function is_in_ldap() {
    global $c2i_ldap;
    global $ldap_res;

    $search_dn=$c2i_ldap['schools_dn'];
    $filter="(ou=".$this->rne.")";

    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    if ($info['count']>0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
  
function read_from_ldap ($rne) {
    global $c2i_ldap;
    global $ldap_res;

    $search_dn=$c2i_ldap['schools_dn'];
    $rne=trim($rne);
    $exploded=explode(',',$rne);
    $rne=$exploded['0'];
    $exploded=explode('=',$rne);
    if (isset($exploded['1'])) {
      $rne=$exploded['1'];
    } 
    else {
      $rne=$exploded['0'];
    }
    $filter="(ou=$rne)";
    
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);
    
    $schools=ldap_get_entries($ldap_res,$ldap_search_result);
    
    $school=$schools['0'];

    $this->rne=$rne;
    $this->type=$school['businesscategory']['0'];
    $this->name=stripslashes($school['description']['0']);
    $this->address=stripslashes($school['postaladdress']['0']);
    $this->pob=$school['postofficebox']['0'];
    $this->postalcode=$school['postalcode']['0'];
    $this->city=stripslashes($school['l']['0']);
    $this->phone=$school['telephonenumber']['0'];
    $this->fax=$school['facsimiletelephonenumber']['0'];
    $this->mail=$school['registeredaddress']['0'];

  }

  function insert_into_ldap () {
    global $c2i_ldap;
    global $ldap_res;

    if ($this->is_in_ldap()) {
      $ldap_dn="ou=".$this->rne.",".$c2i_ldap['schools_dn'];
      $ldap_school_mod=array();
      $ldap_school_del=array();
      $old_school = new school($this->rne);
      
      if ($this->name !=''){
	$ldap_school_mod['description']=$this->name ;
      } else {
	if ($old_school->name != '')
	  $ldap_school_del['description']['0']=$old_school->name;
      }
      
      if ($this->address !=''){
	$ldap_school_mod['postalAddress']=$this->address ;
      } else {
	if ($old_school->address != '')
	  $ldap_school_mod['postalAddress']=' ';
      }
      
      if ($this->postalcode !=''){
	$ldap_school_mod['postalCode']=$this->postalcode ;
      } else {
	if ($old_school->postalcode != '')
	  $ldap_school_del['postalcode']['0']=$old_school->postalcode;
      }
      
      if ($this->city !=''){
	$ldap_school_mod['l']=$this->city ;
      } else {
	if ($old_school->city != '')
	  $ldap_school_del['l']['0']=$old_school->city;
      }
      
      if ($this->phone !=''){
	$ldap_school_mod['telephoneNumber']=$this->phone ;
      } else {
	if ($old_school->phone != '')
	  $ldap_school_del['telephoneNumber']['0']=$old_school->phone;
      }

      if ($this->pob !=''){
	$ldap_school_mod['postOfficeBox']=$this->pob ;
      } else {
	if ($old_school->pob != '')
	  $ldap_school_del['postOfficeBox']['0']=$old_school->pob;
      }

      if ($this->mail !=''){
	$ldap_school_mod['registeredAddress']=$this->mail;
      } else {
	if ($old_school->mail != '')
	  $ldap_school_del['registeredAddress']['0']=$old_school->mail;
      }

      if ($this->type !=''){
	$ldap_school_mod['businessCategory']=$this->type ;
      } else {
	if ($old_school->type != '') { 
	  $ldap_school_del['businessCategory']['0']=$old_school->type;
	}
      }

      if ($this->fax !=''){
	$ldap_school_mod['facsimileTelephoneNumber']=$this->fax ;
      } else {
	if ($old_school->fax != ''){
	  $ldap_school_mod['facsimileTelephoneNumber']=' ';
	}
      }
      
      if (count($ldap_school_mod)>0) {
	ldap_modify($ldap_res,$ldap_dn,$ldap_school_mod);  
      }
      
      if (count($ldap_school_del)>0) {
	ldap_mod_del($ldap_res,$ldap_dn,$ldap_school_del);
      }
      
    } 
    else {
      // This is a new entry
      $ldap_dn="ou=".$this->rne.",".$c2i_ldap['schools_dn'];
      $ldap_school['objectClass']="organizationalUnit";
      $ldap_school['ou']=$this->rne;
      if ($this->type !='') {
	$ldap_school['businessCategory']=$this->type;
      }
      if ($this->name!='') {
	$ldap_school['description']=$this->name;
      }
      if ($this->address!='') {
	$ldap_school['postalAddress']=$this->address;
      }
      if ($this->postalcode!='') {
	$ldap_school['postalCode']=$this->postalcode;
      }
      if ($this->city!='') {
	$ldap_school['l']=$this->city;
      }
      if ($this->phone!='') {
	$ldap_school['telephoneNumber']=$this->phone;
      }
      
      if ($this->pob !='') {
	$ldap_school['postOfficeBox']=$this->pob;
      }
      
      if ($this->fax !='') {
	$ldap_school['facsimileTelephoneNumber']=$this->fax;
      }
      
      if ($this->mail !='') {
	$ldap_school['registeredAddress']=$this->mail;
      }
     
      ldap_add($ldap_res,$ldap_dn,$ldap_school);  
    }
  }

}


// Returns an array with all schools parameters.

function ldap_read_schools() {
  global $c2i_ldap,$smarty,$ldap_res;

  $schools=array();

  $search_dn=$c2i_ldap['schools_dn'];
  $filter="(ou=*)";

  $ldap_search_result=@ldap_list($ldap_res,$search_dn,$filter);
  
  if ($ldap_search_result) {

    $info=ldap_get_entries($ldap_res,$ldap_search_result);
        
    $number_schools=$info['count'];
    for ($i=0; $i<$number_schools; $i++){
    
      $rne= $info[$i]['ou']['0'];
      $school = new school($rne);
      $school = (array) $school;
      $params=array('rne'=>$rne);
      $school['control_link'] = menu_link('schoolslist','schools','control_school',$params);
      $school['edit_link']= menu_link('schoolslist','schools','edit',$params);
      $school['delete_link'] = menu_link('schoolslist','schools','confirm_delete',$params);
      array_push($schools, $school);
    }
  } else {
    $smarty->error('recherche dans le DN des établissement impossible. L\'annuaire est il bien initialisé ?');
  }
  return $schools;
  
}



?>
