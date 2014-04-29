{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Fiche personnelle </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      Voici les données vous concernant qui figurent dans l'annuaire. En cas d'erreur, vous pouvez contacter le responsable du C2I dans votre établissement. 
      <table class="table table-nonfluid table-striped table-hover table-condensed">
        <tr>
          <td> Identifiant </td>
          <td> {$teacher.uid} </td>
        </tr>    
        <tr>
          <td>
            Civilit&eacute; :
          </td>
          <td>
            {$teacher.title}
          </td>
        </tr>
        <tr>
          <td>
            Nom :
          </td>
          <td>
            {$teacher.name}
          </td>
        </tr>
        <tr>
          <td>
            Pr&eacute;nom :
          </td>
          <td>
            {$teacher.firstname}
          </td>
        </tr>
        <tr>
          <td>
            Courriel :
          </td>
          <td>
            {$teacher.mail}
          </td>
        </tr>
        <tr>
          <td>
            T&eacute;l&eacute;phone :
          </td>
          <td>
            {$teacher.phone}
          </td>
        </tr>
        <tr>
          <td>
            RNE:
          </td>
          <td>
            {$teacher.rne}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
{include file="footer.tpl"}
