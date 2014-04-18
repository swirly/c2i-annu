{include file="header.tpl"}
<div class="formbox">
  <form name='confirmform' action='index.php' method='post' enctype="multipart/form-data" >
  <input type='hidden' name='page' value='none' />
  <input type='hidden' name='action' value='none' />
  <input type='hidden' name='section' value='{$section}' />
<div class="formbuttons">
<div style="float:left;">
Exporter vers excel pour saisie des notes ...
 <img src='images/xls.png'  ALIGN="middle" width='24' height='24' title='Exporter' {$export_link}>
</div>
<div >
<div >Importer un fichier csv, g&eacute;n&eacute;r&eacute; &aring; partir de l'export , le s&eacute;parateur doit &ecirc;tre ";"</div>
<div style="text-align:center;">
<input type="file" name="fichier" style="text-align:center;">
<img src='images/yes_24.png' ALIGN="top"  width='24' height='24' title='Importer'{$import_link}>
</div>
</div>
</div>
<div class="formbuttons">
 <img src='images/warning.gif' width='24' height='21'/>
Attention, importation des copies obligatoire.

<a href="http://tice-ead.upmf-grenoble.fr/c2i-annu/index.php?section={$section}">Importation des copies</a>
</div>
<div class="formdata">
  <table border="0">
<thead>
<tr>
<th>Nom</th>
<th>Prenom</th>

<th>B1</th>
<th>B2</th>
<th>B3</th>
<th>B4</th>
<th>B5</th>
<th>B6</th>
<th>B7</th>
</tr>
</thead>
<tbody>

{foreach from=$info item=pupils}
<tr>
<td >{$pupils.name}</td>
<td>{$pupils.firstname}</td>
{assign var=ine value=$pupils.ine}

<td><input name="note[{$pupils.ine}][b1]" type="text" size="2" value="{$tab_load_note.$ine.b1}"></td>
<td><input name="note[{$pupils.ine}][b2]" type="text" size="2" value="{$tab_load_note.$ine.b2}"></td>
<td><input name="note[{$pupils.ine}][b3]" type="text" size="2" value="{$tab_load_note.$ine.b3}"></td>
<td><input name="note[{$pupils.ine}][b4]" type="text" size="2" value="{$tab_load_note.$ine.b4}"></td>
<td><input name="note[{$pupils.ine}][b5]" type="text" size="2" value="{$tab_load_note.$ine.b5}"></td>
<td><input name="note[{$pupils.ine}][b6]" type="text" size="2" value="{$tab_load_note.$ine.b6}"></td>
<td><input name="note[{$pupils.ine}][b7]" type="text" size="2" value="{$tab_load_note.$ine.b7}"></td>
</tr>
 {/foreach}



</tbody>
</table>

</div>
</div>

<div class="formbuttons">

  <img src='images/yes_24.png' width='24' height='24' title='Cr&eacute;er' {$valid_link} />
  Valider.
  <img src='images/no_24.png' width='24' height='24' title='Annuler' {$cancel_link} />
  Annuler.
</div>
</form>
</div> 
{include file="footer.tpl"}
