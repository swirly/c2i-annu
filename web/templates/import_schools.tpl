{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Import des  établissements </h2>
  </div>
  <div class="row">
    <form enctype="multipart/form-data" action="index.php" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="600000" />
      <input type="hidden" name="page" value="schools" />
      <input type="hidden" name="action" value="process_import" />
      <div class="alert alert-info">
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
        </p>
        <table class="table table-nonfluid table-striped table-hover table-condensed">
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

      <div class="row text-center">
        Fichier des &eacute;tablissement &agrave importer :
        <input name="schools_import_file" type="file" />
      </div>
      <div class="text-center">
        <button class="btn btn-primary" type="submit"> 
          Envoyer le fichier
        </button>
      </div>
    </form>
  </div>
</div>
{include file="footer.tpl"}
