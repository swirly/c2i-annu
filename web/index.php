<?php
/* -----------------
/ C2ildapadm Controller
/------------------*/

require_once('include/exceptions-class.php');
require_once('include/auth.inc.php');
require_once('include/c2ildapadm.inc.php');
require_once('include/people.inc.php');
require_once('include/admins.inc.php');
require_once('include/admin.inc.php');
require_once('include/teacher.inc.php');
require_once('include/sadmin.inc.php');
require_once('include/schools.inc.php');
require_once('include/pupil.inc.php');

global $c2i_ldap;
global $smarty;
global $current_year;

// Etablissement des ressources LDAP complétes.

$c2i_ldap['groups_dn']="ou=".$c2i_ldap['groups_ou'].",".$c2i_ldap['base_dn'];
$c2i_ldap['schools_dn']="ou=".$c2i_ldap['schools_ou'].",".$c2i_ldap['base_dn'];
$c2i_ldap['people_dn']="ou=".$c2i_ldap['people_ou'].",".$c2i_ldap['base_dn'];
$c2i_ldap['admin_dn']="cn=".$c2i_ldap['admin_rdn'].",".$c2i_ldap['base_dn'];

$ldap_res=ldap_connection();

if ($DEBUG) {
  $debug_info .=("debugging informations");
  $debug_info .=("<hr>Session<hr><pre>");
  $debug_info .=print_r($_SESSION,true);
  $debug_info .=("</pre><hr>");
  $debug_info .=("<hr>POST<hr><pre>");
  $debug_info .=print_r($_POST,true);
  $debug_info .=("</pre><hr>");
  $debug_info .=("<hr>GET<hr><pre>");
  $debug_info .=print_r($_GET,true);
  $debug_info .=("</pre><hr>");
  $smarty->assign ('debug_info',$debug_info);
}

if (!session_is_registered("user")) {
    $page="login";
 } else {
    if ( $_POST['page'] != 'logout') {    
	$user=$_SESSION['user'];
	switch ($user->type) {
	case 'sadmin':  
	    if ($user->rne=='-1') {
		sadmin_init_menu();
	    } 
	    else {
		admin_init_menu();
	    } 
	    break;
	case 'admin' :
	  admin_init_menu();
	  break;
	case 'teacher' :
	  teacher_init_menu();
	  break;
	case 'pupil' :
	    pupil_init_menu();
	    break;
	}
    }

    $smarty->assign('user_type',$user->type);
    $smarty->assign('user_rne',$user->rne);
    
    $page=$_POST['page'];
 }


$action=$_POST['action'];


switch ($page) {
    /*
     Gestion de l'authentification
    */

 case 'login':
     switch ($action) {
     case 'validate_login':
	 try {
	     if(user::authentify($_POST['login'],$_POST['password'])) {
		 $smarty->assign('header_title','Authentification réussie');
		 $smarty->display('login_ok.tpl');
	     } else {
		 $smarty->assign('header_title','Authentification');
		 $smarty->display('login.tpl');
	     }	 
	 } catch (C2iException $exception) {
	     $smarty->assign('header_title','Authentification');
	     $smarty->assign('error',$exception->getMessage()."<br><i>".$exception->getDetails()."</i>");
	     $smarty->display('login.tpl');
	 }
	 break;
     default:
         $smarty->assign('header_title','Authentification');
	 $smarty->display('login.tpl');
	 break;
     }
     break;     
     
 case 'accueil' :
     switch ($user->type) {
     case 'sadmin':
	 sadmin_list_schools();
	 break;
     case 'admin':
	 admin_list_sections();
	 break;
     case 'teacher':
	 teacher_list_sections();
	 break;
     case 'pupil':
	 pupil_infos();
	 break;
     }     
     break;
   
   /* 
      Gestion des administrateurs locaux
   */

 case 'logout' :
   session_start();
   session_unset();
   session_destroy();
   $smarty->assign('title','Deconnexion');
   $smarty->display('logout.tpl');
   break;

 case 'people' :
   switch ($action) {
   case 'change_password':
     people_change_password();
     break;
   case 'password_process':
     people_password_process();
     break;
   default :
     c2ildapadm_unauthorized();
     break;     
   }
   break;
     
 case 'admins' :
   if ($user->type !='sadmin') {
     $action='unauthorized';
   }
   switch ($action) {
   case 'list_admins' :
       sadmin_list_admins();
       break;
   case 'create_admin':
       sadmin_create_admin();
       break;
   case 'edit' :
       sadmin_modify_admin($_POST['uid']);
       break;
   case 'reset_admin_pwd':
       sadmin_reset_admin_pwd($_POST['uid']);
       break;
   case 'reset_all_admins_pwd':
       sadmin_reset_all_admins_pwd();
       break;
   case 'process' : 
       sadmin_admin_process();
       break;
   case 'delete' :
       sadmin_delete_admin($_POST['uid']);     
       break;
   case 'confirm_delete' :
       sadmin_confirm_delete_admin($_POST['uid']);
       break;
   case 'import_admins' :
       sadmin_admins_import();
       break;
   case 'export_final_note':
       sadmin_export_naissance();
       break;
   case 'process_import' :
       sadmin_admins_process_import();
       break;
   case 'process_import_create' :
       sadmin_admins_process_import_create();
   case 'unauthorized' :
       c2ildapadm_unauthorized();
       break;
   default :
       c2ildapadm_unauthorized();
       break;
   }
   break;

   /*
    Gestion  des élèves.
   */

 case 'pupils' :
     if ($user->type !='sadmin') {
	 $action='unauthorized';
     }
     switch ($action)  {
     case 'recover_pupil_from_ine' :
	 $smarty->assign('header_title',"R&eacute;cup&eacute;rer depuis l'INE");
	 sadmin_recover_pupil_from_ine();
	 break;
     case 'recover_pupil_from_ine_confirm':
	 $smarty->assign('header_title',"Confirmation du choix.");
	 sadmin_recover_pupil_from_ine_confirm($_POST);
	 break;
     case 'recover_pupil_from_ine_process':
	 sadmin_recover_pupil_from_ine_process($_POST);
	 $smarty->assign('header_title',"R&eacute;cup&eacute;rer depuis l'INE");
	 sadmin_recover_pupil_from_ine();
	 break;
     case 'unauthorized' :
	 c2ildapadm_unauthorized();
	 break;
     default:
	 sadmin_welcome();
	 break;
     }
     break;

  /*
      Gestion des établissements
   */

 case 'schools' :
   if ($user->type !='sadmin') {
     $action='unauthorized';
   }
   switch ($action) {
   case 'welcome_schools' :
     sadmin_welcome_schools();
     break;
   case 'list_schools' :
     sadmin_list_schools();
     break;
   case 'create_school':
     sadmin_create_school();
     break;
   case 'edit' :     
     sadmin_modify_school($_POST['rne']);
     break;
   case 'confirm_delete' :
     sadmin_confirm_delete_school($_POST['rne']);
     break;
   case 'delete' :
     sadmin_delete_school($_POST['rne']);     
     break;
   case 'process' :
     $school=new school($_POST);
     $school->insert_into_ldap();
     sadmin_list_schools();
     break;
   case 'import_schools' :
     sadmin_import_schools();
     break;

   case 'process_import' :
     sadmin_schools_process_import();
     break;
   case 'control_school' :
       $_SESSION['user']->rne=$_POST['rne'];
       $smarty->assign('user_rne',$user->rne);
       admin_init_menu();
       admin_view_school();
       break;
   case 'unauthorized' :
       c2ildapadm_unauthorized();
       break;
   default :
       sadmin_welcome_schools();
       break;
   }
   break;

   /*
    *
    *  Gestion de la configuration
    *
    */

 case 'config' :
   if ($user->type !='sadmin' ) {
     $action='unauthorized';
   }
   switch ($action) {
   case 'parameters':
     sadmin_config_parameters();
     break;
   case 'config_modify' :
     sadmin_config_modify($_POST);
     break;
   case 'ldap_clean_confirm' :
     ldap_clean_confirm();
     break;
   case 'ldap_clean' :
     ldap_clean();
     sadmin_welcome();
     break;
   case 'ldap_purge_confirm' :
     ldap_purge_confirm();
     break;
   case 'ldap_purge' :
     ldap_purge();
     sadmin_welcome();
     break;
   case 'ldap_synchronize' :
     sadmin_ldap_synchronize();
     break;
   case 'process_ldap_synchronize' :
     sadmin_process_ldap_synchronize();
     break;
   case 'ldap_recover_lost_ine' :
     sadmin_ldap_recover_lost_ine();
     break;
   case 'confirm_ldap_recover_lost_ine' :
     sadmin_confirm_ldap_recover_lost_ine();
     break;
   case 'process_ldap_recover_lost_ine' :
     sadmin_process_ldap_recover_lost_ine();
     break;
   case 'ldap_init':
     $smarty->assign('message','initialisation du LDAP effectuée');
     ldap_init();
     sadmin_list_schools();
     break;
   default :
     c2ildapadm_unauthorized();
     break;
   }
   break;

   /*
    *  Gestion de l'annuaire
    */

 case 'ldap' :
     if ($user->type !='sadmin') {
	 $action='unauthorized';
     }
     
     switch ($action) {
     case 'ldap_export_csv' :
	 sadmin_ldap_export_csv();
	 break;
     case 'ldap_teachers_export_csv' :
	 sadmin_ldap_teachers_export_csv();
	 break;	 
     default :
	 c2ildapadm_unauthorized();
	 break;
     }
     break;

   /*
      Pages des admins locaux 
   */

 case 'admin':
   if ($user->type !='sadmin' && $user->type!='admin') {
     $action='unauthorized';
   }
   switch ($action) {
   case 'view_profile' :
     admin_view_profile();
     break;
   case 'view_school' :
     admin_view_school();
     break;
   case 'list_sections' :
     admin_list_sections();
     break;
   case 'create_section' :
     admin_create_section($_POST['section']);
     admin_list_sections();
     break;
   case 'confirm_delete_section' :
     admin_confirm_delete_section($_POST['section']);
     break;
   case 'delete_section' :
     admin_delete_section($_POST['section']);
     admin_list_sections();
     break;
   case 'list_pupils' :
     admin_list_pupils($_POST['section']);
     break;
   case 'reset_pupil_pwd' :
     admin_reset_pupil_password($_POST['uid']);
     break;
   case 'reset_all_pupils_pwd' :
     admin_reset_all_pupils_password($_POST['section']);
     break;
   case 'reset_selected_pupils_password':
     admin_reset_selected_pupils_password();
     break;;
   case 'export_pwd_CSV' :
     admin_export_password_CSV();
     break;
   case 'confirm_delete_pupil' :
     admin_confirm_delete_pupil($_POST['uid']);
     break;
   case 'delete_pupil' :
     admin_delete_pupil($_POST['uid']);
     break;
   case 'delete_selected_pupils' :
     admin_delete_selected_pupils();
     break;
   case 'reload_pupils':
     admin_reload_pupils($_POST['section']);
     break;
   case 'reload_pupil' :
     admin_reload_pupil($_POST['uid']);
     admin_list_pupils($_POST['section']);
     break;     
   case 'reload_selected_pupils' :
     admin_reload_selected_pupils();
     admin_list_pupils($_POST['section']);
     break;
   case 'import_pupils':
     admin_import_pupils();
     break;
   case 'import_sconet_pupils':
     admin_import_sconet_pupils();
     break;
   case 'edit_pupil' :
     admin_edit_pupil($_POST['uid']);
     break;
   case 'process_import' :
     admin_process_pupils_import();
     break;
   case 'process_sconet_import':
     admin_process_sconet_import();
     break;
   case 'process_sconet_import_create' :
     admin_process_sconet_import_create();
     break;
   case 'note_pupils' :
     admin_list_pupils_note($_POST['section']);
     break;
   case 'process_note_pupils' :
     admin_process_pupils_note($_POST['note'],$_POST['section']);
    break;
   case 'export_pupils_note' :
     admin_export_pupils_note($_POST['section']);
    break;     
   case 'import_pupils_note' :      
       admin_import_pupils_note($_FILES,$_POST['section'],$_SESSION['user']->rne);
       break;
   case 'exportCSV' :
       admin_exportCSV($_SESSION['user']->rne);
       break;
   case 'process_import_create' :
       admin_process_pupils_import_create();
       break;
   case 'list_teachers':
     admin_list_teachers();
     break;
   case 'modify_teacher':
     admin_modify_teacher($_POST['uid']);
   case 'create_teacher':
     admin_create_teacher($_POST);
     break;
   case 'create_teacher_process':
     admin_create_teacher_process();
     break;
   case 'delete_teacher':
     admin_delete_teacher($_POST['uid']);
     break;
   case 'delete_teacher_confirm':
     admin_delete_teacher_confirm($_POST['uid']);
     break;
   case 'import_teachers':
     admin_import_teachers();
     break;
   case 'import_teachers_process':
     admin_import_teachers_process();
     break;
   case 'reset_teacher_password':
     admin_reset_teacher_password($_POST['uid']);
     break;
   case 'reset_all_teachers_password':
     admin_reset_all_teachers_password();
     break;
   case 'sadmin_return' :
       if ($user->type == 'sadmin') {
	   sadmin_return();
	   $smarty->assign('user_rne','-1');
	   sadmin_init_menu();
	   sadmin_list_schools();
       } else {
	   c2ildapadm_unauthorized();
       }
       break;
   default :
     c2ildapadm_unauthorized();
       break;
   }
   break;
   
   /*
    * Gestion des enseignants.
    */

 case 'teacher' : 
   switch ($action) {
   case 'view_profile' :
     teacher_view_profile();
     break;
   case 'view_school' :
     teacher_view_school();
     break;
   case 'list_sections' :
     teacher_list_sections();
     break;
   case 'list_pupils' :
     teacher_list_pupils($_POST['section']);
     break;
   case 'reset_pupil_password':
     teacher_reset_pupil_password($_POST['uid']);
     break;
   case 'reset_all_pupils_password':
     teacher_reset_all_pupils_password($_POST['section']);
     break;
   case 'export_pwd_CSV':
     admin_export_password_CSV();
     break;
   default :
     c2ildapadm_unauthorized();
   }
   break;

 case 'pupil' :
   switch ($action) {
   case 'infos':
     pupil_infos();
     break;
   case 'validation':
     pupil_validation();
     break;
   case 'process_validation':
     pupil_process_validation();
     break;
   case 'mail':
     pupil_mail();
     break;
   case 'process_mail':
     pupil_process_mail();
     break;
   default:
     c2ildapadm_unauthorized();
   }
   break;
   
 default :
   sadmin_welcome();
   break;
 }
?>