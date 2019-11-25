<?php

use \Hcode\PageSite;
use \Hcode\Model\User;

$app->get('/home', function() {
    
    
    User::verifyLogin(false, false);

    $page = new PageSite();
    $page->setTpl("dashboard");
   


});

$app->get('/topics', function() {
    
   User::verifyLogin(false, false);
    
    $page = new PageSite();
    $page->setTpl("topics");
   


});

$app->get('/logout', function() {

	User::logout();
	header("Location: /login");
	exit;

});


?>