{include file="header.tpl"}
<div class="formbox">
  <form name='passwordform' action='index.php' method='post'>
  <input type='hidden' name='page' value='people' />
  <input type='hidden' name='action' value='password_process' />
<div class="formdata">  
  <table>
    <tbody>
      <tr>
	<td>
	  Mot de passe
	</td>
	<td>
	  <input name="password" type="password" value=""/>
	</td>
      </tr>
      <tr>
	<td>
	  Vérification du mot de passe
	</td>
	<td>
	  <input name="passverif" type="password" value=""/>
	</td>
      </tr>
    </tbody>
  </table>
</div>
<div class="formbuttons">
  <input type="submit" value=" Envoyer " >
  <input type="reset" value=" Annuler">
</div>
</form>
</div>
{include file="footer.tpl"}
