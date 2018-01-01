<?php

namespace mywishlist\vue;

use mywishlist\controleur\ControleurUrl;
use mywishlist\controleur\Authentication;

class VueHtml{

	public static $ARTICLE = 1;

	private $contenu;
	private $select;

	function __construct($contenu, $select){
		$this->contenu = $contenu;
		$this->select = $select;
	}

	function render(){


		if($this->select == VueHtml::$ARTICLE){
				$html = "";
				$urlConnect = ControleurUrl::urlName('connection');
				$urlPannel = ControleurUrl::urlId('pannel', 0);
				$user = $_SESSION['profile']['pseudo'];
		        if($_SESSION['profile']['jeton']==4){
		            $role = 'super admin';
		        }else if($_SESSION['profile']['jeton']==2){
		            $role = 'moderateur';
		        }else if($_SESSION['profile']['jeton']==3){
		            $role = 'Administrateur';
		        }else $role = 'simple utilisateur';
		        $urlPannel = ControleurUrl::urlId('pannel', 0);
		        $html = <<<html
		<!DOCTYPE html>
		<html lang="fr">
		<head>
		  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		  <title>MyWhishlist</title>
		  <link rel="stylesheet" href="/web/css/style.css">


		</head>
		<body>

		<div class="container">

		<header>
		   <h1>Liste de Cadeaux</h1>
		</header>
		  
		<nav>
		  <ul>
		    <li><a href="$urlConnect">Se déconnecter</a></li>
		    <li><a href="/liste/display">Affiche mes listes</a></li>
		    <li><a href="/liste/create">Créer une liste</a></li>
html;
		    if(Authentication::checkAccessRights(Authentication::$ACCESS_SUP_ADMIN)){
		        $url = ControleurUrl::urlName('listes_all');
		        $html = $html . <<<html
		    <li><a href="$url">Afficher toutes les listes</a></li>
html;
		    }
		    $html = $html . <<<html
		    <li><a href="$urlPannel">Parametres</a></li>
		  </ul>
		</nav>

		<article>
		  $this->contenu
		</article>

		<footer>
		<div id="gauche">
		Bienvenu $role $user
		</div>
		<div id="droite">
		Copyright
		</div>

		</footer>

		</div>
		</body>
		</html>
html;
		}
		return $html;
	}

}