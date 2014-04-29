{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Import des &eacute;tudiants (SCONET) </h2>
  </div>
  <div class="row">
    <form enctype="multipart/form-data" action="index.php" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="900000" />
      <input type="hidden" name="page" value="admin" />
      <input type="hidden" name="action" value="process_sconet_import" />

      <div class="alert alert-info">
        <p> Afin de créer les comptes des élèves sur la plateforme C2I,
          vous devez fournir le fichier "ElevesSAnsAdresses.xml" issu de SCONET <b>sous sa forme compressée.</b>
        </p>
      </div>

      <p>
        Fichier des &eacute;l&egrave;ves &agrave importer :
        <input name="sconet_import_file" type="file" />
      </p>
      <div class="text-center">
        <button class="btn btn-primary" type="submit"> 
        Envoyer le fichier
        </button>
      </div>
    </form>
  </div>
</div>
{include file="footer.tpl"}
