{include file="header.tpl"}
<div class="formbox">
  <form enctype="multipart/form-data" action="index.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="900000" />
  <input type="hidden" name="page" value="admin" />
  <input type="hidden" name="action" value="process_sconet_import" />

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}


<div class="formhelp">
  <h2> import de fichier </h2>
  <p> Afin de créer les comptes des élèves sur la plateforme C2I,
  vous devez fournir le fichier "ElevesSAnsAdresses.xml" issu de SCONET
  sous sa forme compressée.
  </p>
</div>

<div class="formdata">
  Fichier des &eacute;l&egrave;ves &agrave importer :
  <input name="sconet_import_file" type="file" />
</div>
<div class="formbuttons">
  <input type="submit" value="Envoyer le fichier" />
</div>
</div>
</form>

{include file="footer.tpl"}
