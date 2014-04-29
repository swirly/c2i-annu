{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Récupération d' étudiants </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form class="form-inline" enctype="multipart/form-data" action="index.php" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
        <input type="hidden" name="page" value="config" />
        <input type="hidden" name="action" value="confirm_ldap_recover_lost_ine" />

        <div class="alert alert-info text-center">
          <h2> import de fichier </h2>
          <p> Le fichier a importer doit remplir les critères suivants :
            <ul>
              <li> être un fichier texte contenant un numéro INE par ligne </li>
              <li> le texte est encodé en utf-8 </li>
            </ul>
          </p>
        </div>

        <div class="text-center">
          <div class="form-group">
            <label for="ine_import_file">
              Fichier des &eacute;tablissement &agrave importer :
            </label>
            <input name="ine_import_file" type="file" />
          </div>
          <div class="clearfix"></div>
          <input type="submit" value="Envoyer le fichier" />
        </div>
      </form>
    </div>
  </div>
</div>
{include file="footer.tpl"}
