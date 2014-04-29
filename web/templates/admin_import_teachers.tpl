{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Import des enseignants </h2>
  </div>
  <div class="row">
   
<div class="alert alert-info">
  <p> Le fichier a importer doit remplir les critères suivants :
  <ul>
    <li> être un fichier CSV contenant un enseignant par ligne </li>
    <li> le séparateur est le point virgule </li>
    <li> il n'y a pas de caractère entourant le texte </li>
    <li> le texte est encodé en utf-8 </li>
    <li> contenir une ligne d'entête qui indique les champs </li>
  </ul>
  </p>
  <p>
  les champs à renseigner pour chaque enseignant sont les suivants
  (bien respecter la casse) :
  </p>
  <table class="table table-nonfluid table-striped table-hover table-condensed">
    <thead>
      <tr>
	<th> entête </th>
	<th> champs </th>
      </tr>
    </thead>
    <tr>
      <td> SEXE </td>
      <td> Le sexe de l'enseignant (M., Mme ou Mlle) </td>
    </tr>
    <tr>
      <td> NOM  </td>
      <td> Nom de l'enseignant </td>
    </tr>
    <tr>
      <td> PRENOM </td>
      <td> Le prénom de l'enseignant </td>
    </tr>
    <tr>
      <td> RNE </td>
      <td> le RNE de l'établissement </td>
    </tr>
    <tr>
      <td> MAIL </td>
      <td> L'adresse de courriel de l'enseignant </td>
    </tr>
  </table>
</div>
</div>

<div class="row">
 <form enctype="multipart/form-data" action="index.php" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
  <input type="hidden" name="page" value="admin" />
  <input type="hidden" name="action" value="import_teachers_process" />

<p>
  Fichier des enseignants &agrave importer :
  <input name="teachers_import_file" type="file" />
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
