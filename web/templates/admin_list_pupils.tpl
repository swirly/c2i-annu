{include file="header.tpl"}

<div class="formbox">
  <form name='pupilslist' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='uid' value='none'/>
  <input type='hidden' name='section' value='{$section}'/>
  Liste des élèves inscrits pour le C2I
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> <img src="images/ok.png" onclick="checkAll(document.pupilslist)"></img>
	  <img src="images/no_24.png" onclick="unCheckAll(document.pupilslist)"></img>
	</th>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Pr&eacute;nom</th>
	<th> Courriel </th>
	<th> INE </th>
	<th> Division </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$pupils item=pupil}
    <tr>
      <td> <input type="checkbox" name="pupils[]" value="{$pupil.uid}" /> </td>
      <td> {$pupil.uid} </td>
      <td> {$pupil.name} </td>
      <td> {$pupil.firstname} </td>
      <td> {$pupil.mail} </td>
      <td> {$pupil.ine} </td>
      <td> {$pupil.section} </td>
      <td>
	<img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser le mot de passe' {$pupil.reset_pwd_link} />
	<img src='images/look_24.png' width='24' height='24' title='d&eacute;tails' {$pupil.edit_link} />
	<img src='images/bin_24.png' width='24' height='24' title='supprimer' {$pupil.delete_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="formdata">
  	<img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser tous les mots de passe' {$password_link} />
  Réinitialiser les mots de passe sélectionnés.
  	<img src='images/bin_24.png' width='24' height='24' title='Désinscrire les élèves sélectionnés' {$remove_link} />
  Désinscire les élèves séléctionnés.
</div>
</form>
</div> 
<div class="formbox">
  <form name='trashlist' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='uid' value='none'/>
  <input type='hidden' name='section' value='{$section}'/>
  Liste des élèves qui ne sont pas inscrits.
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> <img src="images/ok.png" onclick="checkAll(document.trashlist)"></img>
	  <img src="images/no_24.png" onclick="unCheckAll(document.trashlist)"></img>
	</th>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Pr&eacute;nom</th>
	<th> INE </th>
	<th> Division </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$trashed item=pupil}
    <tr>
      <td> <input type="checkbox" name="trashed[]" value="{$pupil.uid}" /> </td>
      <td> {$pupil.uid} </td>
      <td> {$pupil.name} </td>
      <td> {$pupil.firstname} </td>
      <td> {$pupil.ine} </td>
      <td> {$pupil.section} </td>
      <td>
	<img src='images/reload_24.png' width='24' height='24' title='recharger' {$pupil.reload_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="formdata">
  <img src='images/reload_24.png' width='24' height='24' title='recharger' {$reload_link} />
  Récupérer les élèves sélectionnés.
</div>
</form>
</div> 

{include file="footer.tpl"}
