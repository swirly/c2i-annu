{include file="header.tpl"}
<div class="formbox">
  <form name='pupilslist' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='uid' value='none'/>
  <input type='hidden' name='section' value=''/>
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Pr&eacute;nom</th>
	<th> INE </th>
	<th> Division </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$pupils item=pupil}
    <tr>
      <td> {$pupil.uid} </td>
      <td> {$pupil.name} </td>
      <td> {$pupil.firstname} </td>
      <td> {$pupil.ine} </td>
      <td> {$pupil.section} </td>
      <td>
	<img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser le mot de passe' {$pupil.reset_pwd_link} />
	<img src='images/look_24.png' width='24' height='24' title='d&eacute;tails' {$pupil.edit_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="formdata">
  	<img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser tous les mots de passe' {$reset_all_pwd_link} />
  R&eacute;initialiser tous les mots de passe.
</div>
</form>
</div> 
{include file="footer.tpl"}
