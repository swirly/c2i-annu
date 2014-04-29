{include file="header.tpl"}
<div class="container">
<div class="page-header text-center">
<h2> &Eacute;dition de l'&eacute;l&egrave;ve </h2>
</div>
  <form name='pupilform' action='index.php' method='post'>
    <input type='hidden' name='page' value='admins' />
    <input type='hidden' name='action' value='process' />
    {if  $admin.uid neq ""}
    <input type='hidden' name='uid' value='{$pupil.uid}' />
    {/if}
    <input type='hidden' name='type' value='admin' />
    <div class="formdata">

      <table class="table table-nonfluid table-striped table-hover table-condensed">
        {if $pupil.uid neq ""}
        <tr>
          <td> Identifiant </td>
          <td> {$pupil.uid} </td>
        </tr>    
        {/if}
        <tr>
          <td>
           INE :
         </td>
         <td>
           {if $pupil.ine neq ""}
           {$pupil.ine}
           {else}	
           <input name="ine" type="text" value="" />
           {/if}
         </td>
       </tr>
       <tr>
        <td>
         Civilit&eacute; :
       </td>
       <td>
         <input name="title" type="text" value="{$pupil.title}" />
       </td>
       </tr>
       <tr>
          <td>
       Nom :
     </td>
     <td>
       <input name="name" type="text" value="{$pupil.name}" />
     </td>
   </tr>
   <tr>
    <td>
     Pr&eacute;nom :
   </td>
   <td>
     <input name="firstname" type="text" value="{$pupil.firstname}" />
   </td>
 </tr>
 <tr>
  <td>
   Courriel :
 </td>
 <td>
   <input name="mail" type="text" value="{$pupil.mail}" />
 </td>
</tr>
<tr>
  <td>
   T&eacute;l&eacute;phone :
 </td>
 <td>
   <input name="phone" type="text" value="{$pupil.phone}"/>
 </td>
</tr>
<tr>
  <td>
   RNE:
 </td>
 <td>
   <input name="rne" type="text" value="{$pupil.rne}" />
 </td>
</tr>
</table>

</div>
<div class="text-center">
  <input type="submit" value=" Envoyer " >
  <input type="reset" value=" Annuler">
</div>
</form>
</div>
{include file="footer.tpl"}
