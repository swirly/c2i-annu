{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Import des &eacute;tudiants </h2>
  </div>
  <div class="row">
  <p>
  Les sections déjà présentes dans votre établissement sont les suivantes :
  </p>
  <table class="table table-nonfluid table-striped table-hover table-condensed">
    <thead>
      <tr>
	<th> code classe </th>
	<th> classe </th>
	<th> description </th>
      </tr>
    </thead>
    {foreach  from=$old_section_list item=section}
    <tr>
      <td> {$section.code} </td>
      <td> {$section.name} </td>
      <td> {$section.description} </td>
    </tr>
    {/foreach}
  </table>
</div>

<div class="row">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admin' />
  <input type='hidden' name='action' value='' />
  <p>
  Les sections suivantes ne sont pas encore existantes
  et figurent dans le fichier d'import. Vous pouvez créer ces sections
  en cochant la case de cr&eacute;ation.
  </p>
  <table class="table table-nonfluid table-striped table-hover table-condensed">
    <thead>
      <tr>
	<th> code classe </th>
	<th> classe </th>
	<th> description </th>
      </tr>
    </thead>
    {foreach  from=$new_section_list item=section}
    <tr>
      <td> {$section.code} </td>
      <td> {$section.name} </td>
      <td> <input type='checkbox' name='sections[]' value='{$section.name}'/>
      </td>
    </tr>
    {/foreach}
  </table>

<div class="text-center">

  <img src='images/yes_24.png' width='24' height='24' title='Cr&eacute;er' {$create_link} />
  Valider.
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler.
</div>
</form>
</div> 
{include file="footer.tpl"}
