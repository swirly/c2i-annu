{include file="header.tpl"}
<div class="formbox">
  <form enctype="multipart/form-data" action="index.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
  <input type="hidden" name="page" value="config" />
  <input type="hidden" name="action" value="process_ldap_synchronize" />

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}


<div class="formhelp">
  <h2> import de fichier </h2>
  <p> Le fichier a importer doit remplir les critères suivants :
  <ul>
    <li> être un fichier texte contenant un numéro INE par ligne </li>
    <li> le texte est encodé en utf-8 </li>
  </ul>
  </p>
  <p>
</div>

<div class="formdata">
  Fichier des &eacute;tablissement &agrave importer :
  <input name="ine_import_file" type="file" />
</div>
<div class="formbuttons">
  <input type="submit" value="Envoyer le fichier" />
</div>
</div>
</form>

{include file="footer.tpl"}
