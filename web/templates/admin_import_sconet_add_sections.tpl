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
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admin' />
  <input type='hidden' name='action' value='' />
  Les sections suivantes ne sont pas encore existantes
  et figurent dans le fichier d'import. Vous pouvez créer ces sections
  en cochant la case de cr&eacute;ation.
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
      <td> <input type='checkbox' name='sections[]' value='{$section.name}'>
	</input>
      </td>
    </tr>
    {/foreach}
  </table>
</div>

<div class="formbuttons">

  <img src='images/yes_24.png' width='24' height='24' title='Cr&eacute;er' {$create_link} />
  Valider.
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler.
</div>
</form>
</div> 
{include file="footer.tpl"}
