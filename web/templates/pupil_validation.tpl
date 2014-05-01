{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Validation</h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
        <input type='hidden' name='page' value='pupil' />
        <input type='hidden' name='action' value='process_validation' />
        <input type='hidden' name='uid' value='{$pupil.uid}' />

        <div class="alert alert-info text-center">
        <div style="text-align:left;margin:auto;display:inline-block">
          Pour valider votre inscription au C2I, vous devez vérifier votre commune de naissance. Elle est indispensable pour l'établissement du diplome.<br/>

          Votre lieu de naissance enregistré est actuellement <b>{$pupil.localisation} </b> <br/>

          En cas d'erreur sur votre lieu de naissance, il faut le signaler à la personne responsable du C2I dans votre établissement qui devra faire corriger les informations.
          </div>
        </div>

    </div>
  </div>
</div>
{include file="footer.tpl"}
