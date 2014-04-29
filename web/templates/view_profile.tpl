{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Profil </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='adminform' action='index.php' method='post'>
        <input type='hidden' name='page' value='admins' />
        <input type='hidden' name='action' value='process' />
        {if  $admin.uid neq ""}
        <input type='hidden' name='uid' value='{$admin.uid}' />
        {/if}
        <input type='hidden' name='type' value='admin' />

        <table class="table table-nonfluid table-striped table-hover table-condensed">
          {if $admin.uid neq ""}
          <tr>
            <td> Identifiant </td>
            <td> {$admin.uid} </td>
          </tr>    
          {/if}
          <tr>
            <td>
              Civilit&eacute; :
            </td>
            <td>
              <input name="title" type="text" value="{$admin.title}" />
            </td>
          </tr>
          <tr>
            <td>
              Nom :
            </td>
            <td>
              <input name="name" type="text" value="{$admin.name}" />
            </td>
          </tr>
          <tr>
            <td>
              Pr&eacute;nom :
            </td>
            <td>
              <input name="firstname" type="text" value="{$admin.firstname}" />
            </td>
          </tr>
          <tr>
            <td>
              Courriel :
            </td>
            <td>
              <input name="mail" type="text" value="{$admin.mail}" />
            </td>
          </tr>
          <tr>
            <td>
              T&eacute;l&eacute;phone :
            </td>
            <td>
              <input name="phone" type="text" value="{$admin.phone}"/>
            </td>
          </tr>
          <tr>
            <td>
              RNE:
            </td>
            <td>
              <input name="rne" type="text" value="{$admin.rne}" />
            </td>
          </tr>
        </table>  

        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <theader>
            <tr><th colspan="2"> Nouveau mot de passe </th></tr>
          </theader>
          <tbody>
            <tr> <td>
              <input name="password" type="text" value=""/>
            </td></tr>
          </tbody>
        </table>
        <div class="text-center">
          <input type="submit" value=" Envoyer " >
          <input type="reset" value=" Annuler">
        </div>
      </form>
    </div>
  </div>
</div>
{include file="footer.tpl"}
