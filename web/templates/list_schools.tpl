{include file="header.tpl"}
<div class="formbox">
  <form name='schoolslist' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='rne' value='none'/>
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th>RNE</th>
	<th> Type </th>
	<th>Nom</th>
	<th>Ville</th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$schools item=school}
    <tr>
      <td> {$school.rne} </td>
      <td> {$school.type} </td>
      <td> {$school.name} </td>
      <td> {$school.city} </td>
      <td>
	<img src='images/edit_24.png' width='24' height='24' title='prendre le controle' {$school.control_link} />
	<img src='images/look_24.png' width='24' height='24' title='d&eacute;tails' {$school.edit_link} />
	<img src='images/bin_24.png' width='24' height='24' title='supprimer' {$school.delete_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
<div class="formbuttons">
    <img src='images/new_school_24.png' width='24' height='24' title='Nouvel &eacute;tablissement'  {$create_link} />
  Nouvel &eacute;tablissement.
</div>
</form>
</div> 
{include file="footer.tpl"}
