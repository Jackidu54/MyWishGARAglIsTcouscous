<?php
require_once 'vendor/autoload.php';
use mywishlist\controleur\ControleurListe;
use \Illuminate\Database\Capsule\Manager as DB;
$db = new DB();
$t=parse_ini_file( 'src/conf/conf.ini' );
$db->addConnection( [
    'driver' => $t['driver'],
    'host' =>  $t['host'],
    'database' =>  $t['database'],
    'username' =>  $t['username'],
    'password' =>  $t['password'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
] );
$db->setAsGlobal();
$db->bootEloquent();
$app = new \Slim\Slim();
$app->get('/liste/display', function () {
    echo "yolo";
});
$app->get('/liste/create', function () {
    $control=new ControleurListe();
});
$app->get('/liste/modify', function () {
    echo "yolo";
});
$app->get('/liste/display/:num', function ($num) {
    echo "tu veux la liste $num";
});

$app->get('/item/display/:num', function ($num) {
    echo "yolo";
});
$app->get('/item/reserve/:num', function ($num) {
    echo "yolo";
});
$app->get('/item/cancel/:num', function ($num) {
    echo "tu annules $num";
});
$app->get('/liste/message/create', function () {
    echo "yolo";
});
$app->run();