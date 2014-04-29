<?php

require_once('/etc/c2i-annu/config.php');
require_once('include/ldap.inc.php');

class section {

  public $name;
  public $rne;
  public $year;
  public $description;
  
  function __construct() {
    global $current_year;
    $this->year = $current_year;
    $this->rne = $_SESSION['user']->rne;
    if (func_num_args() == 1 ) {      
      if (is_array(func_get_arg(0))) {
	$section=func_get_arg(0);
	$this->name=$section['name'];
	$this->description=$section['description'];      
      }
      else {      
	$this->read_from_ldap(func_get_arg(0));
      }
    }    
    else {
      $this->description = '';
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

  function is_in_ldap() {
    global $c2i_ldap;
    global $ldap_res;

    $search_dn=$c2i_ldap['groups_dn'];
    $filter="(cn=".$this->year."_".$this->rne."_".$this->name.")";

    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    if ($info['count']>0) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
    
  function read_from_ldap ($name) {
    // le uid peut être donné isolément ou sous la forme de dn LDAP
    global $c2i_ldap;
    global $ldap_res;
    $name=strtolower($name);

    $search_dn=$c2i_ldap['groups_dn'];
      
    $filter="(cn=".$this->year."_".$this->rne."_$name)";
   
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);
    
    $sections=ldap_get_entries($ldap_res,$ldap_search_result);
    
    $section=$sections['0'];

    $this->name=$name;
    $this->assign_attrib_from_ldap($section,'description','description');
  }

  function insert_into_ldap() {
    global $c2i_ldap;
    global $ldap_res;

    if (!$this->is_in_ldap()) {      
      // This is a new entry
      $ldap_dn="cn=".$this->year."_".$this->rne."_".$this->name.",".$c2i_ldap['groups_dn'];

      $ldap_section['objectClass']="groupOfNames";
      $ldap_section['cn']=$this->year."_".$this->rne."_".$this->name;
      $this->map_to_ldap($ldap_section,'description','description');

      $school_ou="ou=".$this->rne.",".$c2i_ldap['schools_dn'];
      $ldap_section['ou']=$school_ou;
      $ldap_section['member']=$c2i_ldap['admin_dn'];

      ldap_add($ldap_res,$ldap_dn,$ldap_section); 
    }
     
  }

  function delete() {
    global $c2i_ldap;
    global $ldap_res;

    if ($this->is_in_ldap()) {
     $ldap_dn="cn=".$this->year."_".$this->rne."_".$this->name.",".$c2i_ldap['groups_dn'];
     ldap_delete($ldap_res,$ldap_dn);
    }
  }
}


function ldap_read_sections($rne) {
  global $c2i_ldap;
  global $ldap_res;
  global $current_year;

  $search_dn=$c2i_ldap['groups_dn'];
  $filter="(cn=".$current_year."_".$rne."*)";

  $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);

  $info=ldap_get_entries($ldap_res,$ldap_search_result);

  $sections=array();

  $number_sections=$info['count'];
  for ($i=0; $i<$number_sections; $i++){
    $code = $info[$i]['cn']['0'];
    $name = explode('_',$code,3);
    $name=$name[2];
    $section = new section($name);
    $section = (array) $section;
    $section['code']=$code;
    $params=array('section'=>$name);
    if ($_SESSION['user']->type=='teacher') {
    $section['list_link'] = menu_link('sectionslist','teacher','list_pupils',$params);
    } else {
      $section['delete_link'] = menu_link('sectionslist','admin','confirm_delete_section',$params);
      $section['list_link'] = menu_link('sectionslist','admin','list_pupils',$params);
      $section['note_link'] = menu_link('sectionslist','admin','note_pupils',$params);
    }
    array_push($sections, $section);
  }

  return $sections;
  
}


?>