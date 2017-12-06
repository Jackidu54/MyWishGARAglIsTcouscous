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
    $control=new ControleurListe();
    $control->afficherListes();
})->name('affiche_listes');

$app->get('/liste/create/:titre/:user/:description', function ($user,$titre,$description) {
    //todo
    $control=new ControleurListe();
    $control->creerListe($user, $titre, $description);
})->name('creation_liste');

$app->get('/liste/modify', function () {
    $control=new ControleurListe();
    
})->name('modifie_liste');

$app->get('/liste/display/:num', function ($num) {
    $control=new ControleurListe();
    $control->afficherListe($num);
})->name('affiche_1_liste');

$app->get('/item/display/:num', function ($num) {
    echo "yolo";
})->name('affiche_1_item');

$app->get('/item/reserve/:num', function ($num) {
    echo "yolo";
})->name('reserve_item');

$app->get('/item/cancel/:num', function ($num) {
    echo "tu annules $num";
})->name('annule_item');

$app->get('/liste/message/create', function () {
    echo "yolo";
})->name('cree_message');

$app->run();