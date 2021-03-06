{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Fiche enseignant </h2>
  </div>
  <div class="row">
    <form name='teacherform' action='index.php' method='post'>
      <input type='hidden' name='page' value='admin' />
      <input type='hidden' name='action' value='create_teacher_process' />
      {if  $teacher.uid neq ""}
      <input type='hidden' name='uid' value='{$teacher.uid}' />
      {/if}
      <input type='hidden' name='type' value='teacher' />
      <input type='hidden' name='rne' value='{$rne}' />
      <table class="table table-nonfluid table-striped table-hover table-condensed">
        {if $teacher.uid neq ""}
        <tr>
          <td> Identifiant </td>
          <td> {$teacher.uid} </td>
        </tr>    
        {/if}
        <tr>
          <td>
            Civilit&eacute; :
          </td>
          <td>
            <input name="title" type="text" value="{$teacher.title}" />
          </td>
        </tr>
        <tr>
          <td>
            Nom :
          </td>
          <td>
            <input name="name" type="text" value="{$teacher.name}" />
          </td>
        </tr>
        <tr>
          <td>
            Pr&eacute;nom :
          </td>
          <td>
            <input name="firstname" type="text" value="{$teacher.firstname}" />
          </td>
        </tr>
        <tr>
          <td>
            Courriel :
          </td>
          <td>
            <input name="mail" type="text" value="{$teacher.mail}" />
          </td>
        </tr>
        <tr>
          <td>
            T&eacute;l&eacute;phone :
          </td>
          <td>
            <input name="phone" type="text" value="{$teacher.phone}"/>
          </td>
        </tr>
      </table>  
      <table class="table table-nonfluid table-striped table-hover table-condensed">
        <theader>
          <tr>
            <th colspan="2"> 
              Nouveau mot de passe (optionnel)
            </th>
          </tr>
        </theader>
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
        <input type="submit" value=" Envoyer " />
        <input type="reset" value=" Annuler" />
      </div>
    </form>
  </div>
</div>
{include file="footer.tpl"}
