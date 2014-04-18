{include file="header.tpl"}
<div class="formbox">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admin' />
  <input type='hidden' name='action' value='' />
  <input type='hidden' name='uid' value='{$pupil.uid}' />
  <input type='hidden' name='section' value='{$section}' />

<div class="formdata">

  <table>
    <thead>
      <tr>
	<th>Uid</th>
	<th>Nom</th>
	<th>Pr&eacute;</th>
	<th>INE</th>
	<th> Division </th>
	<th> </th>
      </tr>
    </thead>
    <tr>
      <td> {$pupil.uid} </td>
      <td> {$pupil.name} </td>
      <td> {$pupil.firstname} </td>
      <td> {$pupil.ine} </td>
      <td> {$pupil.section} </td>
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
