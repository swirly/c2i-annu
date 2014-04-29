{include file="header.tpl"}
<div class="container">
<div class="page-header text-center">
<h2> Suppression d'une classe </h2>
</div>
  <form name='confirmform' action='index.php' method='post'>
    <input type='hidden' name='page' value='admin' />
    <input type='hidden' name='action' value='' />
    <input type='hidden' name='section' value='{$section.name}' />



    <table class="table table-nonfluid table-striped table-hover table-condensed">
      <thead>
        <tr>
         <th>Code classe</th>
         <th>Classe</th>
         <th>Description</th>
         <th> </th>
       </tr>
     </thead>
     <tr>
      <td> {$section.year}_{$section.rne}_{$section.name} </td>
      <td> {$section.name} </td>
      <td> {$section.description} </td>
    </tr>
  </table>


  <div class="text-center">

    Confirmez vous la suppression de la classe? <br>

    <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$delete_link} />
    Supprimer
    <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
    Annuler
  </div>
</form>
</div>
{include file="footer.tpl"}
