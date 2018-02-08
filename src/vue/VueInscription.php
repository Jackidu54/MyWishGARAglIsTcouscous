<?php
namespace mywishlist\vue;

use mywishlist\controleur\ControleurUrl;

class VueInscription
{

    public static $CONNECT = 1;

    public static $INSCRIPT = 2;

    public static $CONNECT_PARTAGE = 3;

    private $model;

    private $selecteur;

    function __construct($select, $model)
    {
        $this->model = $model;
        $this->selecteur = $select;
    }

    function render()
    {
        $app = \Slim\Slim::getInstance();
        $contenu = "";
        $urlCreer = ControleurUrl::urlName('creer_user');
        $urlConne = ControleurUrl::urlName('connect_user');
        $urlFormConnection=ControleurUrl::urlName('connection');
        $urlFormCreation= ControleurUrl::urlName('inscription');
        $id = $this->model;
        $urlPartage = $app->urlFor('creer_partage', [
            'id' => $id
        ]);
        
        $contenu = $contenu . <<<html
        <!DOCTYPE html>
		<html lang="fr">
		<head>
	  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>MyWhishlist</title>
		<link rel="stylesheet" href="/www/jacque14u/ProjetPhp/web/css/style.css">
		<body class="bodyinscr">
		

		<header>
        <img src="/www/jacque14u/ProjetPhp/web/img/gift.png">
        <span><h1>Liste de Cadeaux</h1></span>
		</header>
html;
        
        if ($this->selecteur == VueInscription::$CONNECT) {
            
            $contenu = $contenu . <<<eof
        <center><div class="login-image" style="display: inline-block; margin-top:-30px" width="30%">
        <img src="/www/jacque14u/ProjetPhp/web/img/fondConnection.png" style="width:420px;height:290px;">
        </div>
		<div class="login-page" style="display: inline-block" width="30%">
		  <div class="form">
		    <form class="login-form" method="post" action="$urlConne">
		      <input type="text" name="pseudo" placeholder="username"/>
		      <input type="password" name="pass" placeholder="password"/>
		      <button>login</button>
		      <p class="message">Non enregistré? <a href="$urlFormCreation">Créer un compte</a></p>
		    </form>
		  </div>
		</div>
        </center>
eof;
        } 
        else if ($this->selecteur == VueInscription::$INSCRIPT) {
            $contenu = $contenu . <<<eof
			<div class="login-page">
			  <div class="form">
			    <form class="login-form" method="post" action="$urlCreer">
		    		<input type="text" id="pseudo" name="pseudo" placeholder="pseudo">
					<input type="password" id="pass" name="pass" placeholder="mot de passe">
					<input type="password" id="pass" name="passVerif" placeholder="confirmer">
					<input type="email" id="mail" name="mail" placeholder="adresse mail">
			      <button>create</button>
			      <p class="message">Déja  enregistré? <a href="$urlFormConnection">Se connecter</a></p>
			    </form>
			  </div>
			</div>
eof;
        } else if ($this->selecteur == VueInscription::$CONNECT_PARTAGE) {
            $contenu = $contenu . <<<eof
			<div class="login-page">
			  <div class="form">
			    <form class="login-form" method="post" action="$urlPartage">
					<input type="email" id="mail" name="mail" placeholder="adresse mail">
			      <button>create</button>
			    </form>
			  </div>
			</div>
eof;
        }
        
        $contenu = $contenu . <<<html
		 
		
		<footer>
		<div id="gauche">
		
		</div>
		<div id="droite">
		&#169; Copyright 2018
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
        
        return utf8_encode($contenu);
    }
}