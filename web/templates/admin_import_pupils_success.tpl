{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Import des &eacute;tudiants </h2>
  </div>
  <div class="row">
    <p>  Voici la liste des élèves ajoutés à l'application. Vous pourrez aller à la page de réinitialisation des mots de passe pour leur attribuer un mot de passe.
    </p>

    <table class="table table-nonfluid table-striped table-hover table-condensed">
      <thead>
        <tr>
         <th> Nom complet </th>
         <th> Login </th>
         <th> Mot de passe </th>
       </tr>
     </thead>
     {foreach  from=$password_list item=password_item}
     <tr>
      <td> {$password_item.cn} </td>
      <td> {$password_item.uid} </td>
      <td> {$password_item.password} </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="row">

  <p>
    Voici la liste des élèves dont les données ont été mises à jour.
    Leur mot de passe reste inchangé.
  </p>
  <table class="table table-nonfluid table-striped table-hover table-condensed">
    <thead>
      <tr>
       <th> Nom complet </th>
       <th> Login </th>
       <th> </th>
     </tr>
    </thead>
    <tbody>
    {foreach  from=$modified_list item=modified_item}
    <tr>
      <td> {$modified_item.cn} </td>
      <td> {$modified_item.uid} </td>
    </tr>
    {/foreach}
    </tbody>
  </table>
</div>
</div>

{include file="footer.tpl"}
