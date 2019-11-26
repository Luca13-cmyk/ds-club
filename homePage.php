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


$app->get('/forgot', function() {
	

	$page = new Page();
	$page->setTpl("forgot");
	
	
});
$app->post("/forgot", function()
{
	
	$user = User::getForgot($_POST["email"], false);
	header("Location: /forgot/sent");
	exit;
});

$app->get('/forgot/sent', function() {
	

    $page = new Page();

	$page->setTpl("forgot-sent");
	
});

$app->get("/forgot/reset", function(){

	$user = User::validForgotDecrypt($_GET["code"]);

    $page = new Page();

	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));
});

$app->post("/forgot/reset", function()
{
	$forgot = User::validForgotDecrypt($_POST["code"]);

	User::setForgotUser($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
    'cost'=>12, //numero de processamento que o servidor fara para encryptar a senha. Quanto maior for, mais segura sera.
	]);

	
	$user->setPassword($password);

    $page = new Page();

	$page->setTpl("forgot-reset-success");

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