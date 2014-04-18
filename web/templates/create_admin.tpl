{include file="header.tpl"}
<div class="formbox">
  <form name='adminform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admins' />
  <input type='hidden' name='action' value='process' />
  {if  $admin.uid neq ""}
  <input type='hidden' name='uid' value='{$admin.uid}' />
  {/if}
  <input type='hidden' name='type' value='admin' />
<div class="formdata">
  
  <table>
    {if $admin.uid neq ""}
    <tr>
      <td> Identifiant </td>
      <td> {$admin.uid} </td>
    </tr>    
    {/if}
    <tr>
      <td>
	Civilit&eacute; :
      </td>
      <td>
	<input name="title" type="text" value="{$admin.title}" />
      </td>
    </tr>
    <tr>
      <td>
	Nom :
      </td>
      <td>
	<input name="name" type="text" value="{$admin.name}" />
      </td>
    </tr>
    <tr>
      <td>
	Pr&eacute;nom :
      </td>
      <td>
	<input name="firstname" type="text" value="{$admin.firstname}" />
      </td>
    </tr>
    <tr>
      <td>
	Courriel :
      </td>
      <td>
	<input name="mail" type="text" value="{$admin.mail}" />
      </td>
    </tr>
    <tr>
      <td>
	T&eacute;l&eacute;phone :
      </td>
      <td>
	<input name="phone" type="text" value="{$admin.phone}"/>
      </td>
    </tr>
    <tr>
      <td>
	RNE:
      </td>
      <td>
	<input name="rne" type="text" value="{$admin.rne}" />
      </td>
    </tr>
  </table>  
</div>
<div class="formdata">
  <table>
    <theader>
      <tr><th> Nouveau mot de passe (optionnel) </th></tr>
    </theader>
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
