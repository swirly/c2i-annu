{include file="header.tpl"}
<div class="container">
  <form name='trashlist' action='index.php' method='post'>
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='uid' value='none'/>
  <input type='hidden' name='section' value='{$section}'/>
  <div class="text-center">
 <h2> Liste des élèves qui ne sont pas inscrits.</h2>
 </div>
  <table class="table table-nonfluid table-striped table-hover">
    <thead>
      <tr>
	<th> <img src="images/ok.png" onclick="checkAll(document.trashlist)"></img>
	  <img src="images/no_24.png" onclick="unCheckAll(document.trashlist)"></img>
	</th>
	<th> Identifiant</th>
	<th> Nom </th>
	<th> Pr&eacute;nom</th>
	<th> INE </th>
	<th> Division </th>
	<th> </th>
      </tr>
    </thead>
    {foreach  from=$trashed item=pupil}
    <tr>
      <td> <input type="checkbox" name="trashed[]" value="{$pupil.uid}" /> </td>
      <td> {$pupil.uid} </td>
      <td> {$pupil.name} </td>
      <td> {$pupil.firstname} </td>
      <td> {$pupil.ine} </td>
      <td> {$pupil.section} </td>
      <td>
	<img src='images/reload_24.png' width='24' height='24' title='recharger' {$pupil.reload_link} />
      </td>
    </tr>
    {/foreach}
  </table>

<div class="text-center">
  <button class="btn btn-primary" {$reload_link} > 
  <i class="fa fa-refresh fa-2x" style="vertical-align:middle;"></i>
    &nbsp; Récupérer les élèves sélectionnés. 
  </button>
</div>
</form>
</div> 

{include file="footer.tpl"}
