<?php
require_once('/etc/c2i-annu/c2inotemysql-config.php');

function mysqlConnexion(){
   
    global $hostdb,$database,$userdb,$passworddb;
     
    $link = mysql_connect($hostdb, $userdb, $passworddb)
    or die("Impossible de se connecter : " . mysql_error());
    

    $db_selected = mysql_select_db($database, $link);
    if (!$db_selected) {
        die ('Impossible de sélectionner la base de données : ' . mysql_error());
    }
    return $link;
}

?>
