<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;



$app = new Slim();

$app->config('debug', true);

// ######## functions

require_once("functions.php");


// ######## SITE

require_once("homePage.php");
require_once("site.php");

// ####### ADMIN

require_once("admin.php");
require_once("admin-users.php");
require_once("admin-topics.php");
require_once("admin-hqs.php");
require_once("admin-recommendeds.php");

$app->run();


 ?>

