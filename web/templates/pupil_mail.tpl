{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Adresse de courriel </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='pupilvalid' action='index.php' method='post'>
        <input type='hidden' name='page' value='pupil' />
        <input type='hidden' name='action' value='process_mail' />
        <input type='hidden' name='uid' value='{$pupil.uid}' />

        <div class="alert alert-info text-center">
          Vous pouvez fournir votre adresse de courrier électronique pour recevoir les
          ouvertures de QCM par courriel.
        </div>
        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <tr>
            <td> Adresse courriel enregistrée : </td>
            <td> {$pupil.mail} </td>
          </tr>    
          <tr>
            <td>
              Adresse de courriel :
            </td>
            <td>
              <input name="mail" type="text" value="" />
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
