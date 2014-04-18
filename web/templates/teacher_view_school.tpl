{include file="header.tpl"}
<div class="formbox">
  <p>
  Voici les données concernant l'établissement dans lequel vous exercez.
  Au cas ou ces données seraient erronées, envoyez un courriel
  à l'adresse électronique suivante :
  <div> {$c2imaster_mail} </div>
  </p>
<div class="formdata">
  <table>
    <tr><td> RNE : </td><td> {$school.rne} </td></tr>
    <tr>
      <td>
	Type :
      </td>
      <td>
	{$school.type}
      </td>
    </tr>
    <tr><td> Nom : </td><td> {$school.name} </td></tr>
    <tr><td> Adresse : </td><td> {$school.address} </td></tr>
    <tr><td> Boite Postale: </td><td>   {$school.pob} </td></tr>
    <tr><td> Code postal: </td><td>   {$school.postalcode} </td></tr>    
    <tr><td> Ville: </td><td> {$school.city} </td></tr>
    <tr><td> Téléphone: </td><td> {$school.phone}  </td></tr>
    <tr><td> Fax : </td><td> {$school.fax} </td></tr>
    <tr><td> COURRIEL: </td><td>  {$school.mail} </td></tr>
  </table>
  
</div>
</div>
{include file="footer.tpl"}
