{include file="header.tpl"}

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}

<div class="formbox">
  <form name='pupilvalid' action='index.php' method='post'>
  <input type='hidden' name='page' value='pupil' />
  <input type='hidden' name='action' value='process_validation' />
  <input type='hidden' name='uid' value='{$pupil.uid}' />
<div class="formdata">
  <div class="formhelp">
    Pour valider votre inscription au C2I, vous devez renseigner votre commune de naissance. Elle est indispensable pour l'établissement du diplome.<br>
    Ce lieu de naissance doit être écrit uniquement avec :
    <ul>
      <li> des lettres majuscules et minuscules <b> SANS ACCENTS </b> </li>
      <li> l'apostrophe </li>
      <li> des tirets de liaison - </li>
      <li> et éventuellement, si le pays d'origine n'est pas la France, des parenthèses pour entourer le pays </li>
    </ul>
    Par exemple  :
    <ul>
      <li> Grenoble </li>
      <li> Aix-en-Provence </li>
      <li> Dakar (Senegal) </li>
    </ul>
  </div>
  <table>
    <tr>
      <td> Lieu de naissance enregistré : </td>
      <td> {$pupil.localisation} </td>
    </tr>    
    <tr>
      <td>
	Lieu de naissance effectif :
      </td>
      <td>
	<input name="localisation" type="text" value="" />
      </td>
    </tr>
  </table>
  
</div>
<div class="formbuttons">
  <input type="reset" value=" Annuler">
  <input type="submit" value=" Envoyer " >
</div>
</form>
</div>
{include file="footer.tpl"}
