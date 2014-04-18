<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<meta http-equiv="Pragma" content="no-cache" />

<script type="text/javascript" src="include/jquery/jquery.pack.js"></script>
<script type="text/javascript" src="include/jquery/jquery-ui.min.js"></script>

<link rel="stylesheet" type="text/css" href="style/style.css">
<link rel="icon" type="image/png" href="images/favicon.png">

{literal}
<script language="javascript">
function checkAll(myform) {
  for (var i=0;i < myform.elements.length;i++) {
    if (myform.elements[i].type=="checkbox") {
      myform.elements[i].checked=true;
    }
  }
}
function unCheckAll(myform) {
  for (var i=0;i < myform.elements.length;i++) {
    if (myform.elements[i].type=="checkbox") {
      myform.elements[i].checked=false;
    }
  }
}
</script>
{/literal}

</head>
<body>
<div id="conteneur">
<div id="header">
  <h1>  {$header_title} </h1>
</div>
{if $user_type neq ""}
<div id="gauche">
  {if $user_type eq "admin"}
  {include file='admin-menu.tpl}
  {elseif $user_type eq "teacher"}
  {include file='teacher-menu.tpl}
  {elseif $user_type eq "sadmin" and $user_rne  neq "-1"}
  {include file='admin-menu.tpl'}
  {elseif $user_type eq "sadmin" and $user_rne eq "-1"}
  {include file='sadmin-menu.tpl'}
  {elseif $user_type eq "pupil" }
  {include file='pupil-menu.tpl'}
  {/if}  
</div>
{/if}
<div id="centre">
  { if isset($errormsg) }
  <div class="error">
    <h2> Erreur </h2>
    {foreach from=$errormsg item=msg}
    <div>
      {$msg}
    </div>
    {/foreach}
  </div>
  {/if}

  { if  isset($warningmsg) }
  <div class="warning">
    <h2> Attention ! </h2>
    {foreach from=$warningmsg item=msg}
    <div>
      {$msg}
    </div>
    {/foreach}
  </div>
  {/if}

  { if  isset($infomsg) }
  <div class="info">
    <h2> Attention ! </h2>
    {foreach from=$infomsg item=msg}
    <div>
      {$msg}
    </div>
    {/foreach}
  </div>
  {/if}

  {if isset($debug_infomsg) }
  <p>
  {literal}
  <button class="DebugButton\" onclick="if (document.getElementById('debug').style.display=='none'){document.getElementById('debug').style.display='block';} else {document.getElementById('debug').style.display='none';}">
  Informations de déverminage
  </button>
  </p>
  {/literal}
  <div class="debug" id="debug" style="display:none;">
    {foreach from=$debug_infomsg item=msg}
    <div>
      {$msg}
    </div>
    {/foreach}
  </div>
  {/if}
  {if $message neq ""}
  <div class="message">
    {$message}
  </div>
  {/if}