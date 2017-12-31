<?php
namespace mywishlist\vue;

use mywishlist\controleur\ControleurUrl;

class VueInscription
{

	public static $CONNECT=1;
	public static $INSCRIPT=2;

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
		<title>MyWhishlist</title>
		<link rel="stylesheet" href="/web/css/style.css">
		<body class="bodyinscr">
		
		<header>
	    <h1>Liste de Cadeaux</h1>
		</header>
html;
		

		if($this->selecteur == VueInscription::$CONNECT)
		{

		$contenu = $contenu . <<<eof
		<div class="login-page">
		  <div class="form">
		    <form class="login-form" method="post" action="$urlConne">
		      <input type="text" name="pseudo" placeholder="username"/>
		      <input type="password" name="pass" placeholder="password"/>
		      <button>login</button>
		      <p class="message">Non enregistré? <a href="/user/inscription">Créer un compte</a></p>
		    </form>
		  </div>
		</div>

eof;
		
		}

		else if($this->selecteur == VueInscription::$INSCRIPT){
			$contenu = $contenu . <<<eof
			<div class="login-page">
			  <div class="form">
			    <form class="login-form" method="post" action="$urlCreer">
		    		<input type="text" id="pseudo" name="pseudo" placeholder="pseudo">
					<input type="password" id="pass" name="pass" placeholder="mot de passe">
					<input type="password" id="pass" name="passVerif" placeholder="confirmer">
					<input type="email" id="mail" name="mail" placeholder="adresse mail">
			      <button>create</button>
			      <p class="message">Déjà enregistré? <a href="/user/connection">Se connecter</a></p>
			    </form>
			  </div>
			</div>
eof;
		}

		$contenu = $contenu . <<<html
		 
		
		<footer>
		<div id="gauche">
		Petit message de paix d'amour et d'amitié
		</div>
		<div id="droite">
		Copyright
		</div>
		</footer>
		

		<script>
		$('.message a').click(function(){
		   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
		});
		</script>

		</body>
		</html>
html;

        return $contenu;
   	}
}