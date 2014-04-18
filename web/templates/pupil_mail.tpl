{include file="header.tpl"}

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}

<div class="formbox">
  <form name='pupilvalid' action='index.php' method='post'>
  <input type='hidden' name='page' value='pupil' />
  <input type='hidden' name='action' value='process_mail' />
  <input type='hidden' name='uid' value='{$pupil.uid}' />
<div class="formdata">
  <div class="formhelp">
    Vous pouvez fournir votre adresse de courrier électronique pour recevoir les
    ouvertures de QCM par courriel.
  </div>
  <table>
    <tr>
      <td> Adresse courriel enregistrée : </td>
      <td> {$pupil.mail} </td>
    </tr>    
    <tr>
      <td>
	Adresse de courriel :
      </td>
      <td>
	<input name="mail" type="text" value="" />
      </td>
    </tr>
  </table>
  
</div>
<div class="formbuttons">
  <input type="reset" value=" Annuler">
  <input type="submit" value=" Envoyer " >
</div>
</form>
</div>
{include file="footer.tpl"}
