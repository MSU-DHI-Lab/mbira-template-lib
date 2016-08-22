<?php

//$dbuser = "zhicheng_dev";
//$dbpass = "SU7Xt82F8h";
//$dbname = "zhicheng_dev";                // the database to connect to
//$dbhost = "rush.matrix.msu.edu";

$dbuser = "mbira_try";                // enter the user name to connect to the database
$dbname = "mbira_try";                // enter the database name you want to connect with
$dbpass = "p151H0PP2s";               // enter the password
$dbhost = "megaman.matrix.msu.edu";   // enter the host information

$projectID = 34;             // enter project id here (found on Device Settings page)

$source = "http://mbira.matrix.msu.edu/try/plugins/mbira_plugin/";   // Image source


define("PROJID",34);
define("DBUSER",$dbuser);
define("DBHOST",$dbhost);
define("DBPASS", $dbpass);
define("DBNAME", $dbname);

$base = str_replace(
    $_SERVER['DOCUMENT_ROOT'],
    '',
    realpath(dirname(__FILE__)));

$base = ($base == '') ? '/' : '';
?>
