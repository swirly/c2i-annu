<div>
  <form name='menuform' action='index.php' method='post' >
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
 
  <ul >
    {if $user_type neq "sadmin"}
    <li>
    <a href="#" {$lien_menu.infos}> <img src="images/identity.png"></img> Profil personnel </a>
    </li>
    {/if}
    <li>
    <a href="#" {$lien_menu.change_password}>
    <img src="images/password_24.png"></img> Mot de passe </a>
    </li>
    <li>
    <a href="#" {$lien_menu.validation}> <img src="images/ok.png"></img> Validation </a>
    </li>
    <li>
    <a href="#" {$lien_menu.mail}> <img src="images/mail.png"></img> Courriel </a>
    </li>
    <li>
    <a href="#" {$lien_menu.logout}> <img src="images/stop.png"></img> Déconnexion </a>
    </li>
  </ul>
  </form>
</div>


