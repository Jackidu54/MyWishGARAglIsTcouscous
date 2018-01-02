<?php
namespace mywishlist\controleur;

use mywishlist\vue\VueConfig;
use mywishlist\vue\VueInscription;
use mywishlist\Controleur\Authentication;
use mywishlist\models\User;
use mywishlist\models\Liste;
use mywishlist\models\Guest;
use mywishlist\models\Partage;

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
		$listes = Liste::select()->where('user_id', '=', $user->id)->get();
		if($_SESSION['profile']['droit']>$user->droit){
			foreach($listes as $liste){
				$guests = Guest::select()->where('id_liste', '=', $liste->no)->get();
				foreach ($guests as $value) {
					$value->delete();
				}
				$liste->delete();
			}
			$user->delete();
		}
	}
	
	public function afficherPanelPartage($id_liste){
	    $vue = new VueInscription(VueInscription::$CONNECT_PARTAGE,$id_liste);
	    echo $vue->render();
	}
	public function inscrirePartage($id,$mail){
	    filter_var($mail, FILTER_VALIDATE_EMAIL);
	    if(isset($mail) && isset($id)){
	        $id=Liste::select()->where('token','=',$id)->first()->no;
	        $p=new Partage();
	        $p->id_liste=$id;
	        $p->email=$mail;
	        $p->save();
	        $_SESSION['partage']=$id_liste;
	    }
	}
}