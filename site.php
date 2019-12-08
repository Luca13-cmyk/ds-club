<?php

use \Hcode\PageSite;
use \Hcode\Model\User;
use \Hcode\Model\Topic;
use \Hcode\Model\Recommended;
use \Hcode\Model\Userlikes;
use \Hcode\Model\Topiclikes;



$app->get('/topics/:idtopic', function($idtopic) {
    
    
    User::verifyLogin(false, false);





    $topic = new Topic();

    $topic->get((int)$idtopic);

    
    // $values = querySearch($topic, "/home?");
    
    // $dir = ($_SERVER['QUERY_STRING']) ? (int)substr(strstr($_SERVER['QUERY_STRING'], "="), 1) : 1;
    
    $userlikes = Userlikes::getFromSession(); // pega todos os valores de likes

    $topiclikes = new Topiclikes();

    $topiclikes->get((int)$idtopic);


    $user = User::getFromSession();

    $like = Userlikes::getDataFromSessionLogin((int)$user->getiduser(), (int)$idtopic);


    $page = new PageSite();

    $page->setTpl("topic", [

        "topic"=>$topic->getValues(),
        "number_likes"=>$topiclikes->getdesnumlikes(),
        "like"=>$like

    ]);

   


});

$app->post('/topics/:idtopic', function($idtopic) {
    
    User::verifyLogin(false, false);

    $validation = Userlikes::getFromSession();

    $user = User::getFromSession();

    $like = Userlikes::getDataFromSessionLogin((int)$user->getiduser(), (int)$idtopic);


    $topiclikes = new Topiclikes();
    
    $userlikes = new Userlikes();


    $topiclikes->get((int)$idtopic);

    $userlikes->addLike($idtopic, $topiclikes);

    exit;

 });

$app->get('/ig', function() {
    
    User::verifyLogin(false, false);

    // $user = User::getFromSession();


    // $page = new PageSite();

    // $page->setTpl("profile", [
    //     "user"=>$user->getValues(),
    //     "profileMsg"=>User::getSuccess(),
    //     "profileError"=>User::getError()
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

    $recommendeds = Recommended::listAll();


    $values = querySearch($topic, "/home?");
    
    $dir = ($_SERVER['QUERY_STRING']) ? (int)substr(strstr($_SERVER['QUERY_STRING'], "="), 1) : 1;

    $page = new PageSite();

    $page->setTpl("dashboard", [
        "topics"=>$values["pagination"],
		"search"=>$values["search"],
        "pages"=>$values["pages"],
        "dir"=>$dir,
        "recommendeds"=>$recommendeds
        
    ]);
   


});

$app->get('/get', function() {
    
    
    User::verifyLogin(false, false);


    $topic = new Topic();
    
    $values = querySearch($topic, "/get?");
    
    $dir = ($_SERVER['QUERY_STRING']) ? (int)substr(strstr($_SERVER['QUERY_STRING'], "="), 1) : 1;

    $page = new PageSite();

    $page->setTpl("get", [
        "topics"=>$values["pagination"],
		"search"=>$values["search"],
        "pages"=>$values["pages"],
        "dir"=>$dir
        
    ]);
   
});


$app->get('/topics', function() {
    
   User::verifyLogin(false, false);
    
   $recommendeds = Recommended::listAll();
     
    $AZ = Topic::getPageSearchAZ("s");

    $page = new PageSite();
    $page->setTpl("topics", [
        "recommendeds"=>$recommendeds,
        "AZ"=>$AZ
    ]);
   


});




$app->get('/logout', function() {

	User::logout();
	header("Location: /login");
	exit;

});


// ############## DATA SITE AJAX #################

$app->get('/data/ajax/AZ', function() {
    
    
    User::verifyLogin(false, false);
    
    $l = (isset($_GET["l"])) ? $_GET["l"] : "a";

    
    echo json_encode(Topic::getPageSearchAZ($l));
    exit;
    
 
 });


?>