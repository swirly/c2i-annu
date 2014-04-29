{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Modification du mot de passe </h2>
  </div>
  <div class="row">
    <form name='passwordform' action='index.php' method='post'>
      <input type='hidden' name='page' value='people' />
      <input type='hidden' name='action' value='password_process' />
      <table class="table table-nonfluid table-striped table-hover table-condensed">
        <tbody>
          <tr>
            <td>
              Mot de passe
            </td>
            <td>
              <input name="password" type="password" value=""/>
            </td>
          </tr>
          <tr>
            <td>
              Vérification du mot de passe
            </td>
            <td>
              <input name="passverif" type="password" value=""/>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="text-center">
        <input type="submit" value=" Envoyer " >
        <input type="reset" value=" Annuler">
      </div>
    </form>
  </div>
</div>
{include file="footer.tpl"}
