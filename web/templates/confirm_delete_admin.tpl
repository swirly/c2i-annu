{include file="header.tpl"}
<div class="container">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admins' />
  <input type='hidden' name='action' value='' />
  <input type='hidden' name='uid' value='{$admin.uid}' />
  <div class="page-header text-center">
    <h2> Suppression d'un administrateur </h2>
  </div>

  <table class="table table-nonfluid table-striped table-hover table-condensed">
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

<div class="text-center">

  Confirmez vous la suppression de l'administrateur ? <br>
  
  <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$delete_link} />
  Supprimer
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler
</div>
</form>
</div>
{include file="footer.tpl"}
