{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Récupération d' &eacute;tudiant </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">

      <form name='pupilform' action='index.php' method='post'>
        <input type='hidden' name='page' value='pupils' />
        <input type='hidden' name='action' value='recover_pupil_from_ine_confirm' />


        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <tr>
            <td>
              INE :
            </td>
            <td>
              <input name="ine" type="text" value="{$ine}" />
            </td>
          </tr>
        </table>


        <div class="text-center">
          <input type="submit" value=" Envoyer " />
          <input type="reset" value=" Annuler" />
        </div>
      </form>
    </div>
  </div>
</div>
{include file="footer.tpl"}
