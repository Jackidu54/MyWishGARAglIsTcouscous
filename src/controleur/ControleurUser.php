<?php
namespace mywishlist\controleur;

use mywishlist\vue\VueInscription;

class ControleurUser
{
	public function afficherForm(){
		$vue = new VueInscription(null,null);
		echo $vue->render();
	}

	public function afficherPannel(){
		$vue = new VueConfig(null,null);
		echo $vue->render();
	}
}