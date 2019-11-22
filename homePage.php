<?php

use \Hcode\Page;
use \Hcode\Model\User;

$app->get('/', function() {
    
    countQntIpPer();
    
    
    $page = new Page();
    $page->setTpl("index");
   


});
$app->get('/login', function() {
    
    countQntIpPer();
    
    $page = new Page([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("login-page", [
        "error"=>User::getError()
    ]);
   

});
$app->post("/login", function(){
    
    try {

        User::login($_POST["login"], $_POST["password"]);

   } catch (Exception $e) {
       User::setError($e->getMessage());
       header("Location: /login");
       exit;
        
   }
   
   header("Location: /home");
   exit;

    

});


?>