{include file="header.tpl"}
<div class="container">

<div class="col-md-8 col-md-offset-2" style="display:inline-block;">
<div class="text-center alert alert-info">
Voici la liste des mots de passe réinitialisés.<br>
Sauvegardez cette page ou imprimez là. <br>
</div>
  <table class="table table-nonfluid table-striped table-hover">
    <thead>
      <tr>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Nouveau mot de passe</th>
      </tr>
    </thead>
    {foreach  from=$teachers item=teacher}
    <tr>
      <td> {$teacher.uid} </td>
      <td> {$teacher.cn} </td>
      <td> {$teacher.pwdclear} </td>
    </tr>
    {/foreach}
  </table>
  </div>

</div> 
{include file="footer.tpl"}
