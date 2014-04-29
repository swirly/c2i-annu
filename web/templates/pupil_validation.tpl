{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Validation</h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='pupilvalid' action='index.php' method='post'>
        <input type='hidden' name='page' value='pupil' />
        <input type='hidden' name='action' value='process_validation' />
        <input type='hidden' name='uid' value='{$pupil.uid}' />

        <div class="alert alert-info text-center">
        <div style="text-align:left;margin:auto;display:inline-block">
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
        </div>
        <table class="table table-nonfluid table-striped table-hover table-condensed">
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

        <div class="text-center">
          <input type="reset" value=" Annuler">
          <input type="submit" value=" Envoyer " >
        </div>
      </form>
    </div>
  </div>
</div>
{include file="footer.tpl"}
