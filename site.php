<?php

use \Hcode\PageSite;

$app->get('/home', function() {
    
    
    
    $page = new PageSite();
    $page->setTpl("dashboard");
   


});

$app->get('/topics', function() {
    
   
    
    $page = new PageSite();
    $page->setTpl("topics");
   


});


?>