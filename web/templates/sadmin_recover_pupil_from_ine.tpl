{include file="header.tpl"}
<div class="formbox">
  <form name='pupilform' action='index.php' method='post'>
  <input type='hidden' name='page' value='pupils' />
  <input type='hidden' name='action' value='recover_pupil_from_ine_confirm' />

<div class="formdata">
    <table>
    <tr>
      <td>
	INE :
      </td>
      <td>
	<input name="ine" type="text" value="{$ine}" />
      </td>
    </tr>
  </table>
  
</div>
<div class="formbuttons">
  <input type="submit" value=" Envoyer " />
  <input type="reset" value=" Annuler" />
</div>
</form>
</div>
{include file="footer.tpl"}
