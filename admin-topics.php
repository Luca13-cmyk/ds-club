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

$app->get("/admin/topics/:idcategory/delete", function($idcategory){
	User::verifyLogin();

	$topic = new Topic();

	$topic->get((int)$idcategory);

	$topic->delete();

	header("Location: /admin/topics");

	exit;

	
});

$app->get("/admin/topics/:idcategory", function($idcategory){

	User::verifyLogin();

	
	$topic = new Topic();

	$topic->get((int)$idcategory);
	
	$page = new PageAdmin();
	$page->setTpl("topics-update", [
		"category"=>$topic->getvalues()
	]);


	
});

$app->post("/admin/topics/:idcategory", function($idcategory){

	User::verifyLogin();

	
	$topic = new Topic();

	$topic->get((int)$idcategory);
	$topic->setData($_POST);
	$topic->save();

	header("Location: /admin/topics");

	exit;
	
});

$app->get("/admin/topics/:idcategory/products", function($idcategory){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idcategory);
	
	$page = new PageAdmin();

	$page->setTpl("topics-products", [
		"category"=>$topic->getvalues(),
		"productsRelated"=>$topic->getProducts(),
		"productsNotRelated"=>$topic->getProducts(false)

	]);

});

$app->get("/admin/topics/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idcategory);
	
	$product = new Product();

	$product->get((int)$idproduct);

	$topic->addProduct($product);

	header("Location: /admin/topics/" . $idcategory . "/products");
	exit;

});
$app->get("/admin/topics/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){

	User::verifyLogin();
	
	
	$topic = new Topic();

	$topic->get((int)$idcategory);
	
	$product = new Product();

	$product->get((int)$idproduct);

	$topic->removeProduct($product);

	header("Location: /admin/topics/" . $idcategory . "/products");
	exit;

});

?>