{include file="header.tpl"}
<div class="formbox">
  <form name='pupilform' action='index.php' method='post'>
  <input type='hidden' name='page' value='pupils' />
  <input type='hidden' name='action' value='recover_pupil_from_ine_process' />
  <input type='hidden' name='ine' value='{$ine}' />
  
<div class="formdata">
  L'INE que vous avez fourni correspond &agrave; l'&eacute;l&egrave;ve suivant <br>
  Confirmez lz choix pour la r&eacute;cup&eacute;ration.
  <table>
    <tr>
      <td>
	INE : 
      </td>
      <td>
	{$pupil.ine}
      </td>
      </tr><tr>
      <td>
	Nom : 
      </td>
      <td>
	{$pupil.name}
      </td>
      </tr><tr>
      <td>
	Prénom :
      </td>
      <td>
	{$pupil.firstname}
      </td>
      </tr><tr>
      <td>
	identifiant :
      </td>
      <td> {$pupil.uid}
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
