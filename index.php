<?php
require_once 'vendor/autoload.php';
use \Illuminate\Database\Capsule\Manager as DB;
use mywishlist\controleur\ControleurCategorie;
use mywishlist\controleur\ControleurUrl;
use mywishlist\controleur\ControleurUser;
use mywishlist\controleur\Authentication;


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
session_start();

//Actions 

/*
$app->get('/liste/display', function () {
    $app = Slim\Slim::getInstance();
    if(isset($_SESSION['profile'])){
        $control=new ControleurListe();
        $control->afficherListes();
    }else{
        \Slim\Slim::getInstance()->redirect(ControleurUrl::urlName('connection'));
    }
})->name('affiche_listes');

*/


$app->get('/user/pannel/:id', function($id) {
    if(isset($_SESSION['profile'])){
    $app = \SLim\Slim::getInstance();
    $cu = new ControleurUser();
    $cu->afficherPannel($id);
    }else{
        \Slim\Slim::getInstance()->redirect(ControleurUrl::urlName('connection'));
    }
})->name('pannel');

$app->post('/user/pannel/change/:id', function($id) {
    $app = \Slim\Slim::getInstance();
    if(isset($_SESSION['profile']) && $app->request->post('newRole')!=null){
        $cu = new ControleurUser();
        $cu->changerDroit($id);
        $app->redirect(ControleurUrl::urlId('pannel',0));
    }else{
        $app->redirect(ControleurUrl::urlName('connection'));
    }
})->name('changer_role');

//Action sur l'utilisateur

$app->post('/user/changePass', function() {
    if(isset($_SESSION['profile'])){
    $app = \Slim\Slim::getInstance();
    if($app->request->post('pass')!=null && null!=$app->request->post('newPass') && $app->request->post('passVerif')!=null){
        $cu = new ControleurUser();
        $cu->changePass($app->request->post('pseudo'), $app->request->post('pass'),$app->request->post('newPass'), $app->request->post('passVerif'));
    }else {
        \Slim\Slim::getInstance()->redirect(ControleurUrl::urlName('connection'));
    }
    }else{
        \Slim\Slim::getInstance()->redirect(ControleurUrl::urlName('connection'));
    }
})->name('changePass');

$app->get('/user/connection', function() {
    $_SESSION['profile'] = null;
    $_SESSION['partage'] = null;
    $_SESSION['email'] = null;
    $control=new ControleurUser();
    $control->afficherFormConnect();
})->name('connection');

$app->get('/user/inscription', function() {
    $_SESSION['profile'] = null;
    $control=new ControleurUser();
    $control->afficherFormInscript();
})->name('inscription');

$app->post('/user/create', function() {
    $rep = Authentication::createUser();
        
    
    if($rep){
        $url = ControleurUrl::urlName('affiche_listes');
        header("Location: ".$url);
    }else {
        $url = ControleurUrl::urlName('inscription');
        header("Location: ".$url);
    }
    exit();
})->name('creer_user');

$app->post('/user/connect', function() {
    $app = \Slim\Slim::getInstance();
    
        Authentication::authenticate($app->request->post('pseudo'), $app->request->post('pass'), Authentication::$OPTION_LOADPROFILE, NULL);
    
    if(isset($_SESSION['profile'])){
        $app->redirect(ControleurUrl::urlName('affiche_listes'));
    }else {
        \Slim\Slim::getInstance()->redirect(ControleurUrl::urlName('connection'));
    }
})->name('connect_user');

$app->post('/user/delete/:id', function($id){
    $cu = new ControleurUser();
    $cu->supprimerUser($id);
    \Slim\Slim::getInstance()->redirect(ControleurUrl::urlId('pannel',0));
})->name('supprimer_user');




$app->get('/', function () {
    $url = ControleurUrl::urlName('connection');
    header('Location: '.$url);
    exit();
})->name('route_defaut');


$app->run();