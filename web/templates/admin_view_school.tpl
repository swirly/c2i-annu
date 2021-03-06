{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> &Eacute;tablissement : {$school.name} </h2>
  </div>
  <div class="row">
  <div class="col-md-8 col-md-offset-2 alert alert-info">
  <p>
    Voici les données concernant l'établissement pour lequel vous gérez
    les inscriptions au C2I1.
    Au cas ou ces données seraient erronées, envoyez un courriel
    à l'adresse électronique suivante :
    <div> {$c2imaster_mail} </div>
  </p>
  </div>
  </div>
  <div class="formdata">
    <table class="table table-striped table-nonfluid">
      <tr><td> RNE : </td><td> {$school.rne} </td></tr>
      <tr>
        <td>
         Type :
       </td>
       <td>
         {$school.type}
       </td>
     </tr>
     <tr><td> Nom : </td><td> {$school.name} </td></tr>
     <tr><td> Adresse : </td><td> {$school.address} </td></tr>
     <tr><td> Boite Postale: </td><td>   {$school.pob} </td></tr>
     <tr><td> Code postal: </td><td>   {$school.postalcode} </td></tr>    
     <tr><td> Ville: </td><td> {$school.city} </td></tr>
     <tr><td> Téléphone: </td><td> {$school.phone}  </td></tr>
     <tr>
      <td>
       Fax :
     </td>
     <td>
       {$school.fax}
     </td>
   </tr>
     <tr><td> COURRIEL: </td><td>  {$school.mail} </td></tr>
    </table>

  </div>
</div>
{include file="footer.tpl"}
