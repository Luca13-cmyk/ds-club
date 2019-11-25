<?php

use \Hcode\PageSite;

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


?>