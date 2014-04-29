{include file="header.tpl"}
<div class="container">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='schools' />
  <input type='hidden' name='action' value='' />
  <input type='hidden' name='rne' value='{$school.rne}' />
  <div class="page-header text-center">
    <h2> Suppression d'un &eacute;tablissement </h2>
  </div>

  <table  class="table table-nonfluid table-striped table-hover table-condensed">
    <thead>
      <tr>
	<th>RNE</th>
	<th>Nom</th>
	<th>Code Postal</th>
	<th>Ville</th>
	<th> </th>
      </tr>
    </thead>
    <tr>
      <td> {$school.rne} </td>
      <td> {$school.name} </td>
      <td> {$school.postalCode} </td>
      <td> {$school.city} </td>
    </tr>
  </table>


<div class="text-center">

  Confirmez vous la suppression de l'&eacute;tablissement ? <br>
  
  <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$delete_link} />
  Supprimer
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler
</div>
</form>
</div>
{include file="footer.tpl"}
