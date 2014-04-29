{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Liste des &eacute;tudiants </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='pupilslist' action='index.php' method='post'>
        <input type='hidden' name='page' value='none' />
        <input type='hidden' name='action' value='none' />
        <input type='hidden' name='uid' value='none'/>
        <input type='hidden' name='section' value=''/>

        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th> Identifiant</th>
              <th> Nom </th>
              <th> Pr&eacute;nom</th>
              <th> INE </th>
              <th> Division </th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
            {foreach  from=$pupils item=pupil}
            <tr>
              <td> {$pupil.uid} </td>
              <td> {$pupil.name} </td>
              <td> {$pupil.firstname} </td>
              <td> {$pupil.ine} </td>
              <td> {$pupil.section} </td>
              <td>
                <img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser le mot de passe' {$pupil.reset_pwd_link} />
                <img src='images/look_24.png' width='24' height='24' title='d&eacute;tails' {$pupil.edit_link} />
              </td>
            </tr>
            {/foreach}
          </tbody>
        </table>
        <div class="text-center">
          <img src='images/password_24.png' width='24' height='24' title='r&eacute;initialiser tous les mots de passe' {$reset_all_pwd_link} />
          R&eacute;initialiser tous les mots de passe.
        </div>
      </form>
    </div> 
  </div>
</div>
{include file="footer.tpl"}
