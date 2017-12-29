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
		$select = $_SESSION['profile']['jeton'];
		$vue = new VueConfig($select,null);
		echo $vue->render();
	}
}