<?php

function ldap_connection() {
    global $c2i_ldap;
    $ldap_res=@ldap_connect($c2i_ldap['ip']) or die("impossible de se connecter au LDAP!");
    @ldap_set_option($ldap_res, LDAP_OPT_PROTOCOL_VERSION, 3);  
    @ldap_bind($ldap_res,$c2i_ldap['admin_dn'],$c2i_ldap['admin_pwd']);
    return $ldap_res;     
  }

function ldap_delete_school($RNE) {    
    global $c2i_ldap;
    
    $ldap_res=ldap_connection();
    
    $ldap_dn="ou=".$RNE.",".$c2i_ldap['schools_dn'];
    return ldap_delete($ldap_res,$ldap_dn);  
}

function ldap_clean_confirm() {
  global $smarty;

  $smarty->assign('header_title','Purge de l\'annuaire LDAP');
  $warning = 'Vous allez basculer l\'ensemble des élèves dans la corbeille. ';
  $warning .='Assurez vous d\'avoir une sauvegarde. ';
  $warning .='Êtes vous sur de vouloir continuer ? ';
  $smarty->warning($warning);

  $purge_link=menu_link('confirmform','config','ldap_clean');
  $cancel_link=menu_link('confirmform','sadmin','welcome');
  
  $smarty->assign('purge_link',$purge_link);
  $smarty->assign('cancel_link',$cancel_link);
  $smarty->display('ldap_clean_confirm.tpl');

}


function ldap_clean() {
    global $c2i_ldap;
    global $current_year;

    $ldap_res=ldap_connection();
    
    $search_dn=$c2i_ldap['groups_dn'];
    $filter="(cn=".$current_year."_*)";    
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter);    
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    for ($i=0; $i<$info['count'];$i++) {
	ldap_delete($ldap_res,$info[$i]['dn']);
    }
    
    $search_dn=$c2i_ldap['groups_dn'];
    $filter="(cn=pupils)";
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter); 
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    for ($i=1; $i<$info['0']['member']['count'];$i++) {
    //  ldap_delete($ldap_res,$info['0']['member'][$i]);
      $to_delete['member']=$info['0']['member'][$i];
      ldap_mod_del($ldap_res,$info['0']['dn'],$to_delete);
    }
    
    $search_dn=$c2i_ldap['groups_dn'];
    $filter="(cn=trash)";
    $ldap_search_result=ldap_list($ldap_res,$search_dn,$filter); 
    $info=ldap_get_entries($ldap_res,$ldap_search_result);
    for ($i=1; $i<$info['0']['member']['count'];$i++) {
    //  ldap_delete($ldap_res,$info['0']['member'][$i]);
	$to_delete['member']=$info['0']['member'][$i];
	ldap_mod_del($ldap_res,$info['0']['dn'],$to_delete);
    }
   
    ldap_unbind($ldap_res);
}

function ldap_purge_confirm() {
  global $smarty;

  $smarty->assign('header_title','Purge de l\'annuaire LDAP');
  $warning = 'Vous allez vider l\'annuaire LDAP de l\'ensemble des élèves non affectés.';
  $warning .='Assurez vous d\'avoir une sauvegarde. ';
  $warning .='Êtes vous sur de vouloir continuer ? ';
  $smarty->warning($warning);

  $purge_link=menu_link('confirmform','config','ldap_purge');
  $cancel_link=menu_link('confirmform','sadmin','welcome');
  
  $smarty->assign('purge_link',$purge_link);
  $smarty->assign('cancel_link',$cancel_link);
  $smarty->display('ldap_purge_confirm.tpl');

}


function ldap_purge() {
    global $c2i_ldap;
    global $current_year;

    $ldap_res=ldap_connection();
    
    $search_dn=$c2i_ldap['people_dn'];
    $filter="(employeeType=pupil)" ;

    $ldap_search_result=ldap_search($ldap_res,$search_dn,$filter);

    $info=ldap_get_entries($ldap_res,$ldap_search_result);

    $pupils_number=$info['count'];

    for ($count=0; $count<$pupils_number;$count++) {
      $uid= $info[$count]['uid']['0'];
      $pupil = new people($uid);
      
      $destroy=true;

      if ($pupil->is_member('pupils'))  {
	$destroy=false;
      }
      if ($pupil->is_member('trash')) {
	$destroy=false;
      }
      if ($destroy) {
	$pupil->destroy();
      }

    }      
    ldap_unbind($ldap_res);
}

function ldap_init() {
  global $c2i_ldap,$ldap_res,$smarty;

  $top['objectClass']='organizationalUnit';
  $results=explode(',',$c2i_ldap['base_dn']);
  $result=$results['0'];
  $results=explode('=',$result);
  $result=$results['1'];
  $top['ou']=$result;
  $dn=$c2i_ldap['base_dn'];
  @ldap_add($ldap_res,$dn,$top);

  $admin['objectClass']='organizationalRole';
  $admin['cn']=$c2i_ldap['admin_rdn'];
  $dn=$c2i_ldap['admin_dn'];
  @ldap_add($ldap_res,$dn,$admin);


  $groups['objectClass']='organizationalUnit';
  $groups['ou']=$c2i_ldap['groups_ou'];
  $dn="ou=".$groups['ou'].",".$c2i_ldap['base_dn'];
  @ldap_add($ldap_res,$dn,$groups);

  $people['objectClass']='organizationalUnit';
  $people['ou']=$c2i_ldap['people_ou'];
  $dn="ou=".$people['ou'].",".$c2i_ldap['base_dn'];
  @ldap_add($ldap_res,$dn,$people);

  $schools['objectClass']='organizationalUnit';
  $schools['ou']=$c2i_ldap['schools_ou'];
  $dn="ou=".$schools['ou'].",".$c2i_ldap['base_dn'];
  @ldap_add($ldap_res,$dn,$schools);

  $group['objectClass']='groupOfNames';
  $group['member']=$c2i_ldap['admin_dn'];

  $group['cn']='sadmins';
  $dn='cn='.$group['cn'].",".$c2i_ldap['groups_dn'];
  @ldap_add($ldap_res,$dn,$group);

  $group['cn']='admins';
  $dn='cn='.$group['cn'].",".$c2i_ldap['groups_dn'];
  @ldap_add($ldap_res,$dn,$group);

  $group['cn']='teachers';
  $dn='cn='.$group['cn'].",".$c2i_ldap['groups_dn'];
  @ldap_add($ldap_res,$dn,$group);

  $group['cn']='pupils';
  $dn='cn='.$group['cn'].",".$c2i_ldap['groups_dn'];
  @ldap_add($ldap_res,$dn,$group);

  $group['cn']='trash';
  $dn='cn='.$group['cn'].",".$c2i_ldap['groups_dn'];
  @ldap_add($ldap_res,$dn,$group);

}

?>