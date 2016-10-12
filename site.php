<?php

//Start the session system
//session_start();

require __DIR__ . "/autoload.php";
require_once "config.php";

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

$site = new Site();
$localize = require 'localize.php';
if(is_callable($localize)) {
    $localize($site);
}

$site->setProjectId(PROJID);

$projects = new Projects($site);            ///< Creates project table
$exhibits = new Exhibits($site);            ///< Creates exhibit table
$explorations = new Explorations($site);    ///< Creates exploration table
$locations = new Locations($site);          ///< Creates location table
$areas = new Areas($site);                  ///< Creates area table
$users = new Users($site);                  ///< Creates user table
$search = new Search($site);                  ///< Creates user table

echo $base;
$site->setRoot(SITEROOT);
//$site->setRoot('http://'.$_SERVER['HTTP_HOST'].'/~zhicheng.xu/mbira_templates/web/');
$user = null;
if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
