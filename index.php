<?php
require_once 'vendor/autoload.php';
echo "gxfzxjf";
$app = new \Slim\Slim();
$app->get('/liste/display', function () {
    echo "yolo";
});
$app->get('/liste/create', function () {
    echo "yolo";
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