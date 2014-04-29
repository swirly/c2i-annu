{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> &Eacute;dition d'une classe </h2>
  </div>
  <form name='sectioncreate' action='index.php' method='post'>
    <input type='hidden' name='page' value='none' />
    <input type='hidden' name='action' value='none' />
    <table class="table table-nonfluid table-striped table-hover table-condensed">
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
   <div class="text-center">
    <img  src='images/new_section_48.png' width='48' height='48' title='Modifier la classe'  {$modify_link} />
    Modifier la classe.
  </div>
</form>
</div>
{include file="footer.tpl"}
