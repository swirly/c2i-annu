<div>
  <form name='menuform' action='index.php' method='post' >
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
 
  <ul >
    {if $user_type neq "sadmin"}
    <li>
    <a href="#" {$lien_menu.view_profile}>
     <img src="images/identity.png"></img> Profil personnel </a>
    </li>
    {/if}
    <li>
    <a href="#" {$lien_menu.change_password}>
    <img src="images/password_24.png"></img> Mot de passe </a>
    </li>
    <li>
    <a href="#" {$lien_menu.view_school}>
     <img src="images/house.png"></img> &Eacute;tablissement </a>
    </li>
    <li>
    <a href="#" {$lien_menu.list_sections}>
     <img src="images/group.png"></img> Classes </a>
    </li>
    <li>
    <a href="#" {$lien_menu.list_pupils}>
     <img src="images/add_group.png"></img> &Eacute;l&egrave;ves </a>
    </li>
    <li>
    <a href="#" {$lien_menu.logout}> <img src="images/stop.png"></img> Déconnexion </a>
    </li>
    {if $user_type eq "sadmin"}
    <li>
    <a href="#" {$lien_menu.sadmin_return}> Sadmin </a>
    </li>
    {/if}
  </ul>
  </form>
</div>


