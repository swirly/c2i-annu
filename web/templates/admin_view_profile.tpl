{include file="header.tpl"}
<div class="container">
  
  <table class="table table-striped table-nonfluid">
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
	{$admin.title}
      </td>
    </tr>
    <tr>
      <td>
	Nom :
      </td>
      <td>
	{$admin.name}
      </td>
    </tr>
    <tr>
      <td>
	Pr&eacute;nom :
      </td>
      <td>
	{$admin.firstname}
      </td>
    </tr>
    <tr>
      <td>
	Courriel :
      </td>
      <td>
	{$admin.mail}
      </td>
    </tr>
    <tr>
      <td>
	T&eacute;l&eacute;phone :
      </td>
      <td>
	{$admin.phone}
      </td>
    </tr>
    <tr>
      <td>
	RNE:
      </td>
      <td>
	{$admin.rne}
      </td>
    </tr>
  </table>

</div>
{include file="footer.tpl"}
