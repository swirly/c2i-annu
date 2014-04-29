{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Mot de passe des &eacute;tudiants </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='pupilslist' action='index.php' method='post' >
        <input type='hidden' name='page' value='none' />
        <input type='hidden' name='action' value='none' />
        <input type='hidden' name='section' value=''/>

        <div class="alert alert-info text-center">
          Voici la liste des mots de passe.<br>
          Sauvegardez cette page ou imprimez là. <br>
        </div>
        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th> Identifiant</th>
              <th> Nom </th>
              <th> Nouveau mot de passe</th>
            </tr>
          </thead>
          <tbody>
            {foreach  from=$pupils item=pupil}
            <tr>
              <td> {$pupil.uid} </td>
              <td> {$pupil.cn} </td>
              <td> {$pupil.pwdclear} </td>
            </tr>
            {/foreach}
          </tbody>
        </table>

        <div class="text-center">
          <button class="btn btn-primary" onclick="
          document.forms['pupilslist'].page.value='teacher';
          document.forms['pupilslist'].action.value='export_pwd_CSV';
          document.forms['pupilslist'].submit();	
          ">
          <i class="fa fa-list"></i>
          exporter la liste des élèves au format CSV
        </button>
      </div>
    </form>
  </div>
</div>
</div> 
{include file="footer.tpl"}
