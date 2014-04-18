{include file="header.tpl"}
<div class="formbox">
  <form enctype="multipart/form-data" action="index.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
  <input type="hidden" name="page" value="schools" />
  <input type="hidden" name="action" value="process_import" />

{if $error_message neq  ""}
<div class="error">
  {$error_message}
</div>
{/if}


<div class="formhelp">
  <h2> import de fichier </h2>
  <p> Le fichier a importer doit remplir les critères suivants :
  <ul>
    <li> être un fichier CSV contenant un établissement par ligne </li>
    <li> le séparateur est le point virgule </li>
    <li> il n'y a pas de caractère entourant le texte </li>
    <li> le texte est encodé en utf-8 </li>
    <li> contenir une ligne d'entête qui indique les champs </li>
  </ul>
  </p>
  <p>
  les champs à renseigner pour chaque établissement sont les suivante
  (bien respecter la casse) :
  <table>
    <thead>
      <tr>
	<th> entête </th>
	<th> champs </th>
      </tr>
    </thead>
    <tr>
      <td>RNE</td>
      <td> code RNE de l'établissement </td>
    </tr>
    <tr>
      <td> type </td>
      <td> type d'établissement (LG, LGT, LP) </td>
    </tr>
    <tr>
      <td> nom </td>
      <td> Le nom courant de l'établissement </td>
    </tr>
    <tr>
      <td> adresse </td>
      <td> l'adresse postale </td>
    </tr>
    <tr>
      <td> codepostal </td>
      <td> Le code postal </td>
    </tr>
    <tr>
      <td> ville </td>
      <td> Ville ou se trouve l'établissement </td>
    </tr>
    <tr>
      <td> telephone </td>
      <td> numéro de téléphone </td>
    </tr>
    <tr>
      <td> BP </td>
      <td> L'éventuelle boite postale </td>
    </tr>
    <tr>
      <td> fax </td>
      <td> le numéro de fax</td>
    </tr>
    <tr>
      <td> mail </td>
      <td> l'adresse de courriel </td>
    </tr>
  </table>     
</div>

<div class="formdata">
  Fichier des &eacute;tablissement &agrave importer :
  <input name="schools_import_file" type="file" />
</div>
<div class="formbuttons">
  <input type="submit" value="Envoyer le fichier" />
</div>
</div>
</form>

{include file="footer.tpl"}
