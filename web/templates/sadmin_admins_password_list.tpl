{include file="header.tpl"}
<div class="container">
    {if $error_message neq ""}
    <div class="alert alert-danger">
        {$error_message}
    </div>
    {/if}
    <div>
        <p>Voici la liste des administrateurs locaux avec les mots de passe correspondant. Imprimez ou sauvegardez cette page pour pouvoir donner la liste des mots de passe aux administrateurs concernés.</p>

        <table class="table table-hover table-striped table-nonfluid">
            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Login</th>
                    <th>Mot de passe</th>
                    <th></th>
                </tr>
            </thead>
            {foreach from=$password_list item=password_item}
            <tr>
                <td>{$password_item.cn}</td>
                <td>{$password_item.uid}</td>
                <td>{$password_item.password}</td>
            </tr>
            {/foreach}
        </table>
    </div>
</div>

{include file="footer.tpl"}
