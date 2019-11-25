<?php

use \Hcode\Page;
use \Hcode\Model\User;
use \Hcode\Mailer;

$app->get('/', function() {
    
    
    
    
    $page = new Page();
    $page->setTpl("index");
   


});
$app->get('/login', function() {
    
    
    
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

$app->get('/register', function() {
    
    
    
    $page = new Page([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("register-page", [
        "errorRegister"=>User::getErrorRegister(),
        "successRegister"=>User::getSuccess(),
        'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'email'=>'', 'phone'=>'']
    ]);
});

$app->get('/register/confirm', function() {

    User::registerValidConfirm();

    
});

$app->post("/register", function(){

	

    User::registerValid();


    header('Location: /register');
    exit;

	
});



?>