{include file="header.tpl"}

<div class="formbox">
  <form name="login" method="post" action="index.php">
  <input type="hidden" name="page" value="login">
  <input type="hidden" name="action" value="validate_login">

  <div class="formdata">
    <p> Bienvenue sur l'annuaire de la plateforme C2I.
    Veuillez vous identifier. </p>
    <table>
      <tr>
	<td> Identifiant </td>
	<td><input name="login" type="text"></input></td>
      </tr>
      <tr>
	<td> Mot de passe </td>
	<td><input name="password" type="password"></input></td>
      </tr>
    </table>
  </div>
  
  <div class="formbutton">
    <input type="submit"></input>
  </div>

  </form>
</div>

{include file="footer.tpl"}
