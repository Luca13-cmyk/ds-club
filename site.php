<?php

use \Hcode\PageSite;
use \Hcode\Model\User;
use \Hcode\Model\Topic;



$app->get('/topics/:idtopic', function($idtopic) {
    
    
    User::verifyLogin(false, false);





    $topic = new Topic();

    $topic->get((int)$idtopic);

    
    // $values = querySearch($topic, "/home?");
    
    // $dir = ($_SERVER['QUERY_STRING']) ? (int)substr(strstr($_SERVER['QUERY_STRING'], "="), 1) : 1;

    $page = new PageSite();

    $page->setTpl("topic", [

        "topic"=>$topic->getValues()

    ]);

    // $page->setTpl("topic", [
    //     "topics"=>$values["pagination"],
	// 	"search"=>$values["search"],
    //     "pages"=>$values["pages"],
    //     "dir"=>$dir
        
    // ]);
   


});



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
    
    $_SESSION[User::SESSION] = $user->getValues();

    header("Location: /profile");
    exit;
    
 });
 $app->post('/profile/avatar', function() {
    
    User::verifyLogin(false, false);

    $user = User::getFromSession();
    

    $user->setPhotoAvatar($_FILES["avatar"]);

    $_SESSION[User::SESSION] = $user->getValues();

    header("Location: /profile");
    exit;
    
 });


$app->get('/home', function() {
    
    
    User::verifyLogin(false, false);


    $topic = new Topic();

    $values = querySearch($topic, "/home?");
    
    $dir = ($_SERVER['QUERY_STRING']) ? (int)substr(strstr($_SERVER['QUERY_STRING'], "="), 1) : 1;

    $page = new PageSite();

    $page->setTpl("dashboard", [
        "topics"=>$values["pagination"],
		"search"=>$values["search"],
        "pages"=>$values["pages"],
        "dir"=>$dir
        
    ]);
   


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