{include file="header.tpl"}
<div class="formbox">
  <form name='schoolform' action='index.php' method='post'>
  <input type='hidden' name='page' value='schools' />
  <input type='hidden' name='action' value='process' />
  {if  $school.rne neq ""}
  <input type='hidden' name='rne' value='{$school.rne}' />
  {/if}
<div class="formdata">
  
  <table>
    <tr>
      <td>
	RNE :
      </td>
      <td>
	{if  $school.rne eq ""}
	<input name="rne" type="text" />
	{else}
	{$school.rne}
	{/if}
      </td>
    </tr>
    <tr>
      <td>
	Type :
      </td>
      <td>
	<input name="type" type="text" value="{$school.type}"/>
      </td>
    </tr>
    <tr>
      <td>
	Nom :
      </td>
      <td>
	<input name="name" type="text" value="{$school.name}"/>
      </td>
    </tr>
    <tr>
      <td>
	Adresse :
      </td>
      <td>
	<input name="address" type="text" value="{$school.address}"/>
      </td>
    </tr>
    <tr>
      <td>
	BP :
      </td>
      <td> <input name="pob" type="text" value="{$school.pob}"/>
      </td>
    </tr>
    <tr>
      <td>
	Ville:
      </td>
      <td> <input name="city" type="text" value="{$school.city}"/>
      </td>
    </tr>
    <tr>
      <td>
	Code postal :
      </td>
      <td>
	<input name="postalcode" type="text" value="{$school.postalcode}"/>
      </td>
    </tr>
    <tr>
      <td>
	T&eacute;l&eacute;phone :
      </td>
      <td>
	<input name="phone" type="text" value="{$school.phone}"/>
      </td>
    </tr>
    <tr>
      <td>
	Fax :
      </td>
      <td>
	<input name="fax" type="text" value="{$school.fax}"/>
      </td>
    </tr>
    <tr>
      <td>
	Courriel :
      </td>
      <td>
	<input name="mail" type="text" value="{$school.mail}"/>
      </td>
    </tr>
  </table>
  
</div>
<div class="formbuttons">
  <input type="submit" value=" Envoyer " >
  <input type="reset" value=" Annuler">
</div>
</form>
</div>
{include file="footer.tpl"}
