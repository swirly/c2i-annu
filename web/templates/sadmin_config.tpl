{include file="header.tpl"}
<div class="formbox">
  <form action="index.php" method="post">
  <input type="hidden" name="page" value="config" />
  <input type="hidden" name="action" value="config_modify" />

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}

<div class="formdata">
  <table>
    <theader>
      <tr>
	<th> Paramètre </th>
	<th> Valeur actuelle</th>
	<th> Nouvelle valeur </th>
      </tr>
    </theader>
    <tbody>
      {foreach from=$params item=param}
      <tr>
	<td> <b> {$param.name} </b> </td>
	<td> {$param.value}
	<td> <input type="text" name="{$param.var}" value="{$param.value}" /> </td>
      </tr>
      {/foreach}
    </tbody>
  </table>

  <h3> Gestion des élèves par les administrateurs locaux </h3>
  
  <input type="checkbox" name="pupil_can_import" {$pupil_can_import_checked}> Import des élèves par les administrateurs locaux </input>
  <br>
  <input type="checkbox" name="pupil_can_select" {$pupil_can_select_checked}> Sélection des élèves par les administrateurs locaux </input>
  

</div>
<div class="formbuttons">
  <input type="submit" value="Modifier les paramètres." />
</div>
</div>
</form>

{include file="footer.tpl"}
