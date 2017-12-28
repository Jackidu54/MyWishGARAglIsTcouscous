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
		<link rel="stylesheet" href="/web/css/style.css">
		<body>
		<h1>Inscription</h1>
        <form id="creerUser" method="post" action="$urlCreer">
		<label>Pseudo</label>
		<input type="text" id="pseudo" name="pseudo" class="champ_inscr">
		<label>Mot de passe</label>
		<input type="password" id="pass" name="pass" class="champ_inscr">
		<label>Confirmer</label>
		<input type="password" id="pass" name="passVerif" class="champ_inscr">
		<label>Mail</label>
		<input type="text" id="mail" name="mail" class="champ_inscr">
		<button type="submit" name="valid" class="se_connecter">S'inscrire</button>
		</form>

		<h1>Connexion</h1>
		<form id="connectUser" method="post" action="$urlConne">
		<label>Pseudo</label>
		<input type="text" id="pseudo" name="pseudo" class="champ_con">
		<label>Mot de passe</label>
		<input type="password" id="pass" name="pass" class="champ_con">
		<button type="submit" name="valid" class="se_connecter">Se connecter</button>
		</form>
		</body>
		</html>
html;
        return $contenu;
   	}

}