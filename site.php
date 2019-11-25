<?php

use \Hcode\PageSite;
use \Hcode\Model\User;

$app->get('/profile', function() {
    
    User::verifyLogin(false, false);

    $user = User::getFromSession();

    $page = new PageSite();

    $page->setTpl("profile", [
        "user"=>$user->getValues(),
        "profileMsg"=>User::getSuccess(),
        "profileError"=>User::getError()
    ]);
    
 });
 $app->post('/profile/cap', function() {
    
    User::verifyLogin(false, false);

    $user = User::getFromSession();
   

    $user->setPhotoCap($_FILES["cap"]);

    header("Location: /profile");
    exit;
    
 });
 $app->post('/profile/avatar', function() {
    
    User::verifyLogin(false, false);

    $user = User::getFromSession();
    

    $user->setPhotoAvatar($_FILES["avatar"]);

    header("Location: /profile");
    exit;
    
 });


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