<?php

require_once 'vendor/autoload.php';
use \Illuminate\Database\Capsule\Manager as DB;
use mywishlist\models\Item;
use mywishlist\models\Liste;
$app = new \Slim\Slim();
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

function afficherListes(){	
	$listes=Liste::select()->get();
	foreach ($listes as $liste){
		echo $liste."<br>";
	}
}

function afficherListe($num){
	$listes=Liste::select()->where('id', '=', $num)->get();
	foreach ($listes as $liste){
		echo $liste."<br>";
	}
}

function creerListe($user, $titre, $description){
	$l = new Liste();
	$l->user = $user;
	$l->titre = $titre;
	$l->description = $description;
	$l->save();
}