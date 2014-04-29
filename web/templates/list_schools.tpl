{include file="header.tpl"}
<div class="container">
    <div class="page-header text-center">
        <h2> Établissements </h2>
    </div>
    <div class="center-block">
        <form name='schoolslist' action='index.php' method='post'>
            <input type='hidden' name='page' value='none' />
            <input type='hidden' name='action' value='none' />
            <input type='hidden' name='rne' value='none' />
            <table class="table table-nonfluid table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th>RNE</th>
                        <th>Type</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$schools item=school}
                    <tr>
                        <td>{$school.rne}</td>
                        <td>{$school.type}</td>
                        <td>{$school.name}</td>
                        <td>{$school.city}</td>
                        <td>
                            <img src='images/edit_24.png' width='24' height='24' title='prendre le controle' {$school.control_link} />
                            <img src='images/look_24.png' width='24' height='24' title='d&eacute;tails' {$school.edit_link} />
                            <img src='images/bin_24.png' width='24' height='24' title='supprimer' {$school.delete_link} />
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            <div class="text-center">
                <p>
                    <a class="btn btn-primary" {$create_link}>
                        <i class="fa fa-plus"></i> Nouvel &eacute;tablissement
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
{include file="footer.tpl"}
