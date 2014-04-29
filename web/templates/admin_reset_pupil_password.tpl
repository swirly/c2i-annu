{include file="header.tpl"}
<div class="container">
  <form name='pupilslist' action='index.php' method='post' >
    <input type='hidden' name='page' value='none' />
    <input type='hidden' name='action' value='none' />
    <input type='hidden' name='section' value=''/>
    <div class="text-center">
      <div class="alert alert-info" style="display:inline-block;">

      Voici la liste des mots de passe réinitialisés.<br>
      Sauvegardez cette page ou imprimez là. <br>
      </div>
    </div>
    <table class="table table-striped table-nonfluid">
      <thead>
        <tr>
         <th> Identifiant</th>
         <th> Nom </th>
         <th> Nouveau mot de passe</th>
       </tr>
     </thead>
     {foreach  from=$pupils item=pupil}
     <tr>
      <td> {$pupil.uid} </td>
      <td> {$pupil.cn} </td>
      <td> {$pupil.pwdclear} </td>
    </tr>
    {/foreach}
  </table>

  <div class="text-center">
    <button class="btn btn-primary" onclick="
    document.forms['pupilslist'].page.value='admin';
    document.forms['pupilslist'].action.value='export_pwd_CSV';
    document.forms['pupilslist'].submit();	
    ">
    exporter la liste des élèves au format CSV
  </button>
</div>
</form>
</div> 
{include file="footer.tpl"}
