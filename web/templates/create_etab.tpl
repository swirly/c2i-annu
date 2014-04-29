{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Création d'un établissement </h2>
  </div>
  <div class="row">
    <form>
    <table class="table table-nonfluid table-striped table-hover table-condensed">
        <tr><td> RNE : </td><td> <input name="RNE" type="text" > </td></tr>
        <tr><td> NOM : </td><td> <input name="etab-nom" type="text">  </td></tr>
        <tr><td> VILLE: </td><td> <input name="etab-ville" type="text">  </td></tr>
        <tr><td> CODE POSTAL: </td>    <td> <input name="etab-cp" type="text">  </td></tr>
        <tr><td> TELEPHONE: </td><td> <input name="etab-tel" type="text">  </td></tr>
        <tr><td> COURRIEL: </td><td> <input name="etab-courriel" type="text">  </td></tr>
      </table>

      <div class="text-center">
        <input type="submit" value=" Envoyer "/>
        <input type="reset" value=" Annuler"/>
      </div>
    </form>
  </div>
</div>
{include file="footer.tpl"}
