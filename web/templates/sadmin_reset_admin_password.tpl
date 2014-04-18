{include file="header.tpl"}
<div class="formbox">

{if $error neq  ""}
<div class="error">
  {$error}
</div>
{/if}

Voici la liste des mots de passe réinitialisés.<br>
Sauvegardez cette page ou imprimez là. <br>

<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Nouveau mot de passe</th>
      </tr>
    </thead>
    {foreach  from=$admins item=admin}
    <tr>
      <td> {$admin.uid} </td>
      <td> {$admin.cn} </td>
      <td> {$admin.pwdclear} </td>
    </tr>
    {/foreach}
  </table>
</div>
</div> 
{include file="footer.tpl"}
