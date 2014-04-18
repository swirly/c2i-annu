{include file="header.tpl"}
<div class="formbox">
  Les sections déjà présentes dans votre établissement sont les suivantes :
  <div class="formdata">
  <table>
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
</form>
</div>

<div class="formbox">
  Les sections suivantes ne sont pas encore existantes
  et figurent dans le fichier d'import. Vous pouvez créer ces sections
  en cliquant sur valider, ou vous pouvez annuler l'import et retraiter
  votre fichier pour faire correspondre les noms de sections
  aux sections existantes.
<div class="formdata">
  <table>
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
      <td> {$section.description} </td>
    </tr>
    {/foreach}
  </table>
</div>
</div>
<div class="formbuttons">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admin' />
  <input type='hidden' name='action' value='' />

  <img src='images/yes_24.png' width='24' height='24' title='Cr&eacute;er' {$create_link} />
  Créer les sections.
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler.
  </div>
</div>
</form>
</div> 
{include file="footer.tpl"}
