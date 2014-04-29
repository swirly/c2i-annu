{include file="header.tpl"}
<div class="container">
    <form action="index.php" method="post">
        <input type="hidden" name="page" value="config" />
        <input type="hidden" name="action" value="config_modify" />{if $error_message neq ""}
        <div class="error">
            {$error_message}
        </div>
        {/if}

        <div class="row">
            <table class="table table-striped table-hover table-nonfluid">
                <theader>
                    <tr>
                        <th>Paramètre</th>
                        <th>Valeur actuelle</th>
                    </tr>
                </theader>
                <tbody>
                    {foreach from=$params item=param}
                    <tr>
                        <td>
                            <b>{$param.name}</b>
                        </td>
                        <td>{$param.value}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="text-center">
                <div  style="display:inline-block;text-align:left;">
                    <h3>Gestion des élèves par les administrateurs locaux</h3>
                    <input type="checkbox" name="pupil_can_import" {$pupil_can_import_checked}/>Import des élèves par les administrateurs locaux
                    <br>
                    <input type="checkbox" name="pupil_can_select" {$pupil_can_select_checked}/>Sélection des élèves par les administrateurs locaux
                </div>
            </div>
        </div>
    </form>
</div>

{include file="footer.tpl"}
