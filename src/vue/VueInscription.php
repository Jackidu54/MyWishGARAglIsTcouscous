<?php
namespace mywishlist\vue;

use mywishlist\controleur\ControleurUrl;

class VueInscription
{

	private $model;
	private $selecteur;

	function __construct($select, $model){
		$this->model = $model;
		$this->selecteur = $select;
	}

	 function render()
    {
    	$app = \Slim\Slim::getInstance();
        $contenu = "";
        $urlCreer = ControleurUrl::urlName('creer_user');
        $urlConne = ControleurUrl::urlName('connect_user');
        $contenu = $contenu . <<<html
        <!DOCTYPE html>
		<html lang="fr">
		<head>
	  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Inscription</title>
		<h1>Inscription</h1>
        <form id="creerUser" method="post" action="$urlCreer">
		<label>Pseudo</label>
		<input type="text" id="pseudo" name="pseudo">
		<label>Pass</label>
		<input type="password" id="pass" name="pass">
		<label>Confirm pass</label>
		<input type="password" id="pass" name="passVerif">
		<label>Mail</label>
		<input type="text" id="mail" name="mail">
		<button type="submit" name="valid" >S'inscrire</button>
		</form>

		<h1>Connexion</h1>
		<form id="connectUser" method="post" action="$urlConne">
		<label>Pseudo</label>
		<input type="text" id="pseudo" name="pseudo">
		<label>Mot de passe</label>
		<input type="password" id="pass" name="pass">
		<button type="submit" name="valid" >Se connecter</button>
		</form>
		</html>
html;
        return $contenu;
   	}

}