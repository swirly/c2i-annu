{include file="header.tpl"}
<div class="formbox">
  {if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}

  Voici la liste des élèves ajoutés dont  les mots de passe ont été
  initialisés .
  Imprimez ou sauvegardez cette page pour  pouvoir donner
  la liste des mots de passe initiaux aux élèves.
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> Nom complet </th>
	<th> Login </th>
	<th> Mot de passe </th>
	<th> </th>
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


  Voici la liste des élèves dont les données ont été mises à jour.
  Leur mot de passe reste inchangé.
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> Nom complet </th>
	<th> Login </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$modified_list item=modified_item}
    <tr>
      <td> {$modified_item.cn} </td>
      <td> {$modified_item.uid} </td>
    </tr>
    {/foreach}
  </table>
</div>
</div>

{include file="footer.tpl"}
