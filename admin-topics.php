<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Topic;
use \Hcode\Model\Hq;

// $app->get("/admin/topics/:idtopic/hqs/:idhq/add", function($idtopic, $idhq){

// 	User::verifyLogin();
	
	
// 	$topic = new Topic();

// 	$topic->get((int)$idtopic);
	
// 	$hq = new Hq();

// 	$hq->get((int)$idhq);

// 	$topic->addHq($hq);

// 	header("Location: /admin/topics/" . $idtopic . "/hqs");
// 	exit;

// });
$app->get("/admin/topics/:idtopic/hqs/:idhq/remove", function($idtopic, $idhq){

	User::verifyLogin();
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$hq = new Hq();

	$hq->get((int)$idhq);

	$topic->removeHq($hq);

	header("Location: /admin/topics/" . $idtopic . "/hqs");
	exit;

});

$app->get("/admin/topics/:idtopic/hqs", function($idtopic)
{
	User::verifyLogin();

	$topic = new Topic();

	$topic->get((int)$idtopic);

	$page = new PageAdmin();

	$page->setTpl("topics-hqs", [
		"topic"=>$topic->getValues(),
		"hqsRelated"=>$topic->getHqs()
		// "hqsNotRelated"=>$topic->getHqs(false)
	]);

});





$app->get("/admin/topics", function()
{
	User::verifyLogin();


	$topic = new Topic();

	$values = querySearch($topic, "/admin/topics?");


	$page = new PageAdmin();

	$page->setTpl("topics", array(
		"topics"=>$values["pagination"],
		"search"=>$values["search"],
		"pages"=>$values["pages"]
	));

});
$app->get("/admin/topics/create", function()
{

	User::verifyLogin();

	$user = User::getFromSession();


	$page = new PageAdmin();
	$page->setTpl("topics-create", [
		"user"=>$user->getValues()
	]);

});
$app->post("/admin/topics/create", function()
{

	User::verifyLogin();

	$topic = new Topic();
	
	$topic->setData($_POST);

	$topic->save();

	header("Location: /admin/topics");

	exit;

});

$app->get("/admin/topics/:idtopic/delete", function($idtopic){
	
	User::verifyLogin();

	$topic = new Topic();

	$topic->get((int)$idtopic);

	$topic->delete();

	header("Location: /admin/topics");

	exit;

	
});

$app->get("/admin/topics/:idtopic", function($idtopic){

	User::verifyLogin();

	
	$topic = new Topic();

	$topic->get((int)$idtopic);

	$user = User::getFromSession();

	
	$page = new PageAdmin();

	$page->setTpl("topics-update", [
		"topic"=>$topic->getvalues(),
		"user"=>$user->getValues()
	]);


	
});

$app->post("/admin/topics/:idtopic", function($idtopic){

	User::verifyLogin();

	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	$topic->setData($_POST);
	$topic->save();

	header("Location: /admin/topics");

	exit;
	
});

$app->get("/admin/topics/:idtopic/hqs", function($idtopic){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$page = new PageAdmin();

	$page->setTpl("topics-hqs", [
		"topic"=>$topic->getvalues(),
		"hqsRelated"=>$topic->gethqs(),
		"hqsNotRelated"=>$topic->gethqs(false)

	]);

});

$app->get("/admin/topics/:idtopic/hqs/:idhq/add", function($idtopic, $idhq){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$hq = new hq();

	$hq->get((int)$idhq);

	$topic->addhq($hq);

	header("Location: /admin/topics/" . $idtopic . "/hqs");
	exit;

});
$app->get("/admin/topics/:idtopic/hqs/:idhq/remove", function($idtopic, $idhq){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$hq = new hq();

	$hq->get((int)$idhq);

	$topic->removehq($hq);

	header("Location: /admin/topics/" . $idtopic . "/hqs");
	exit;

});

?>