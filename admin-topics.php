<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Topic;
use \Hcode\Model\Product;


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

$app->get("/admin/topics/:idtopic/products", function($idtopic){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$page = new PageAdmin();

	$page->setTpl("topics-products", [
		"topic"=>$topic->getvalues(),
		"productsRelated"=>$topic->getProducts(),
		"productsNotRelated"=>$topic->getProducts(false)

	]);

});

$app->get("/admin/topics/:idtopic/products/:idproduct/add", function($idtopic, $idproduct){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$product = new Product();

	$product->get((int)$idproduct);

	$topic->addProduct($product);

	header("Location: /admin/topics/" . $idtopic . "/products");
	exit;

});
$app->get("/admin/topics/:idtopic/products/:idproduct/remove", function($idtopic, $idproduct){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idtopic);
	
	$product = new Product();

	$product->get((int)$idproduct);

	$topic->removeProduct($product);

	header("Location: /admin/topics/" . $idtopic . "/products");
	exit;

});

?>