<?php
namespace mywishlist\controleur;

class ControleurUrl
{


	public static function urlName($name){
		$app =\Slim\Slim::getInstance();
	    $rootUri = $app->request->getRootUri();
	    $urlFor = $app->urlFor($name);
	    $url =  $urlFor;
	    return $url;
	}

	public static function urlId($name, $id){
		$app =\Slim\Slim::getInstance();
	    $rootUri = $app->request->getRootUri();
	    $urlFor = $app->urlFor($name, ['id'=>$id]);
	    $url =  $urlFor;
	    return $url;
	}

}