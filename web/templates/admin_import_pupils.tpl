{include file="header.tpl"}
<div class="formbox">
  <form enctype="multipart/form-data" action="index.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
  <input type="hidden" name="page" value="admin" />
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
    <li> être un fichier CSV contenant un élèvé par ligne </li>
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
      <td>INE </td>
      <td> code INE de l'élève </td>
    </tr>
    <tr>
      <td> Sexe </td>
      <td> Le sexe de l'élève (M. ou Mlle) </td>
    </tr>
    <tr>
      <td> NOM  </td>
      <td> Nom de l'élève </td>
    </tr>
    <tr>
      <td> PRENOM </td>
      <td> Le prénom de l'élève </td>
    </tr>
    <tr>
      <td> RNE </td>
      <td> le RNE de l'établissement </td>
    </tr>
    <tr>
      <td> Date de naissance </td>
      <td> La date de naissance sur 10 caractères au format jj/mm/aaaa </td>
    </tr>
    <tr>
      <td> Division </td>
      <td> La classe de l'élève </td>
    </tr>
  </table>
</div>

<div class="formdata">
  Fichier des &eacute;tablissement &agrave importer :
  <input name="pupils_import_file" type="file" />
</div>
<div class="formbuttons">
  <input type="submit" value="Envoyer le fichier" />
</div>
</div>
</form>

{include file="footer.tpl"}
