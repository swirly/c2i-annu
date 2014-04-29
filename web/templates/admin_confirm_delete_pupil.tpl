{include file="header.tpl"}
<div class="container">
<div class="page-header text-center">
<h2> Suppression d'un &eacute;tudiant </h2>
</div>
  <form name='confirmform' action='index.php' method='post'>
    <input type='hidden' name='page' value='admin' />
    <input type='hidden' name='action' value='' />
    <input type='hidden' name='uid' value='{$pupil.uid}' />
    <input type='hidden' name='section' value='{$section}' />

    <table class="table table-nonfluid table-striped table-hover table-condensed">
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

  <div class="text-center">

    <p>Confirmez vous la suppression de l'&eacute;tudiant ? </p>

    <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$delete_link} />
    Supprimer
    <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
    Annuler
  </div>
</form>
</div>
{include file="footer.tpl"}
