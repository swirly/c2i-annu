
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">&Eacute;tablissement
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.view_school}>
               &Eacute;tablissement 
           </a>
       </li>
       <li>
        <a href="#" {$lien_menu.list_sections}>
            Classes 
        </a>
    </li>
</ul> 
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Enseignants
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.list_teachers}>  Enseignants
            </a>
        </li>
        <li>
            <a href="#" {$lien_menu.import_teachers}> Import enseignants 
            </a>
        </li>
    </ul> 
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">&Eacute;l&egrave;ves
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.list_pupils}>
             &Eacute;l&egrave;ves 
         </a>
     </li>
     {if $user_type eq "sadmin"}
     <li>
     <a href="#" {$lien_menu.import_pupils}>
        Import &Eacute;l&egrave;ves 
    </a>
</li>
{/if}
<li>
    <a href="#" {$lien_menu.import_sconet_pupils}> Import SCONET 
    </a>
</li>
<li>
    <a href="#" {$lien_menu.reload_pupils}> Récupération d'élèves 
    </a>
</li>
</ul> 
</li>

{if $user_type neq "sadmin"}
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ma fiche
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">

        <li>
            <a href="#" {$lien_menu.view_profile}>
                Profil personnel 
            </a>
        </li>
        <li>
            <a href="#" {$lien_menu.change_password}>
              Mot de passe 
          </a>
      </li>
  </ul> 
</li>
{/if}

{if $user_type eq "sadmin"}
<li>
    <a href="#" {$lien_menu.sadmin_return}> <i class="fa fa-trophy"></i> Sadmin 
    </a>
</li>
{/if}



