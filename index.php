<?php
require_once 'vendor/autoload.php';
use mywishlist\controleur\ControleurListe;
use \Illuminate\Database\Capsule\Manager as DB;
use mywishlist\controleur\ControleurItem;
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

$app->post('/liste/delete/:id', function($id) {
    $control=new ControleurListe();
    $control->supprimerListe($id);
    header('Location: /liste/display');
    exit();
})->name('supprimer liste');

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

$app->post('/liste/modify/valide/:id', function ($id) {
    $control=new ControleurListe();
    $titre = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING); 
    $description = filter_var($app->request->post('description'),FILTER_SANITIZE_STRING); 
    if(isset($user) && isset($titre) && isset($description)){
        $control->modifierListe($id, $titre,$description);
    }
})->name('modifie_liste_valide');

$app->get('/liste/modify/:id', function ($id) {
    $control=new ControleurListe();
    $control->afficherModificationListe($id);
    
})->name('modifie_liste');

$app->get('/', function () {
    header('Location: /liste/display');
    exit();
})->name('route_defaut');

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
    $control=new ControleurItem();
    $control->afficherItem($num);
})->name('affiche_1_item');

$app->get('/item/add', function () {
    $control=new ControleurItem();
    $control->afficherAjouterItem();
})->name('ajoute_item');

$app->post('/item/add/valid/:num', function ($num) {
    $control=new ControleurItem();
    $titre = filter_var($app->request->post('titre'), FILTER_SANITIZE_STRING);
    $description = filter_var($app->request->post('description'),FILTER_SANITIZE_STRING);
    $idliste=$app->request->post('idliste');
    if(isset($titre) && isset($description)){
        $control->ajouterItem($titre,$description);
    }
})->name('ajoute_item_valide');

$app->get('/item/reserve/:num', function ($num) {
    echo "yolo";
})->name('reserve_item');

$app->get('/item/cancel/:num', function ($num) {
    echo "tu annules $num";
})->name('annule_item');



$app->run();