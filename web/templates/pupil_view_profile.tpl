{include file="header.tpl"}
<div class="formbox">
<div class="formhelp">
    Si vous constatez des informations erronnées dans cette fiche, veuillez contacter au plus vite votre enseignant responsable du passage du C2I.
  <br>
  Vous pouvez cependant saisir vous même votre adresse de messagerie électronique, afin de recevoir par courriel les convocations aux QCM.
  <br>
  Vous devez saisir vous même la commune de naissance dans la partie <b>VALIDATION</b> du menu. C'est <b>indispensable</b>  pour pouvoir obtenir le diplome.
</div>
<div class="formdata">  
  <table>
    <tr>
      <td> Identifiant </td>
      <td> {$pupil.uid} </td>
    </tr>    
    <tr>
      <td>
	Civilit&eacute; :
      </td>
      <td>
	{$pupil.title}
      </td>
    </tr>
    <tr>
      <td>
	Nom :
      </td>
      <td>
	{$pupil.name}
      </td>
    </tr>
    <tr>
      <td>
	Pr&eacute;nom :
      </td>
      <td>
	{$pupil.firstname}
      </td>
    </tr>
    <tr>
      <td>
	Adresse de courriel :
      </td>
      <td>
	{$pupil.mail}
      </td>
    </tr> 
    <tr>
      <td>
	Lieu de naissance :
      </td>
      <td>
	{$pupil.localisation}
      </td>
    </tr> 
    <tr>
      <td>
	Intitulé de section :
      </td>
      <td>
	{$pupil.section}
      </td>
    </tr>
    <tr>
      <td>
	RNE de l'établissement :
      </td>
      <td>
	{$pupil.rne}
      </td>
    </tr>
  </table>
</div>
</div>
{include file="footer.tpl"}
