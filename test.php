<?php

require_once 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use mywishlist\models\Liste;
use mywishlist\models\Item;

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

$listes=Liste::select()->get();
foreach ($listes as $liste){
    echo $liste."<br>";
}
echo "<br>";
$items=Item::select()->get();
foreach ($items as $item){
    echo $item."<br>";
}
echo "<br>";
echo "<br>";
if (isset($_GET['id'])){
    $items=Item::where('id','=',$_GET['id'])->first();
    echo $items;
    echo "<br>".$items->liste();
}
