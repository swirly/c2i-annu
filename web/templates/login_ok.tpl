{include file="header.tpl"}
<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="jumbotron">
            <form name="login" method="post" action="index.php">
                <input type="hidden" name="page" value="accueil">
                <input type="hidden" name="action" value="none">
                <h1>Bienvenue sur l'annuaire C2I</h1>
                <p>Vous avez été authentifié avec succès. Cliquez sur le bouton ci dessous pour poursuivre.</p>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Poursuivre</button>
                </div>
            </form>
        </div>
    </div>
</div>
{include file="footer.tpl"}
