{include file="header.tpl"}
<div class="formbox">
  <form name='pupilslist' action='index.php' method='post' >
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='section' value=''/>

{if $error neq  ""}
<div class="error">
  {$error}
</div>
{/if}

Voici la liste des mots de passe.<br>
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
    {foreach  from=$pupils item=pupil}
    <tr>
      <td> {$pupil.uid} </td>
      <td> {$pupil.cn} </td>
      <td> {$pupil.pwdclear} </td>
    </tr>
    {/foreach}
  </table>
</div>
<div>
  <button onclick="
	document.forms['pupilslist'].page.value='teacher';
	document.forms['pupilslist'].action.value='export_pwd_CSV';
	document.forms['pupilslist'].submit();	
    ">
    exporter la liste des élèves au format CSV
    </button>
</div>
</form>
</div> 
{include file="footer.tpl"}
