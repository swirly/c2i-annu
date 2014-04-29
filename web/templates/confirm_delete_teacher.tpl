{include file="header.tpl"}

<div class="formbox">
  <form name='confirmform' action='index.php' method='post'>
    <input type='hidden' name='page' value='admin' />
    <input type='hidden' name='action' value='' />
    <input type='hidden' name='uid' value='{$teacher.uid}' />
    <div class="page-header text-center">
      <h2> Suppreion d'un enseignant </h2>
    </div>

    <table  class="table table-nonfluid table-striped table-hover table-condensed">
      <thead>
        <tr>
          <th>Uid</th>
          <th>Nom</th>
          <th>Pr&eacute;</th>
          <th> </th>
        </tr>
      </thead>
      <tr>
        <td> {$teacher.uid} </td>
        <td> {$teacher.name} </td>
        <td> {$teacher.firstname} </td>
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
