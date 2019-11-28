<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Recommended;

$app->get("/admin/recommendeds", function(){

    User::verifyLogin();

    $recommended = new Recommended();

	$values = querySearch($recommended, "/admin/recommendeds?");


	$page = new PageAdmin();

	$page->setTpl("recommendeds", array(
		"recommendeds"=>$values["pagination"],
		"search"=>$values["search"],
		"pages"=>$values["pages"]
	));


});

$app->get("/admin/recommendeds/create", function()
{

	User::verifyLogin(); //ss

	$page = new PageAdmin();
	$page->setTpl("recommendeds-create");

});
$app->post("/admin/recommendeds/create", function()
{

	User::verifyLogin(); //sada

	$recommended = new Recommended();
	

	$recommended->setData($_POST);

	$recommended->save();

	header("Location: /admin/recommendeds");

	exit;

});

?>