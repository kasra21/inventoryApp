<?php
$username = "a8597821_root";
$password = "kk123456";
$database = "a8597821_invent";
$webserver = "mysql6.000webhost.com";


// Opens a connection to a MySQL server

$connection = mysql_connect($webserver, $username, $password);
if (!$connection) {
    die('Not connected : ' . mysql_error());
    exit();
}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
    die('Can\'t use db : ' . mysql_error());
}


?>
