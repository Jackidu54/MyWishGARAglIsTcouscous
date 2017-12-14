<?php
require_once 'vendor/autoload.php';
use mywishlist\controleur\ControleurListe;
use \Illuminate\Database\Capsule\Manager as DB;
use mywishlist\vue\VueItem;
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

$app->get('/liste/display/:num', function ($num) {
    $control=new ControleurListe();
    $control->afficherListe($num);
})->name('affiche_1_liste');

$app->post('/liste/create/valide', function () {
    $app = \Slim\Slim::getInstance();
    $control=new ControleurListe();
    if($app->request->post('titre')!=null && $app->request->post('description')!=null){
        //$user = filter_var($app->request->post('user'), FILTER_SANITIZE_STRING);
        $user_id = 1;
        $titre = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING); 
        $description = filter_var($app->request->post('description'), FILTER_SANITIZE_STRING);
        $control->creerListe($user_id, $titre, $description);
    }
})->name('validation_liste');

$app->post('/liste/modify/:id', function ($id) {
    $control=new ControleurListe();
    $titre = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING); 
    $description = filter_var($app->request->post('description'), FILTER_SANITIZE_STRING); 
    if(isset($user) && isset($titre) && isset($description)){
        $control->modifierListe($id, $titre,$description);
    }
})->name('modifie_liste');

$app->get('/liste/create', function () {
    $control=new ControleurListe();
    $control->afficheCreationListe();
})->name('creation_liste');

$app->post('/liste/message/:id', function ($id) {
    $control=new ControleurListe();
    $mess = $app->request->post('message');
    $control->afficherListe($id, $message);
})->name('cree_message');

$app->get('/item/display/:num', function ($num) {
    echo "yolo";
})->name('affiche_1_item');

$app->get('/item/reserve/:num', function ($num) {
    echo "yolo";
})->name('reserve_item');

$app->get('/item/cancel/:num', function ($num) {
    echo "tu annules $num";
})->name('annule_item');



$app->run();