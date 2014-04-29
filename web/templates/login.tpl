{include file="header.tpl"}
<div class="container">
    <div class="col-md-6 col-md-offset-3">
        <div class="well well-lg">
            <div class="page-header">
                <h1>Bienvenue sur l'annuaire C2I.</h1>
                <h2>
                    <small>Veuillez vous identifier.</small>
                </h2>
            </div>
            <form name="login" class="form-horizontal" role="form" method="post" action="index.php">
                <input type="hidden" name="page" value="login">
                <input type="hidden" name="action" value="validate_login">
                <div class="form-group">
                    <label for="login" class="col-md-4">Identifiant</label>
                    <div class="col-md-8">
                        <input name="login" class="form-control" type="text" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4">Mot de passe</label>
                    <div class="col-md-8">
                        <input name="password" class="form-control" type="password" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-4 col-md-8">
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
{include file="footer.tpl"}
