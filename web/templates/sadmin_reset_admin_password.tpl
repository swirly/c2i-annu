{include file="header.tpl"}
<div class="container">
    {if $error neq ""}
    <div class="alert alert-danger">
        {$error}
    </div>
    {/if}
    <div class="text-center">
        <h4>
            Voici la liste des mots de passe réinitialisés. Sauvegardez cette page ou imprimez là.
        </h4>
    </div>
    <div>
        <table class="table table-nonfluid table-hover table-striped">
            <thead>
                <tr>
                    <th>Identifiant</th>
                    <th>Nom</th>
                    <th>Nouveau mot de passe</th>
                </tr>
            </thead>
            {foreach from=$admins item=admin}
            <tr>
                <td>{$admin.uid}</td>
                <td>{$admin.cn}</td>
                <td>{$admin.pwdclear}</td>
            </tr>
            {/foreach}
        </table>
    </div>
</div>
{include file="footer.tpl"}
