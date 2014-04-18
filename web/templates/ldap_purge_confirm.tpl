{include file="header.tpl"}
<div class="formbox">
  <form name='confirmform' action='index.php' method='post'>
  <input type='hidden' name='page' value='admins' />
  <input type='hidden' name='action' value='' />
  <input type='hidden' name='uid' value='{$admin.uid}' />

<div class="formdata">

<div class="formbuttons">

  Confirmez vous la purge de l'annuaire ? <br>
  
  <img src='images/yes_24.png' width='24' height='24' title='Supprimer' {$purge_link} />
  Supprimer
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler
</div>
</form>
</div>
{include file="footer.tpl"}
