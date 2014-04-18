{include file="header.tpl"}
<div class="formbox">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='config' />
  <input type='hidden' name='action' value='' />

<div class="formdata">
  <table>
    <thead>
      <tr>
	<th></th>
	<th>Nombre</th>
      </tr>
    </thead>
    <tbody>
      <tr>
	<td>INE dans le fichier</td>
	<td>{$file_ine}</td>
      </tr>
      <tr>
	<td>INE en erreur</td>
	<td>{$error_ine}</td>
      </tr>
      <tr>
	<td>INE dans l'annuaire</td>
	<td>{$ok_ine}</td>
      </tr>
      <tr>
	<td>INE hors annuaire</td>
	<td>{$lost_ine}</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="formbuttons">

  Confirmez vous la récupération ? <br>
  
  <img src='images/yes_24.png' width='24' height='24' title='Confirmer' {$confirm_link} />
  Confirmer
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler
</div>
</form>
</div>
{include file="footer.tpl"}
