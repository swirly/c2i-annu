{include file="header.tpl"}
<div class="formbox">
  <form name='sectioncreate' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <table>
    <tr>
      <td> classe </td>
      <td> {$section} </td>
    </tr>
    <tr>
      <td> description </td>
      <td>
	<input name='description' type='text' value='{$description}' />
      </td>
    </tr>
  </table>
  <div class="formbuttons">
  <img  src='images/new_section_48.png' width='48' height='48' title='Modifier la classe'  {$modify_link} />
  Modifier la classe.
  </div>
  </form>
</div>
{include file="footer.tpl"}
