<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title>Annuaire C2i</title>
    <link rel="stylesheet" type="text/css" href="include/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="include/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="include/css/c2i.css">
    <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container_fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand">
                    <i class="fa fa-book fa-2x" style="vertical-align:middle;"></i>
                    Annuaire C2i1
                    </span>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <form name='menuform' action='index.php' method='post' enctype="multipart/form-data">
                        <input type='hidden' name='page' value='none' />
                        <input type='hidden' name='action' value='none' />

                        <ul class="nav navbar-nav navbar-nav">
                            {if $user_type neq ""} {if $user_type eq "admin"} {include file='admin-menu.tpl'} {elseif $user_type eq "teacher"} {include file='teacher-menu.tpl'} {elseif $user_type eq "sadmin" and $user_rne neq "-1"} {include file='admin-menu.tpl'} {elseif $user_type eq "sadmin" and $user_rne eq "-1"} {include file='sadmin-menu.tpl'} {elseif $user_type eq "pupil" } {include file='pupil-menu.tpl'} {/if} {/if}
                        </ul>

                        <ul class="nav navbar-nav navbar-right">

                            <li>

                                <a href="#" {$lien_menu.logout}>
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    Logout.
                                </a>
                            </li>
                        </ul>


                    </form>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
    </div>

    <div class="container">
        {if isset($errormsg) }
        <div class="alert alert-danger">
            <h2>Erreur</h2>
            {foreach from=$errormsg item=msg}
            <div>
                {$msg}
            </div>
            {/foreach}
        </div>
        {/if} {if isset($warningmsg) }
        <div class="alert alert-warning">
            <h2>Attention !</h2>
            {foreach from=$warningmsg item=msg}
            <div>
                {$msg}
            </div>
            {/foreach}
        </div>
        {/if} {if isset($infomsg) }
        <div class="alert alert-info">
            <h2>Attention !</h2>
            {foreach from=$infomsg item=msg}
            <div>
                {$msg}
            </div>
            {/foreach}
        </div>
        {/if} {if isset($debug_infomsg) }
        <p class="text-center">
            {literal}
            <button class="btn btn-info" onclick="if (document.getElementById('debug').style.display=='none'){document.getElementById('debug').style.display='block';} else {document.getElementById('debug').style.display='none';}">
                Informations de déverminage
            </button>
        </p>
        {/literal}
        <div class="col-md-6 col-md-offset-3" id="debug" style="display:none;">
            {foreach from=$debug_infomsg item=msg} {$msg} {/foreach}
        </div>
        {/if} {if $message neq ""}
        <div class="message">
            {$message}
        </div>
        {/if}
    </div>