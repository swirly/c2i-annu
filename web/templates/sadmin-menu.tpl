<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">&Eacute;tablissements
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.list_schools}>Liste</a>
        </li>
        <li>
            <a href="#" {$lien_menu.create_school}>Nouveau</a>
        </li>
        <li>
            <a href="#" {$lien_menu.import_schools}>Import</a>
        </li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">&Eacute;l&egrave;ves
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.recover_pupil_from_ine}>Recuperer depuis un INE</a>
        </li>
    </ul>
</li>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administrateurs
        <b class="caret"></b>
    </a>

    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.list_admins}>Liste</a>
        </li>
        <li>
            <a href="#" {$lien_menu.create_admin}>Nouveau</a>
        </li>
        <li>
            <a href="#" {$lien_menu.import_admins}>Import</a>
        </li>

        <li>
            <a href="#" {$lien_menu.export_final_link}>Export Date naissance</a>
        </li>
    </ul>
</li>


<li class="dropdwon">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Annuaire
        <b class="caret"></b>
    </a>

    <ul class="dropdown-menu">
        <li>
            <a href="#" {$lien_menu.ldap_export_csv}>
                Exporter le LDAP dans un CSV
            </a>
        </li>
        <li>
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
        <li>
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
</li>

<li class="dropdwon">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuration
        <b class="caret"></b>
    </a>

    <ul class="dropdown-menu">

        <li>
            <a href="#" {$lien_menu.config_parameters}>
                Param&egrave;tres.
            </a>
        </li>
        <li>
            <a href="#" {$lien_menu.ldap_init}>
                Initisalisation du LDAP
            </a>
        </li>
    </ul>

</li>



