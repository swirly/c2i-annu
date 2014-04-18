{include file="header.tpl"}
<div class="formbox">
  <form name='list' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='uid' value=''/>
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th>Nom</th>
	<th>Prénom</th>
	<th> Identifiant </th>
	<th> Courriel </th>
	<th> Action </th>
      </tr>
    </thead>
    {foreach  from=$teachers item=teacher}
    <tr>
      <td> {$teacher.name} </td>
      <td> {$teacher.firstname} </td>
      <td> {$teacher.uid} </td>
      <td> {$teacher.mail} </td>
      <td>
	<img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser le mot de passe' {$teacher.reset_pwd_link} />
	<img src='images/look_24.png' width='24' height='24' title='editer' {$teacher.edit_link} />
	<img src='images/bin_24.png' width='24' height='24' title='supprimer' {$teacher.delete_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="formbuttons">
  <img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser tous les mots de passe' {$password_link} />
  R&eacute;initialiser tous les mots de passe.
  <img src='images/identity.png' width='24' height='24' title='Nouvel enseignant'  {$create_link} />
  Nouvel enseignant
</div>
</form>
</div> 
{include file="footer.tpl"}
