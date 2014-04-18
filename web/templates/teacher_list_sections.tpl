{include file="header.tpl"}
<div class="formbox">
  <form name='sectionslist' action='index.php' method='post' >
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='section' value=''/>
<div class="formdata">
  <table>
    <thead>
      <tr>
	<th> code classe </th>
	<th> classe </th>
	<th> description </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$sections item=section}
    <tr>
      <td> {$section.code} </td>
      <td> {$section.name} </td>
      <td> {$section.description} </td>
      <td>
	<img src='images/magnify_24.png' width='24' height='24' title='&eacute;l&egrave;ves' {$section.list_link} />
      </td>
    </tr>
    {/foreach}
  </table>
</div>
</form>
</div>

{include file="footer.tpl"}
