{include file="header.tpl"}
<div class="formbox">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admins' />
  <input type='hidden' name='action' value='' />
  <input type='hidden' name='uid' value='{$admin.uid}' />

<div class="formdata">

  <table>
    <thead>
      <tr>
	<th>Uid</th>
	<th>Nom</th>
	<th>Pr&eacute;</th>
	<th>RNE</th>
	<th> </th>
      </tr>
    </thead>
    <tr>
      <td> {$admin.uid} </td>
      <td> {$admin.name} </td>
      <td> {$admin.firstname} </td>
      <td> {$admin.rne} </td>
    </tr>
  </table>
</div>

<div class="formbuttons">

  Confirmez vous la suppression de l'administrateur ? <br>
  
  <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$delete_link} />
  Supprimer
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler
</div>
</form>
</div>
{include file="footer.tpl"}
