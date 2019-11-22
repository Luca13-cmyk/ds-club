<?php

use \Hcode\PageAdmin;


$app->get('/admin/users', function() {
    $page = new PageAdmin();
	$page->setTpl("users");

});

?>