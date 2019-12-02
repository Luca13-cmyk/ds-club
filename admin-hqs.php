<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Hq;

$app->get('/admin/hqs', function() {
   
    User::verifyLogin();

    $hqs = new Hq();

    $values = querySearch($hqs, "/admin/hqs?");
   
    $page = new PageAdmin();
    $page->setTpl("hqs", [
        'hqs'=>$values["pagination"],
        'search'=>$values["search"],
        'pages'=>$values["pages"]
    ]);
});
$app->get('/admin/hqs/create', function() {
   
    User::verifyLogin();

   
    $page = new PageAdmin();

    $page->setTpl("hqs-create");


});

$app->post('/admin/hqs/create', function() {
   
    User::verifyLogin();
    $Hq = new Hq();
    $Hq->setData($_POST);
    $Hq->save();
    header("Location: /admin/hqs");
    exit;

});

$app->get('/admin/hqs/:idHq', function($idHq) {
   
    User::verifyLogin();

    $Hq = new Hq();

    $Hq->get((int)$idHq);

    $page = new PageAdmin();
    $page->setTpl("hqs-update", [
        "Hq"=>$Hq->getvalues()
    ]);


});

$app->post('/admin/hqs/:idHq', function($idHq) {
   
    User::verifyLogin();

    $Hq = new Hq();

    $Hq->get((int)$idHq);

    $Hq->setData($_POST);

    $Hq->save();

    $Hq->setPhoto($_FILES["file"]);

    header("Location: /admin/hqs");
    exit;

});

$app->get('/admin/hqs/:idHq/delete', function($idHq) {
   
    User::verifyLogin();

    $Hq = new Hq();

    $Hq->get((int)$idHq);

    $Hq->delete();
    header("Location: /admin/hqs");
    exit;

});


?>