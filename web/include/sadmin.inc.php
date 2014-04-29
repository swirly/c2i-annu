<?php
//require_once('note-class.inc.php');
// sadmin view page.


function sadmin_welcome() {
  
  global $smarty;

  $smarty->assign('header_title','Administration du C2I');

  $smarty->display('sadmin_welcome.tpl');

}

function sadmin_init_menu () {

    global $smarty;
    
    $lien_menu = array('list_schools' => menu_link('menuform','schools','list_schools'),
		       'create_school' => menu_link('menuform','schools','create_school'),
		       'import_schools' => menu_link('menuform','schools','import_schools'),
		       'list_admins' => menu_link('menuform','admins','list_admins'),
		       'create_admin' => menu_link('menuform','admins','create_admin'),
		       'import_admins' => menu_link('menuform','admins','import_admins'),
		       'config_parameters' => menu_link('menuform','config','parameters'),
		       'export_final_link' => menu_link('menuform','admins','export_final_note'),
		       'recover_pupil_from_ine'=>menu_link('menuform','pupils','recover_pupil_from_ine'),
		       'recover_lost_ine'=>menu_link('menuform','config','ldap_recover_lost_ine'),
		       'ldap_clean' => menu_link('menuform','config','ldap_clean_confirm'),
		       'ldap_purge' => menu_link('menuform','config','ldap_purge_confirm'),
		       'ldap_synchronize' => menu_link('menuform','config','ldap_synchronize'),
		       'ldap_export_csv' => menu_link('menuform','ldap','ldap_export_csv'),
		       'ldap_teachers_export_csv' => menu_link('menuform','ldap','ldap_teachers_export_csv'),
		       'ldap_init' => menu_link('menuform','config','ldap_init'),
		       'logout'=>menu_link('menuform','logout','logout')
);
  
  $smarty->assign('lien_menu',$lien_menu);

}

function sadmin_return () {
  $_SESSION['user']->rne='-1';
}

function sadmin_config_parameters () {
  global $smarty,$smarty_full_path,$c2i_password_file,$current_year;
  global $pupil_can_import,$pupil_can_select;
  global $c2i_ldap,$c2imaster_mail;

  $params[]=array('var'=>'smarty_full_path',
		  'name'=>'Chemin complet vers Smarty',
		  'value'=>$smarty_full_path);

  $params[]=array('var'=>'c2i_password_file',
		  'name'=>'fichier des mots de passe sadmin',
		  'value'=>$c2i_password_file);

  $params[]=array('var'=>'current_year',
		  'name'=>'Année en cours',
		  'value'=>$current_year);

  $params[]=array('var'=>'ldap_ip',
		  'name'=>'Adresse IP du serveur LDAP',
		  'value'=>$c2i_ldap['ip']);

  $params[]=array('var'=>'ldap_base_dn',
		  'name'=>'DN de base du serveur LDAP',
		  'value'=>$c2i_ldap['base_dn']);

  $params[]=array('var'=>'ldap_admin_rdn',
		  'name'=>'RDN de l\'administrateur LDAP',
		  'value'=>$c2i_ldap['admin_rdn']);

  $params[]=array('var'=>'ldap_admin_pwd',
		  'name'=>'Mot de passe LDAP',
		  'value'=>$c2i_ldap['admin_pwd']);

  $params[]=array('var'=>'ldap_schools_ou',
		  'name'=>'ou établissements',
		  'value'=>$c2i_ldap['schools_ou']);

  $params[]=array('var'=>'ldap_people_ou',
		  'name'=>'ou des utilisateurs',
		  'value'=>$c2i_ldap['people_ou']);

  $params[]=array('var'=>'ldap_groups_ou',
		  'name'=>'ou des groupes',
		  'value'=>$c2i_ldap['groups_ou']);

  $params[]=array('var'=>'c2imaster_mail',
		  'name'=>'adresse mail du gestionnaire du C2I1',
		  'value'=>$c2imaster_mail);

  $smarty->assign('params',$params);

  $smarty->assign('pupil_can_import_checked',$pupil_can_import?'checked':'');
  $smarty->assign('pupil_can_select_checked',$pupil_can_select?'checked':'');


  $smarty->display('sadmin_config.tpl');
}

function sadmin_config_modify($config) {

    global $smarty;

    $file = '<?php
// Mettre le chemin complet de SMARTY avec
// le slash final

$smarty_full_path="'.$config['smarty_full_path'].'";

$c2i_password_file="'.$config['c2i_password_file'].'";

$c2i_ldap = array ( \'ip\' => "'.$config['ldap_ip'].'",
		    \'base_dn\' => "'.$config['ldap_base_dn'].'",
		    \'admin_rdn\' => "'.$config['ldap_admin_rdn'].'",
		    \'admin_pwd\' => "'.$config['ldap_admin_pwd'].'",
		    \'schools_ou\' => "'.$config['ldap_schools_ou'].'",
		    \'people_ou\' => "'.$config['ldap_people_ou'].'",
		    \'groups_ou\' => "'.$config['ldap_groups_ou'].'"
		    );
		    
$current_year='.$config['current_year'].';

$c2imaster_mail=\''.$config['c2imaster_mail'].'\';

// Fonctionnalités administrateurs locaux.

$pupil_can_import='.(($config['pupil_can_import']=='on')?'true':'false').';

$pupil_can_select='.(($config['pupil_can_select']=='on')?'true':'false').';

// End of configuration file
?>';

    $smarty->assign('file',$file);

    $fichier=@fopen('/etc/c2i-annu/config.php','w');
    if (!$fichier) {
      $warning="l'écriture dans le fichier a échoué, probablement pour des raisons de droits. Il faudra modifier le fichier dans une console sur le serveur";
      $smarty->warning($warning);
    } else {
      fwrite($fichier,$file);
      fclose($fichier);
      $smarty->assign('message','sauvegarde de la configuration réussie');
    }

    $smarty->display('sadmin_config_modify.tpl');

}

function sadmin_export_naissance(){
/*         global $current_year;  
        $a_final=array();

        $schools=ldap_read_schools();
        foreach($schools as $school){
            $a_sections=ldap_read_sections($school['rne']);
            
            foreach($a_sections as $section){
               $_SESSION['user']->rne=$school['rne'];
                $pupils=ldap_read_pupils($section['name']);
                //print_r($pupils);
                foreach($pupils as $pupil){
                    $a_final[$pupil['ine']]['birth']=$pupil['birth'];
                    $a_final[$pupil['ine']]['localisation']=$pupil['localisation'];
                    $a_final[$pupil['ine']]['rne']=$pupil['rne'];
                }
            }



        }
       
        $i=1;

        $workbook = new Spreadsheet_Excel_Writer();

        $format_bold =& $workbook->addFormat();
        $format_bold->setBold();

        $format_title =& $workbook->addFormat();
        $format_title->setBold();

        $format_title->setPattern(1);
        $format_title->setFgColor('silver');

        $worksheet =& $workbook->addWorksheet();
        $worksheet->write(0, 0, "INE", $format_title);
        
        $worksheet->setColumn(0,10,15);

        
        $worksheet->write(0, 1, "Date de Naissance", $format_title);
        $worksheet->write(0, 2, "Lieu de naissance", $format_title);
        $worksheet->write(0, 3, "RNE", $format_title);
        asort(&$a_final);
        foreach($a_final as $key => $value){
            $worksheet->write($i, 0, $key, $format_bold);
            
           
            $worksheet->write($i, 1, $value['birth']);
            $worksheet->write($i, 2, $value['localisation']);
            $worksheet->write($i, 3, $value['rne']);
            $i++;

        }


        $workbook->send('naissance_c2i.xls');
        $workbook->close();
*/

}

function sadmin_recover_pupil_from_ine() {
 
    global $smarty;
    
    $smarty->assign('ine',$_POST['ine']);
    
    $smarty->display('sadmin_recover_pupil_from_ine.tpl'); 
    
}

function sadmin_recover_pupil_from_ine_confirm($params) {
    
    global $smarty;
    
    $ine=$params['ine'];

    $pupil=new people();
    $pupil->recover_from_ine($ine);
 
    $smarty->assign('pupil',(array) $pupil);
    $smarty->assign('ine',$ine);
    
    $smarty->display('sadmin_recover_pupil_from_ine_confirm.tpl');
    
}

function sadmin_recover_pupil_from_ine_process($params) {
    
    global $current_year;

    $ine=$params['ine'];
    $pupil=new people();
    $pupil->recover_from_ine($ine);
    	
    $pupil_section=$current_year."_".$pupil->rne."_".$pupil->section;
    
    if (!$pupil->is_member($pupil_section)) {
	$pupil->add_to_group($pupil_section);
    }

    if (!$pupil->is_member("pupils")) {
	$pupil->add_to_group("pupils");
    }

    if ($pupil->is_member('trash')) { 
	$pupil->del_from_group('trash');
    }

}

function sadmin_ldap_recover_lost_ine($msg="") {

    global $smarty;

    $smarty->assign('header_title','Recuperation des INE');
    if ($msg != '') $smarty->error($msg);
    $smarty->display('sadmin_ldap_recover_lost_ine.tpl');

    exit;
}

function sadmin_confirm_ldap_recover_lost_ine() {

    $file = $_FILES['ine_import_file']['tmp_name'];

    ldap_recover_lost_ine_list($file);


    global $smarty;

    $smarty->assign('file_ine',count($_SESSION['file_ine_list']));
    $smarty->assign('error_ine',count($_SESSION['error_ine_list']));
    $smarty->assign('ok_ine',count($_SESSION['ok_ine_list']));
    $smarty->assign('lost_ine',count($_SESSION['lost_ine_list']));
    $smarty->assign('confirm_link',menu_link('confirmform','config','process_ldap_recover_lost_ine'));
    $smarty->assign('cancel_link',menu_link('confirform','config','ldap_recover_lost_ine'));

    $smarty->assign('header_title','Recuperation des INE');
    if ($msg != '') $smarty->error($msg);
    $smarty->display('sadmin_confirm_ldap_recover_lost_ine.tpl');

}

function sadmin_process_ldap_recover_lost_ine() {

    global $current_year;

    $pupils=$_SESSION['lost_ine_list'];
    
    foreach ($pupils as $pupil) {

	$pupil_section=$current_year."_".$pupil->rne."_".$pupil->section;
    
	if (!$pupil->is_member($pupil_section)) {
	    $pupil->add_to_group($pupil_section);
	}
	
	if (!$pupil->is_member("pupils")) {
	    $pupil->add_to_group("pupils");
	}
	
	if ($pupil->is_member('trash')) { 
	    $pupil->del_from_group('trash');
	}
    }
    
    sadmin_welcome();

}

function sadmin_ldap_export_csv() {

    $all_pupils = ldap_read_pupils();
    $pupils = $all_pupils['pupils'];

    header('Content-Type: application/csv-tab-delimited-table');
    header('Content-Disposition: attachment; filename="c2i_eleves.csv"');
    header('Pragma: no-cache');

    print "INE;Nom;Prenom;Login;Date de naissance;Lieu de naissance;RNE;Section;\n";

    foreach ($pupils as $pupil) {
	print $pupil['ine'].";";
	print $pupil['name'].";";
	print $pupil['firstname'].";";
	print $pupil['uid'].";";
	print $pupil['birth'].";";
	print $pupil['localisation'].";";
	print $pupil['rne'].";";
	print $pupil['section'].";\n";	
    }  
}

function sadmin_ldap_teachers_export_csv() {

  $teachers = people::read_teachers();

    header('Content-Type: application/csv-tab-delimited-table');
    header('Content-Disposition: attachment; filename="c2i_teacherss.csv"');
    header('Pragma: no-cache');

    print "Nom;Prenom;Login;Courriel;RNE;\n";

    foreach ($teachers as $teacher) {
	print $teacher['name'].";";
	print $teacher['firstname'].";";
	print $teacher['uid'].";";
	print $teacher['mail'].";";
	print $teacher['rne'].";\n";
    }  
}


?>