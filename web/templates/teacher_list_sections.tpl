{include file="header.tpl"}
<div class="container">
  <div class="page-header text-center">
    <h2> Liste des classes </h2>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <form name='sectionslist' action='index.php' method='post' >
        <input type='hidden' name='page' value='none' />
        <input type='hidden' name='action' value='none' />
        <input type='hidden' name='section' value=''/>

        <table class="table table-nonfluid table-striped table-hover table-condensed">
          <thead>
            <tr>
              <th> code classe </th>
              <th> classe </th>
              <th> description </th>
              <th> </th>
            </tr>
          </thead>
          <tbody>
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
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>

{include file="footer.tpl"}
