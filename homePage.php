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
        "successRegister"=>User::getSuccess(),
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

    if ($_GET["data"])
    {
        $data = $_GET["data"];

        $data = base64_decode($data);
    
        $datarecovery = openssl_decrypt($data, 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

        $data = json_decode($data, true);
        var_dump($data);
        exit;

        $user = new User();
    
        $user->setData($data);
    
        $user->save();
    
        User::login($user->getdeslogin(), $user->getdespassword());
    
        header('Location: /home');
        exit;
    }
    
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

    $data = [
        'inadmin'=>0,
        'deslogin'=>$_POST['email'],
        'desperson'=>$_POST['name'],
        'desemail'=>$_POST['email'],
        'despassword'=>$_POST['password'],
        'nrphone'=>$_POST['phone']
    ];

    $data = json_encode($data);

    $data = openssl_encrypt($data, 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));

	$data = base64_encode($data);
    
    $mailer = new Mailer($_POST['email'], $_POST['name'],  "Confirmar registro", "Confirm", array(
        "name"=>$_POST['name'],
        "link"=>"https://lds-club-com.umbler.net/register/confirm?data=$data"
    ));
    $mailer->send();

    $user = new User();

    $user->setSuccess("Email enviado para". $_POST['email'] . ", por favor, confirme o cadastro.");

    header('Location: /register');
    exit;

	
});



?>