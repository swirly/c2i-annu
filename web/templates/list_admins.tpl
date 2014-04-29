{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Administrateurs locaux </h2>
  </div>
  <div class="row">
    <form name='adminslist' action='index.php' method='post'>
      <input type='hidden' name='page' value='none' />
      <input type='hidden' name='action' value='none' />
      <input type='hidden' name='uid' value='none'/>

      <table class="table table-nonfluid table-striped table-hover table-condensed">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th> Identifiant </th>
            <th> Courriel </th>
            <th> RNE </th>
            <th> </th>
          </tr>
        </thead>
        {foreach  from=$admins item=admin}
        <tr>
          <td> {$admin.name} </td>
          <td> {$admin.firstname} </td>
          <td> {$admin.uid} </td>
          <td> {$admin.mail} </td>
          <td> {$admin.rne} </td>
          <td>
            <img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser le mot de passe' {$admin.reset_pwd_link} />
            <img src='images/look_24.png' width='24' height='24' title='editer' {$admin.edit_link} />
            <img src='images/bin_24.png' width='24' height='24' title='supprimer' {$admin.delete_link} />
          </td>
        </tr>
        {/foreach}
      </table>

      <div class="text-center">
        <img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser tous les mots de passe' {$password_link} />
        R&eacute;initialiser tous les mots de passe.
        <img src='images/new_school_24.png' width='24' height='24' title='Nouvel administrateur'  {$create_link} />
        Nouvel administrateur
      </div>
    </form>
  </div> 
</div>
{include file="footer.tpl"}
