<?php
/**
 * Created by PhpStorm.
 * User: ZhichengXu
 * Date: 10/6/15
 * Time: 3:32 PM
 */

require_once __DIR__ . "/config.php";
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Site $site) {
    //$site->setEmail('xuzhi1@cse.msu.edu');
    //$site->setRoot('/~xuzhi1/mbira');

    $host = "mysql:host=".DBHOST.";dbname=".DBNAME;

    $site->dbConfigure($host,DBUSER,DBPASS);

};
