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

$app->get('/register', function() {
    
    
    
    $page = new Page([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("register-page", [
        "errorRegister"=>User::getErrorRegister(),
        'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'email'=>'', 'phone'=>'']
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
$app->get('/register/confirm', function() {

    if ($_GET["code"])
    {

        $code = base64_decode($code);
    
        $emailrecovery = openssl_decrypt($code, 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

        $user = new User();

        $user->setdeslogin($emailrecovery);
         
        $user->save();
    
        User::login($emailrecovery, $user->getdespassword());
    
        header('Location: /home');
        exit;
    }
    
    

    // $page = new Page([
    //     "header"=>false,
    //     "footer"=>false
    // ]);

    // $page->setTpl("register-page", [
    //     "errorRegister"=>User::getErrorRegister(),
    //     'registerValues'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'email'=>'', 'phone'=>'']
    // ]);
});

$app->post("/register", function(){

	$_SESSION['registerValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] == '') {

		User::setErrorRegister("Preencha o seu nome.");
		header("Location: /login");
		exit;

	}

	if (!isset($_POST['email']) || $_POST['email'] == '') {

		User::setErrorRegister("Preencha o seu e-mail.");
		header("Location: /login");
		exit;

	}

	if (!isset($_POST['password']) || $_POST['password'] == '') {

		User::setErrorRegister("Preencha a senha.");
		header("Location: /login");
		exit;

	}

	if (User::checkLoginExist($_POST['email']) === true) {

		User::setErrorRegister("Este endereço de e-mail já está sendo usado por outro usuário.");
		header("Location: /login");
		exit;

    }

    $code = openssl_encrypt($_POST['email'], 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

	$code = base64_encode($code);
    
    $mailer = new Mailer($_POST['email'], $_POST['name'],  "Confirmar registro", "Confirm", array(
        "name"=>$_POST['name'],
        "link"=>"https://lds-club-com.umbler.net/register/confirm?code=$code"
    ));
    $mailer->send();

    $user = new User();
    
    $user->setData([
        'inadmin'=>0,
        'desperson'=>$_POST['name'],
        'desemail'=>$_POST['email'],
        'despassword'=>$_POST['password'],
        'nrphone'=>$_POST['phone']
    ]);

    header('Location: /register');
    exit;

	
});



?>