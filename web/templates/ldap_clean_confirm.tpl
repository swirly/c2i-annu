{include file="header.tpl"}
<div class="container">
	<div class="page-header text-center">
		<h2> Bascule de l'annuaire </h2>
	</div>
	<div class="row">
		<form name='confirmform' action='index.php' method='post'>
			<input type='hidden' name='page' value='admins' />
			<input type='hidden' name='action' value='' />
			<input type='hidden' name='uid' value='{$admin.uid}' />
			<div class="text-center col-md-8 col-md-offset-2">
				Confirmez vous la bascule de l'annuaire ? 
			</div>
			<div class="clearfix"></div>
			<div class="text-center">
				<img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$purge_link} />
				Supprimer
				<img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
				Annuler
			</div>
		</form>
	</div>
</div>
{include file="footer.tpl"}
