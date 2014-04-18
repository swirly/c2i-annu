{include file="header.tpl"}
<div class="formbox">
Voici les données vous concernant qui figurent dans l'annuaire. En cas d'erreur, vous pouvez contacter le responsable du C2I dans votre établissement.
<div class="formdata">  
  <table>
    <tr>
      <td> Identifiant </td>
      <td> {$teacher.uid} </td>
    </tr>    
    <tr>
      <td>
	Civilit&eacute; :
      </td>
      <td>
	{$teacher.title}
      </td>
    </tr>
    <tr>
      <td>
	Nom :
      </td>
      <td>
	{$teacher.name}
      </td>
    </tr>
    <tr>
      <td>
	Pr&eacute;nom :
      </td>
      <td>
	{$teacher.firstname}
      </td>
    </tr>
    <tr>
      <td>
	Courriel :
      </td>
      <td>
	{$teacher.mail}
      </td>
    </tr>
    <tr>
      <td>
	T&eacute;l&eacute;phone :
      </td>
      <td>
	{$teacher.phone}
      </td>
    </tr>
    <tr>
      <td>
	RNE:
      </td>
      <td>
	{$teacher.rne}
      </td>
    </tr>
  </table>
  
</div>
</div>
{include file="footer.tpl"}
