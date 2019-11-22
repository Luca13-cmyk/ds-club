<?php

use \Hcode\PageSite;

$app->get('/home', function() {
    
    countQntIpPer();
    
    $page = new PageSite();
    $page->setTpl("dashboard");
   


});

$app->get('/topics', function() {
    
    countQntIpPer();
    
    $page = new PageSite();
    $page->setTpl("topics");
   


});


?>