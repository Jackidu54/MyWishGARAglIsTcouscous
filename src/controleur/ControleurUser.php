<?php
namespace mywishlist\controleur;

use mywishlist\vue\VueConfig;
use mywishlist\vue\VueInscription;
use mywishlist\Controleur\Authentication;
use mywishlist\models\User;
use mywishlist\models\Categorie;

class ControleurUser
{
	public function afficherFormConnect(){
		$vue = new VueInscription(VueInscription::$CONNECT,null);
		echo $vue->render();
	}

	public function afficherFormInscript(){
		$vue = new VueInscription(VueInscription::$INSCRIPT,null);
		echo $vue->render();
	}

	public function afficherPannel($id){
		$users = User::select()->where('droit', '<', $_SESSION['profile']['droit'])->orderBy('pseudo')->get();
		$select = $_SESSION['profile']['droit'];
		$vue = new VueConfig($select,$id);
		$vue->setUsers($users);
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

	public function changerDroit($id){
		$app = \Slim\SLim::getInstance();
		$user = User::select()->where('id', '=', $id)->first();
		$user->droit = $app->request->post('newRole');
		$user->save();
	}

	public function supprimerUser($id){
		$user = User::select()->where('id', '=', $id)->first();
		if($_SESSION['profile']['droit']>$user->droit){
			
			$user->delete();
		}
	}
	

	

	
}