{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Fiche &eacute;tudiant </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="alert alert-info text-center">
        Si vous constatez des informations erronnées dans cette fiche, veuillez contacter au plus vite votre enseignant responsable du passage du C2I.
        <br>
        Vous pouvez cependant saisir vous même votre adresse de messagerie électronique, afin de recevoir par courriel les convocations aux QCM.
        <br>
      </div>  
      <table class="table table-nonfluid table-striped table-hover table-condensed">
        <tr>
          <td> Identifiant </td>
          <td> {$pupil.uid} </td>
        </tr>    
        <tr>
          <td>
            Civilit&eacute; :
          </td>
          <td>
            {$pupil.title}
          </td>
        </tr>
        <tr>
          <td>
            Nom :
          </td>
          <td>
            {$pupil.name}
          </td>
        </tr>
        <tr>
          <td>
            Pr&eacute;nom :
          </td>
          <td>
            {$pupil.firstname}
          </td>
        </tr>
        <tr>
          <td>
            Adresse de courriel :
          </td>
          <td>
            {$pupil.mail}
          </td>
        </tr> 
        <tr>
          <td>
            Lieu de naissance :
          </td>
          <td>
            {$pupil.localisation}
          </td>
        </tr> 
        <tr>
          <td>
            Intitulé de section :
          </td>
          <td>
            {$pupil.section}
          </td>
        </tr>
        <tr>
          <td>
            RNE de l'établissement :
          </td>
          <td>
            {$pupil.rne}
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>
{include file="footer.tpl"}
