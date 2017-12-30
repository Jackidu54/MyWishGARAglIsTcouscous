<?php
namespace mywishlist\controleur;

use mywishlist\vue\VueConfig;
use mywishlist\vue\VueInscription;
use mywishlist\Controleur\Authentication;
use mywishlist\models\User;

class ControleurUser
{
	public function afficherForm(){
		$vue = new VueInscription(null,null);
		echo $vue->render();
	}

	public function afficherPannel($id){
		$select = $_SESSION['profile']['jeton'];
		$vue = new VueConfig($select,$id);
		echo $vue->render();
	}

	public function changePass($pseudo, $pass, $newPass, $passVerif){
		$app = \Slim\Slim::getInstance();
		if($newPass == $passVerif){
			Authentication::authenticate($_SESSION['profile']['pseudo'], $pass, Authentication::$OPTION_CHANGEPASS, $newPass);
			$code = VueConfig::$OK;
			$app->redirect('/user/pannel/'.$code);
		}else{
			$code = VueConfig::$ERR_VERIF;
			$app->redirect('/user/pannel/'.$code);
		}
	}
}