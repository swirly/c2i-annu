<div>
  <form name='menuform' action='index.php' method='post' enctype="multipart/form-data">
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
 
  <ul>
    <li >
    <h3> &Eacute;tablissements </h3>
    <div >
      <ul >
	<li>
	<a href="#" {$lien_menu.list_schools}> Liste </a>
	</li>
	<li>
	<a href="#" {$lien_menu.create_school}> Nouveau </a>
	</li>
	<li>
	<a href="#" {$lien_menu.import_schools}> Import </a>
	</li>
      </ul>
    </div>
    </li>

{*
    <li>

    <h3> &Eacute;l&egrave;ves </h3>
    <div>
      <ul>
	<li>
	<a href="#" {$lien_menu.recover_pupil_from_ine}> Recuperer depuis un INE </a>
	</li>
      </ul>
    </div>
    </li>
*}
    
    <li>
    <h3> Administrateurs </h3>
    <div>
      <ul>
	<li>
	<a href="#" {$lien_menu.list_admins}> Liste </a>
	</li>
	<li>
	<a href="#" {$lien_menu.create_admin}> Nouveau </a>
	</li>
	<li>
	<a href="#" {$lien_menu.import_admins}> Import </a>
	</li>
{*
	<li>
	<a href="#" {$lien_menu.export_final_link}> Export Date naissance </a>
	</li>
 *}
      </ul>
    </div>
    </li>
    <li>
    <h3> Annuaire </h3>
    <div>
      <ul >
	<li >
	<a href="#" {$lien_menu.ldap_export_csv}>
	Exporter le LDAP dans un CSV
	</a>
	</li>
	<li >
	<a href="#" {$lien_menu.ldap_teachers_export_csv}>
	Exporter les enseignants dans un CSV
	</a>
	</li>
	<li>
	<a href="#" {$lien_menu.ldap_clean}>
	Bascule de l'annuaire
	</a>
	</li>
	<li>
	<a href="#" {$lien_menu.ldap_purge}>
	Purge de l'annuaire
	</a>
	</li>
{*
	<li >
	<a href="#" {$lien_menu.recover_lost_ine}>
	Réintégrer des INE perdus
	</a>
	</li>
	<li> 
 	<a href="#" {$lien_menu.ldap_synchronize}> 
 	Synchronisation de l'annuaire 
 	</a>
 	</li>
*}
      </ul>
    </div>
    </li>
    <li>
    <h3> Configuration </h3>
    <div>
      <ul >
	<li >
	<a href="#" {$lien_menu.config_parameters}>
	Param&egrave;tres.
	</a>
	</li>
	<li >
	<a href="#" {$lien_menu.ldap_init}>
	Initisalisation du LDAP
	</a>
	</li>
      </ul>
    </div>
    </li>
    <h3> Déconnexion </h3>
    <div>
      <ul >
	<li >
	<a href="#" {$lien_menu.logout}>
	<img src="images/stop.png" alt="logout"></img>
	Logout.
	</a>
	</li>
      </ul>
    </div>
    </li>
  </ul>
  </form>
</div>


