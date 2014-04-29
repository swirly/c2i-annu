{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Récupération d' &eacute;tudiant </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='pupilform' action='index.php' method='post'>
        <input type='hidden' name='page' value='pupils' />
        <input type='hidden' name='action' value='recover_pupil_from_ine_process' />
        <input type='hidden' name='ine' value='{$ine}' />

        <div class="text-center">
          L'INE que vous avez fourni correspond &agrave; l'&eacute;l&egrave;ve suivant <br>
          Confirmez le choix pour la r&eacute;cup&eacute;ration.
          <table class="table table-nonfluid table-striped table-hover table-condensed">
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
    <input type="submit" value=" Envoyer " />
    <input type="reset" value=" Annuler" />
  </div>
</form>
</div>
</div>
</div>
{include file="footer.tpl"}
